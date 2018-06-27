<?php

namespace api\controllers;

use api\models\User;
use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'api\models\User';

    public function verbs()
    {
        return [
            'index' => ['get'],
            'view-user' => ['get'],
            'create-user' => ['post'],
        ];
    }



    /**
     * Displays users.
     *
     * @return string
     */
    public function actionIndex()
    {
        return User::find()->all();
    }

    public function actionViewUser($id)
    {
        $user = User::findOne($id);
        return $user ? $user : ['no user'];
    }

    public function actionCreateUser()
    {
        $params = Yii::$app->request->bodyParams;

        $user = new User();
        $user->load($params, '');

        if ($user->validate() && $user->save()) {
            return [
                'ok' => true,
                'message' => 'User created',
                'user_id' => $user->id,
            ];
        } else {
            return $user->getErrors();
        }
    }

    public function actionError()
    {
        return ['error'];
    }
}
