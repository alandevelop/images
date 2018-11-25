<?php
namespace frontend\modules\user\controllers;

use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;


class ProfileController extends Controller
{
  public function actionView ($id)
  {
      return $this->render(
          'view',
          [
              'user' => $this->findUser($id)
          ]
      );
  }

  public function findUser ($id)
  {
      if (User::find()->where(['id' => $id])->exists()) {
          return $user = User::find()->where(['id' => $id])->one();
      }

      throw new NotFoundHttpException();
  }

}
