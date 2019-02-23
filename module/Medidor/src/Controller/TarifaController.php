<?php
namespace Medidor\Controller;

use Medidor\Entity\Tarifa;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TarifaController extends AbstractActionController
{
    /**
     * Entity manager
     * @var Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $tarifas = $this->entityManager->getRepository(Tarifa::class)->findAll();

        return new ViewModel([
            'tarifas' => $tarifas,
        ]);
    }

    public function addAction()
    {
        $steps = [
            1 => [150   => .793],
            2 => [130   => .956],
            3 => [10000 => 2.802],
        ];

        $tarifa = new Tarifa();
        $tarifa->setName('1');
        $tarifa->setAcronym('1');
        $tarifa->setFixedCost(0);
        $tarifa->setSteps($steps);

        $this->entityManager->persist($tarifa);
        $this->entityManager->flush();
    }
}