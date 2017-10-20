<?php
return array(

    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
            'user_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/User/Entity',
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    'User\Entity' => 'user_entity'
                )
            )
        ),
         'authentication' => array(
    'orm_default' => array(
        'object_manager' => 'Doctrine\ORM\EntityManager',
        'identity_class' => 'User\Entity\Users',
        'identity_property' => 'email',
        'credential_property' => 'password',
    ),
),
    ),

    'controllers'  => array(
        'invokables' => array(
            'User\Controller\Index'    =>
                'User\Controller\IndexController',
            'User\Controller\Register' =>
                'User\Controller\RegisterController',
            'User\Controller\Auth' =>
                'User\Controller\AuthController',
            'User\Controller\Guest' =>
                'User\Controller\GuestController',
        ),
    ),
    'router'       => array(
        'routes' => array(
            'user' => array(
                'type'          => 'Literal',
                'options'       => array(
                    // Измените в соответствии с вашим модулем
                    'route'    => '/user/',
                    'defaults' => array(
                        // Задайте это значение согласно пространству
                        // имен, в котором находятся ваши контроллеры
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'register' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'register/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'User\Controller\Register',
                                'action' => 'index'
                            )
                        )
                    ),
                    'auth' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'auth/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'User\Controller\Auth',
                                'action' => 'index'
                            )
                        )
                    ),
                    'guest' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route' => 'guest/',
                            'defaults' => array(
                                'controller' => 'User\Controller\Guest',
                                'action' => 'index'
                            )
                        )
                    ),
                ),
                // <child_routes
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
        'strategies'   => array(
            'viewJsonStrategy'
        ),
    ),

);