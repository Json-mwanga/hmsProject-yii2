<?php
use yii\filters\Cors;
use yii\web\Response;
use Yii;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'layout' => '@vendor/hail812/yii2-adminlte3/src/views/layouts/main',

    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // Allow JSON bodies (for fetch/axios)
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'format' => Response::FORMAT_HTML,
            // Ensure CORS headers are present on *every* response (not just preflight)
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                $origin   = Yii::$app->request->headers->get('Origin');
                $allowedOrigins = [
                    'http://localhost:8080',
                    'http://127.0.0.1:8080',
                    'http://localhost:5173',
                    'http://127.0.0.1:5173',
                ];
                if ($origin && in_array($origin, $allowedOrigins, true)) {
                    $response->headers->set('Access-Control-Allow-Origin', $origin);
                    $response->headers->set('Access-Control-Allow-Credentials', 'true');
                    $response->headers->set('Vary', 'Origin');
                    // Optional but handy if you need to read custom headers client-side
                    $response->headers->set('Access-Control-Expose-Headers', 'X-Pagination-Total-Count, X-Pagination-Page-Count');
                }
            },
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
                ],
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
                // If you truly need cross-site cookie in HTTPS env:
                // 'sameSite' => yii\web\Cookie::SAME_SITE_NONE,
                // 'secure' => true,
            ],
        ],
        'session' => [
            'name' => 'advanced-backend',
            // If you plan to share session cross-site over HTTPS only:
            // 'cookieParams' => [
            //     'httpOnly' => true,
            //     'sameSite' => yii\web\Cookie::SAME_SITE_NONE,
            //     'secure' => true,
            // ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['login'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],

    // Global CORS behavior (handles OPTIONS and sets base headers)
    'as corsFilter' => [
        'class' => Cors::class,
        'cors' => [
            'Origin' => [
                'http://localhost:8080',
                'http://127.0.0.1:8080',
                'http://localhost:5173',
                'http://127.0.0.1:5173',
            ],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
            'Access-Control-Allow-Credentials' => true,
            'Access-Control-Max-Age' => 86400,
        ],
    ],

    // Short-circuit OPTIONS early (avoids CSRF blocking preflight)
    'on beforeRequest' => function () {
        $request = Yii::$app->request;
        if ($request->isOptions) {
            Yii::$app->response->statusCode = 204;
            Yii::$app->end();
        }
    },

    'params' => $params,
];
