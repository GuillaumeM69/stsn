<?php
return array(
    'service_manager' => array(
        'factories' => array(
                'Demand\AccountForm' => function($sm){
                    $form = new Demand\Form\AccountForm('account'); 
                    $form->add(array(
                        'name' => 'account'
                        ,'type' => 'Demand\Form\AccountFieldset'
                        ,'options' => array(
                            'use_as_base_fieldset' => false
                        ) ));
                    return $form;
                },
                ),
            ),

            'controllers' => array(
                'invokables' => array(
                    'Demand\Controller\Account' => 'Demand\Controller\AccountController',
                    'Demand\Controller\Home' => 'Demand\Controller\HomeController',
                ),
            ),

            'router' => array(
                'routes' => array(

                    'account\index' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/demand/account/index',
                            'defaults' => array(
                                'controller' => 'Demand\Controller\Account',
                                'action' => 'index',
                            ),
                        ),
                    ),

                    'demand\index' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/demand/index',
                            'defaults' => array(
                                'controller' => 'Demand\Controller\Home',
                                'action' => 'index',
                            ),
                        ),
                    ),
                ),
            ),

            'view_manager' => array(
                'template_map' => array(
                    'istesene/layout/admin'   => __DIR__ . '/../view/layout/admin.phtml',
                    'istesene/layout/site'   => __DIR__ . '/../view/layout/site.phtml',
                ),
                'template_path_stack' => array(
                    __DIR__ . '/../view',
                ),
            )
        );
