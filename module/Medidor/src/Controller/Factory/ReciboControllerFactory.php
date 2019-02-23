<?php
namespace Medidor\Controller\Factory;

use Interop\Container\ContainerInterface;
use Medidor\Controller\ReciboController;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReciboControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        return new ReciboController($entityManager);
    }
}