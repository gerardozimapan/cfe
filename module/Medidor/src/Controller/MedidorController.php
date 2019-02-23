<?php

namespace Medidor\Controller;

use Medidor\Entity\Lectura;
use Medidor\Entity\Medidor;
use Medidor\Entity\Recibo;
use Medidor\Form\LecturaForm;
use Medidor\Form\MedidorForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class MedidorController extends AbstractActionController
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function indexAction()
    {
        $medidores = $this->entityManager->getRepository(Medidor::class)->findAll();
        
        return new ViewModel([
            'medidores' => $medidores,
        ]);
    }
    
    public function addAction()
    {
        $form = new MedidorForm();
        $form->get('submit')->setValue('Add');
 
        $request = $this->getRequest();
        if ($request->isPost()) {
            $medidor = new Medidor();
            $form->setData($request->getPost());
 
            if ($form->isValid()) {
                $medidor->exchangeArray($form->getData());
                $this->entityManager->persist($medidor);
                $this->entityManager->flush();
 
                // Redirect to list of medidores
                return $this->redirect()->toRoute('medidor');
            }
        }
        return array('form' => $form);
    }
    
    public function leerAction()
    {
        $form = new LecturaForm();
        $form->get('submit')->setValue('Agregar');
        $form->get('fecha')->setValue(date('Y-m-d H:i:00'));
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $lectura = new Lectura();
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
                // Guardamos la lectura y los calculos en el medidor.
                $medidor = $this->entityManager->getRepository(Medidor::class)->findOneById($data['medidor']);

                // Necesitamos los datos del último recibo para los calculos.
                $lastRecibo = $this->entityManager->getRepository(Recibo::class)->getLast($data['medidor']);
                // Consumo desde el último recibo.
                $consumoActual = (int) $data['medicion'] - $lastRecibo->getLecturaActual();
                // Dias transcurridos desde la fecha del último recibo registrado.
                $diasTranscurridos = $this->dateDifference($data['fecha'], $lastRecibo->getPeriodoHasta()->format('Y-m-d'));
        
                $medidor->setUltimaLectura($data['medicion']);
                $medidor->setFechaUltimaLectura(new \DateTime($data['fecha']));
                $medidor->setConsumoActual($consumoActual);
                $costoActual = $this->calculateCostoActual($medidor->getTarifa(), $consumoActual);
                $medidor->setCostoActual($costoActual);
                $costoProyectado = $this->calculateCostoProyectado($medidor->getTarifa(), $consumoActual, $diasTranscurridos);
                $medidor->setCostoProyectado($costoProyectado);
                
                $lectura->setMedidor($medidor);
                $lectura->setMedicion($data['medicion']);
                $lectura->setFecha(new \DateTime($data['fecha']));
                $this->entityManager->persist($lectura);
                $this->entityManager->flush();
                
                return $this->redirect()->toRoute('medidor');
            } else {
                echo "Not Valid!";
                $data = $form->getData();
                var_dump($data);
                var_dump($form->isValid());
                var_dump($form->getMessages());
                exit;
            }
        }
        
        $medidorId = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $medidorId) {
            return $this->redirect()->toRoute('medidor');
        }
        
        try {
            $medidor = $this->entityManager->getRepository(Medidor::class)->findOneById($medidorId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('medidor');
        }
        
        return new ViewModel([
            'form'    => $form,
            'medidor' => $medidor,
        ]);
    }
    
    public function detailAction()
    {
        $medidorId = (int) $this->params()->fromRoute('id', 0);
        if (0 === $medidorId) {
            return $this->redirect()->toRoute('medidor');
        }
        
        try {
            $medidor = $this->entityManager->getRepository(Medidor::class)->findOneById($medidorId);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('medidor');
        }

        
        return new ViewModel([
            'medidor' => $medidor,
        ]);
    }
    
    private function calculateCostoActual($tarifa, $consumoActual)
    {
        $tarifas = [
            /*
            1 => [
                1 => [150   => .793],
                2 => [130   => .956],
                3 => [10000 => 2.802],
            ],
            2 => [
                1 => [100   => 2.610],
                2 => [100   => 3.147],
                3 => [10000 => 3.470],
            ],
            1 => [
                1 => [150   => .793],
                2 => [130   => .956],
                3 => [10000 => 2.802],
            ],
            2 => [
                1 => [100   => 2.597],
                2 => [100   => 3.147],
                3 => [10000 => 3.470],
            ],
            */
            1 => [
                1 => [150   => .793],
                2 => [130   => .956],
                3 => [10000 => 2.802],
            ],
            2 => [
                1 => [100   => 3.676],
                2 => [100   => 3.113],
                3 => [10000 => 3.431],
            ],

        ];
        $costoActual = 0.0;
        $porCalcular = $consumoActual;
        $tarifaAplicable = $tarifas[$tarifa];
        for ($step = 1; $step < 4; $step++) {
            $actualStep = $tarifaAplicable[$step];
            $limit = key($actualStep);
            $costo = $actualStep[$limit];
            
            if ( $porCalcular == 0 ) {
                break;
            }
            
            $c = 0;
            if ( $limit <= $porCalcular  ) {
                $c = $limit * $costo;
                $porCalcular = $porCalcular - $limit;
            } else {
                $c = $porCalcular * $costo;
                $porCalcular = 0;
            }
            $costoActual += $c;
            
        }
        if ($tarifa == 2) {
            //$cargoFijo = 2 * 65.930;
            //$cargoFijo = 2 * 65.280;
            //$cargoFijo = 2 * 64.520;
            //$cargoFijo = 2 * 64.740;
            $cargoFijo = 2 * 65.450;
            $costoActual += $cargoFijo;
        }
        $costoActual *= 1.16; 
        return $costoActual;
    }
    
    private function calculateCostoProyectado($tarifa, $consumoActual, $diasTranscurridos)
    {
        $consumoPromedioDiario = $consumoActual / $diasTranscurridos;
        $consumoProyectado = (int)($consumoPromedioDiario * 60);
        $costoProyectado = $this->calculateCostoActual($tarifa, $consumoProyectado);
        return $costoProyectado;
    }

    /**
     * @return int dias de diferencia 
     */ 
    private function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
       
        $interval = date_diff($datetime1, $datetime2);
       
        return $interval->format($differenceFormat);
       
    }
}