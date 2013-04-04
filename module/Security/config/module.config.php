<?php
return array(
    'service_manager' => array(
        'factories' => array(
            'LoginForm' => function($sm){
                $form = new Security\Form\LoginForm('login'); 

                $form->add(array(
                    'name' => 'login'
                    ,'type' => 'Security\Form\LoginFieldset'
                    ,'options' => array(
                        'use_as_base_fieldset' => false
                    ) ));
                
                return $form;
            },

                'AccountForm' => function($sm){
                    $form = new Security\Form\LoginForm('account'); 

                    $form->add(array(
                        'name' => 'account'
                        ,'type' => 'Security\Form\AccountFieldset'
                        ,'options' => array(
                            'use_as_base_fieldset' => false
                        ) ));
                    
                    return $form;
                },
                ),
            ),

            'controllers' => array(
                'invokables' => array(
                    'Security\Controller\Login' => 'Security\Controller\LoginController',
                ),
            ),
            'router' => array(
                'routes' => array(
                    'security\index' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/security/index',
                            'defaults' => array(
                                'controller' => 'Security\Controller\Login',
                                'action' => 'index',
                            ),
                        ),
                    ),

                    'security\login' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/security/login',
                            'defaults' => array(
                                'controller' => 'Security\Controller\Login',
                                'action' => 'login',
                            ),
                        ),
                    ),

                    'security\logout' => array(
                        'type' => 'Zend\Mvc\Router\Http\Literal',
                        'options' => array(
                            'route' => '/security/logout',
                            'defaults' => array(
                                'controller' => 'Security\Controller\Login',
                                'action' => 'logout',
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
