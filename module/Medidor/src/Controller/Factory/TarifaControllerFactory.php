<?php
namespace Medidor\Controller\Factory;

use Interop\Container\ContainerInterface;
use Medidor\Controller\TarifaController;
use Zend\ServiceManager\Factory\FactoryInterface;

class TarifaControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new TarifaController($entityManager);
    }
}