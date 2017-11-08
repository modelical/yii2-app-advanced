<?php
/**
 * @link http://www.modelical.com/yii-template
 * @copyright Copyright (c) 2017 Modelical Consultoría S.L.
 * @license http://www.modelical.com/yii-template
 */

namespace api\components;

/**
 * Description of ActiveController
 *
 * @author Juan Ma <juanma@modelical.com>
 * @since 0.1.0
 */
class ActiveController extends \yii\rest\ActiveController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        unset($behaviors['authenticator']);

        $behaviors = \yii\helpers\ArrayHelper::merge(
                $behaviors,
                [
                    'corsFilter' => [
                        'class' => \yii\filters\Cors::className(),
//                        'cors' => [
//                            // http://www.yiiframework.com/doc-2.0/yii-filters-cors.html
//                            // restrict access to
//                            'Origin' => ['http://www.myserver.com', 'https://www.myserver.com'],
//                            'Access-Control-Request-Method' => ['POST', 'PUT'],
//                            // Allow only POST and PUT methods
//                            'Access-Control-Request-Headers' => ['X-Wsse'],
//                            // Allow only headers 'X-Wsse'
//                            'Access-Control-Allow-Credentials' => true,
//                            // Allow OPTIONS caching
//                            'Access-Control-Max-Age' => 3600,
//                            // Allow the X-Pagination-Current-Page header to be exposed to the browser.
//                            'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
//                        ],
                    ],
//                  'oauth2access' => [
//                      // Implement if scopes needed: https://github.com/ikaras/yii2-oauth2-rest-template/blob/master/application/api/components/filters/OAuth2AccessFilter.php
//                      'class' => \api\components\filters\OAuth2AccessFilter::className()
//                  ],
                    'authenticator' => [
                        'class' => \filsh\yii2\oauth2server\filters\auth\CompositeAuth::className(),
                        'authMethods' => [
                            \yii\filters\auth\HttpBearerAuth::className(),
//                            \yii\filters\auth\QueryParamAuth::className(),
                        ],
                        'except' => ['options'],
                    ],
                    'exceptionFilter' => [
                        'class' => \filsh\yii2\oauth2server\filters\ErrorToExceptionFilter::className()
                    ],
                ]
        );

        return $behaviors;
    }
}