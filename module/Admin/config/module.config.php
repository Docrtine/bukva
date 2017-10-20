<?php
return array(


    'controllers'  => array(
        'invokables' => array(
            'Admin\Controller\Index'    =>   'Admin\Controller\IndexController',
            'Admin\Controller\Category'                  =>   'Admin\Controller\CategoryController',
            'Admin\Controller\Books'                  =>   'Admin\Controller\BooksController',
        ),
    ),
    'router'       => array(
                'routes' => array(
                    'admin' => array(
                        'type'          => 'Literal',
                        'options'       => array(
                            // Измените в соответствии с вашим модулем
                            'route'    => '/admin/',
                            'defaults' => array(
                            // Задайте это значение согласно пространству
                            // имен, в котором находятся ваши контроллеры
                            '__NAMESPACE__' => 'Admin\Controller',
                            'controller'    => 'Index',
                            'action'        => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'category' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'category/[:action/][:id/]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Category',
                                        'action' => 'index'
                                    )
                                )
                            ),
                            'books' => array(
                                'type' => 'segment',
                                'options' => array(
                                    'route' => 'books/[:action/][:id/]',
                                    'defaults' => array(
                                        'controller' => 'Admin\Controller\Books',
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
            'admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'pagination_control' => __DIR__ .'/../view/layout/pagination_control.phtml',
        ),
    ),
    'strategies'   => array(
        'viewJsonStrategy'
    ),
);