<?php
/**
 * @link      http://github.com/zetta-code/zend-skeleton-application for the canonical source repository
 * @copyright Copyright (c) 2018 Zetta Code
 */

return [
    'navigation' => [
        'default' => [
            [
                'label' => _('Home'),
                'class' => 'nav-link',
                'route' => 'home',
                'resource' => 'Application\Controller\Index',
                'privilege' => 'index',
            ],
            [
                'label' => _('Users'),
                'class' => 'nav-link',
                'route' => 'home/default',
                'controller' => 'users',
                'resource' => 'Application\Controller\Users',
                'privilege' => 'index',
            ],
            [
                'type' => \Zetta\ZendBootstrap\Navigation\Page\Avatar::class,
                'label' => '<b class="caret"></b>',
                'uri' => '#',
                'liClass' => 'user-nav',
                'resource' => 'Zetta\ZendAuthentication\Menu',
                'privilege' => 'account',
                'pages' => [
                    [
                        'type' => \Zetta\ZendBootstrap\Navigation\Page\Avatar::class,
                        'no-image' => true,
                        'label' => '<b class="caret"></b>',
                        'uri' => '',
                        'liClass' => 'user-info',
                        'resource' => 'Zetta\ZendAuthentication\Menu',
                        'privilege' => 'account',
                    ],
                    [
                        'label' => _('Profile'),
                        'class' => 'dropdown-item',
                        'addon-left' => '<i class="fa fa-user fa-fw"></i> ',
                        'route' => 'authentication/default',
                        'controller' => 'account',
                        'resource' => 'Zetta\ZendAuthentication\Controller\Account',
                        'privilege' => 'index',
                    ],
                    [
                        'label' => _('Sign out'),
                        'class' => 'dropdown-item',
                        'addon-left' => '<i class="fa fa-sign-out fa-fw"></i> ',
                        'route' => 'authentication/signout',
                        'resource' => 'Zetta\ZendAuthentication\Controller\Auth',
                        'privilege' => 'signout',
                    ],
                ],
            ],
        ],
        'Breadcrumbs' => [
            [
                'label' => _('Home'),
                'route' => 'home',
                'pages' => [
                    [
                        'label' => _('Profile'),
                        'route' => 'authentication/default',
                        'controller' => 'account',
                    ],
                    [
                        'label' => _('Users'),
                        'route' => 'home/default',
                        'controller' => 'users',
                    ],
                ]
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
];
