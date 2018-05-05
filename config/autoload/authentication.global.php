<?php

use Application\Entity\Role;

return [
    'zend_authentication' => [
        'layout' => 'zetta/zend-authentication/layout/default',
        'templates' => [
            'password-recover' => 'zetta/zend-authentication/password-recover',
            'recover' => 'zetta/zend-authentication/recover',
            'signin' => 'zetta/zend-authentication/signin',
            'signup' => 'zetta/zend-authentication/signup',
        ],
        'routes' => [
            'home' => [
                'name' => 'home',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'redirect' => [
                'name' => 'home',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'authenticate' => [
                'name' => 'authentication/authenticate',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'confirm-email' => [
                'name' => 'authentication/confirm-email',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'password-recover' => [
                'name' => 'authentication/password-recover',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'recover' => [
                'name' => 'authentication/recover',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'signin' => [
                'name' => 'authentication/signin',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'signout' => [
                'name' => 'authentication/signout',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'signup' => [
                'name' => 'authentication/signup',
                'params' => [],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'account' => [
                'name' => 'authentication/default',
                'params' => ['controller' => 'account'],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
            'password-change' => [
                'name' => 'authentication/default',
                'params' => ['controller' => 'account', 'action' => 'password-change'],
                'options' => [],
                'reuseMatchedParams' => false,
            ],
        ],
        'options' => [
            'identityClass' => Application\Entity\User::class,
            'credentialClass' => Application\Entity\Credential::class,
            'roleClass' => Role::class,
            'identityProperty' => 'username',
            'emailProperty' => 'email',
            'credentialProperty' => 'value',
            'credentialIdentityProperty' => 'user',
            'credentialTypeProperty' => 'type',
            'credentialType' => Application\Entity\Credential::TYPE_PASSWORD,
            'credentialCallable' => 'Application\Entity\Credential::check',
        ],
        'default' => [
            'signAllowed' => false,
            'role' => Role::ID_MEMBER,
        ],
        'acl' => [
            'defaultRole' => Role::GUEST,
            'roles' => [
                Role::GUEST => null,
                Role::MEMBER => [Role::GUEST],
                Role::ADMIN => [Role::MEMBER],
            ],
            'resources' => [
                'allow' => [
                    'Application\Controller\Index' => [
                        '' => [Role::MEMBER],
                    ],
                    'Application\Controller\Users' => [
                        '' => [Role::ADMIN],
                    ],
                    'Zetta\ZendAuthentication\Controller\Account' => [
                        '' => [Role::MEMBER],
                    ],
                    'Zetta\ZendAuthentication\Controller\Auth' => [
                        'authenticate' => [Role::GUEST],
                        'confirm-email' => [Role::GUEST],
                        'password-recover' => [Role::GUEST],
                        'recover' => [Role::GUEST],
                        'signin' => [Role::GUEST],
                        'signout' => [Role::GUEST],
                        'signup' => [Role::GUEST],
                    ],
                    'Zetta\ZendAuthentication\Menu' => [
                        'account' => [Role::MEMBER],
                    ]
                ],
                'deny' => [
                    'Zetta\ZendAuthentication\Controller\Auth' => [
                        'signup' => [Role::MEMBER],
                    ],
                ],
            ],
        ],
    ],
];
