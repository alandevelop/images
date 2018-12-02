<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index',
            [
                'users' => User::find()->all(),
                'feeds' => (!Yii::$app->user->isGuest) ? Yii::$app->user->identity->getFeeds() : null,
                'current_user' => Yii::$app->user->identity,
            ]
        );
    }

}
