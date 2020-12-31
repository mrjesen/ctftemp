<?php
return [
    'service_manager' => [
        'aliases' => [
            'Zend\\Log\\Logger' => 'Laminas\\Log\\Logger',
            'console' => 'ConsoleAdapter',
            'Console' => 'ConsoleAdapter',
            'ConsoleDefaultRenderingStrategy' => 'Laminas\\Mvc\\Console\\View\\DefaultRenderingStrategy',
            'ConsoleRenderer' => 'Laminas\\Mvc\\Console\\View\\Renderer',
            'Zend\\Mvc\\Console\\View\\DefaultRenderingStrategy' => 'Laminas\\Mvc\\Console\\View\\DefaultRenderingStrategy',
            'Zend\\Mvc\\Console\\View\\Renderer' => 'Laminas\\Mvc\\Console\\View\\Renderer',
            'HttpRouter' => 'Laminas\\Router\\Http\\TreeRouteStack',
            'router' => 'Laminas\\Router\\RouteStackInterface',
            'Router' => 'Laminas\\Router\\RouteStackInterface',
            'RoutePluginManager' => 'Laminas\\Router\\RoutePluginManager',
            'Zend\\Router\\Http\\TreeRouteStack' => 'Laminas\\Router\\Http\\TreeRouteStack',
            'Zend\\Router\\RoutePluginManager' => 'Laminas\\Router\\RoutePluginManager',
            'Zend\\Router\\RouteStackInterface' => 'Laminas\\Router\\RouteStackInterface',
            'ValidatorManager' => 'Laminas\\Validator\\ValidatorPluginManager',
            'Zend\\Validator\\ValidatorPluginManager' => 'Laminas\\Validator\\ValidatorPluginManager'
        ],
        'abstract_factories' => [
            'Laminas\\Log\\LoggerAbstractServiceFactory',
            'Laminas\\Log\\PsrLoggerAbstractAdapterFactory'
        ],
        'factories' => [
            'Laminas\\Log\\Logger' => 'Laminas\\Log\\LoggerServiceFactory',
            'LogFilterManager' => 'Laminas\\Log\\FilterPluginManagerFactory',
            'LogFormatterManager' => 'Laminas\\Log\\FormatterPluginManagerFactory',
            'LogProcessorManager' => 'Laminas\\Log\\ProcessorPluginManagerFactory',
            'LogWriterManager' => 'Laminas\\Log\\WriterPluginManagerFactory',
            'ConsoleAdapter' => 'Laminas\\Mvc\\Console\\Service\\ConsoleAdapterFactory',
            'ConsoleExceptionStrategy' => 'Laminas\\Mvc\\Console\\Service\\ConsoleExceptionStrategyFactory',
            'ConsoleRouteNotFoundStrategy' => 'Laminas\\Mvc\\Console\\Service\\ConsoleRouteNotFoundStrategyFactory',
            'ConsoleRouter' => 'Laminas\\Mvc\\Console\\Router\\ConsoleRouterFactory',
            'ConsoleViewManager' => 'Laminas\\Mvc\\Console\\Service\\ConsoleViewManagerFactory',
            'Laminas\\Mvc\\Console\\View\\DefaultRenderingStrategy' => 'Laminas\\Mvc\\Console\\Service\\DefaultRenderingStrategyFactory',
            'Laminas\\Mvc\\Console\\View\\Renderer' => 'Laminas\\ServiceManager\\Factory\\InvokableFactory',
            'Laminas\\Router\\Http\\TreeRouteStack' => 'Laminas\\Router\\Http\\HttpRouterFactory',
            'Laminas\\Router\\RoutePluginManager' => 'Laminas\\Router\\RoutePluginManagerFactory',
            'Laminas\\Router\\RouteStackInterface' => 'Laminas\\Router\\RouterFactory',
            'Laminas\\Validator\\ValidatorPluginManager' => 'Laminas\\Validator\\ValidatorPluginManagerFactory'
        ],
        'delegators' => [
            'ControllerManager' => [
                'Laminas\\Mvc\\Console\\Service\\ControllerManagerDelegatorFactory'
            ],
            'Request' => [
                'Laminas\\Mvc\\Console\\Service\\ConsoleRequestDelegatorFactory'
            ],
            'Response' => [
                'Laminas\\Mvc\\Console\\Service\\ConsoleResponseDelegatorFactory'
            ],
            'Laminas\\Router\\RouteStackInterface' => [
                'Laminas\\Mvc\\Console\\Router\\ConsoleRouterDelegatorFactory'
            ],
            'Laminas\\Mvc\\SendResponseListener' => [
                'Laminas\\Mvc\\Console\\Service\\ConsoleResponseSenderDelegatorFactory'
            ],
            'ViewHelperManager' => [
                'Laminas\\Mvc\\Console\\Service\\ConsoleViewHelperManagerDelegatorFactory'
            ],
            'ViewManager' => [
                'Laminas\\Mvc\\Console\\Service\\ViewManagerDelegatorFactory'
            ]
        ]
    ],
    'controller_plugins' => [
        'aliases' => [
            'CreateConsoleNotFoundModel' => 'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel',
            'createConsoleNotFoundModel' => 'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel',
            'createconsolenotfoundmodel' => 'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel',
            'Laminas\\Mvc\\Controller\\Plugin\\CreateConsoleNotFoundModel::class' => 'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel',
            'Zend\\Mvc\\Controller\\Plugin\\CreateConsoleNotFoundModel::class' => 'Laminas\\Mvc\\Controller\\Plugin\\CreateConsoleNotFoundModel::class',
            'Zend\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel' => 'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel'
        ],
        'factories' => [
            'Laminas\\Mvc\\Console\\Controller\\Plugin\\CreateConsoleNotFoundModel' => 'Laminas\\ServiceManager\\Factory\\InvokableFactory'
        ]
    ],
    'console' => [
        'router' => [
            'routes' => []
        ]
    ],
    'route_manager' => [],
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'Laminas\\Router\\Http\\Literal',
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => 'Application\\Controller\\IndexController',
                        'action' => 'index'
                    ]
                ]
            ],
            'application' => [
                'type' => 'Laminas\\Router\\Http\\Segment',
                'options' => [
                    'route' => '/application[/:action]',
                    'defaults' => [
                        'controller' => 'Application\\Controller\\IndexController',
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            'Application\\Controller\\IndexController' => 'Laminas\\ServiceManager\\Factory\\InvokableFactory'
        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => '/var/www/html/module/Application/config/../view/layout/layout.phtml',
            'application/index/index' => '/var/www/html/module/Application/config/../view/application/index/index.phtml',
            'error/404' => '/var/www/html/module/Application/config/../view/error/404.phtml',
            'error/index' => '/var/www/html/module/Application/config/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            '/var/www/html/module/Application/config/../view'
        ]
    ]
];