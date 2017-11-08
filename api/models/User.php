<?php
/**
 * @link http://www.modelical.com/yii-template
 * @copyright Copyright (c) 2017 Modelical Consultoría S.L.
 * @license http://www.modelical.com/yii-template
 */

namespace api\models;

/**
 * Description of User
 *
 * @author Juan Ma <juanma@modelical.com>
 * @since 0.1.0
 */
class User extends \common\models\User implements \OAuth2\Storage\UserCredentialsInterface
{
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /* @var $module filsh\yii2\oauth2server\Module */
        $module = \Yii::$app->getModule('oauth2');
        
        $token = $module->getServer()->getResourceController()->getToken();

        return !empty($token['user_id']) ? static::findIdentity($token['user_id']) : null;
    }
    
    /**
     * @inheritdoc
     */
    public function checkUserCredentials($username, $password)
    {
        $user = static::findByUsername($username);

        if (empty($user)) {
            return false;
        }

        return $user->validatePassword($password);
    }
    
    /**
     * @inheritdoc
     */
    public function getUserDetails($username)
    {
        $user = static::findByUsername($username);

        return ['user_id' => $user->getId()];
    }
}