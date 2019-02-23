<?php
namespace Medidor\Controller;

use Medidor\Entity\Medidor;
use Medidor\Entity\Recibo;
use Medidor\Form\ReciboForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReciboController extends AbstractActionController
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

        $recibos = $this->entityManager->getRepository(Recibo::class)
            ->findBy(['medidor' => $medidor]);

        return new ViewModel([
            'recibos' => $recibos,
        ]);
    }

    public function addAction()
    {
        $medidorId = (int) $this->params()->fromRoute('id', 0);
        if (0 === $medidorId) {
            return $this->redirect()->toRoute('medidor');
        }

        $form = new ReciboForm();
        $form->get('submit')->setValue('Add');
        $form->get('medidor_id')->setValue($medidorId);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();
                // Get medidor by id.
                $medidor = $this->entityManager->getRepository(Medidor::class)
                    ->find((int)$data['medidor_id']);
                if (null === $medidor) {
                    echo "Not medidor found!";
                    exit();
                }

                // Update lecturaRecibo and fechaRecibo to medidor.
                // $medidor->setLecturaRecibo($data['lecturaActual']);
                // $medidor->setFechaRecibo(new \DateTime($data['periodoHasta']));

                $recibo = new Recibo();
                $recibo->setMedidor($medidor);
                $recibo->setBimestre($data['bimestre']);
                $recibo->setPeriodoDesde(new \DateTime($data['periodoDesde']));
                $recibo->setPeriodoHasta(new \DateTime($data['periodoHasta']));
                $recibo->setLecturaAnterior($data['lecturaAnterior']);
                $recibo->setLecturaActual($data['lecturaActual']);
                $recibo->setImporte($data['importe']);
                $this->entityManager->persist($recibo);
                $this->entityManager->flush();

                // Redirect to medidor detail.
                return $this->redirect()->toRoute('medidor', ['action' => 'detail', 'id' =>$data['medidor_id']]);
            }
        }
        return array('form' => $form);
    }
}