<?php
return array(


    'controllers' => array(
        'invokables' => array(
            'Books\Controller\Index' => 'Books\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'books' => array(
                'type' => 'segment',
                'options' => array(
                    // Измените в соответствии с вашим модулем
                    'route' => '/books/[:action/][:id/]',
                    'defaults' => array(
                        // Задайте это значение согласно пространству
                        // имен, в котором находятся ваши контроллеры
                        '__NAMESPACE__' => 'Books\Controller',
                        'controller' => 'Index',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'category' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'category/[:action/][:id/]',
                            'defaults' => array(
                                'controller' => 'Books\Controller\Category',
                                'action' => 'index'
                            )
                        )
                    ),
                ), // <child_routes
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'books' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'pagination_control' => 'Module/Admin/view/layout/pagination_control.phtml',
        ),
    ),
    'strategies' => array(
        'viewJsonStrategy'
    ),
);