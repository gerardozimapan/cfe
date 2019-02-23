<?php

namespace Medidor;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\MedidorController::class => Controller\Factory\MedidorControllerFactory::class,
            Controller\TarifaController::class  => Controller\Factory\TarifaControllerFactory::class,
            Controller\ReciboController::class  => Controller\Factory\ReciboControllerFactory::class,
        ],
    ],
    
    'router' => [
        'routes' => [
            'medidor' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/medidor[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\MedidorController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'tarifa' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/tarifa[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\TarifaController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'recibo' => [
                'type'    => Segment::class,
                'options' => [
                    'route'       => '/recibo[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ReciboController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    
    'view_manager' => [
        'template_path_stack' => [
            'medidor' => __DIR__ . '/../view',
        ],
    ],
    
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [ __DIR__ . '/../src/Entity' ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];