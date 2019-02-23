<?php
namespace Medidor\Controller\Factory;

use Interop\Container\ContainerInterface;
use Medidor\Controller\MedidorController;
use Zend\ServiceManager\Factory\FactoryInterface;

class MedidorControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        
        return new MedidorController($entityManager);
    }
}