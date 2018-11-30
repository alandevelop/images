<?php
namespace frontend\modules\user\controllers;

use yii\web\Controller;
use frontend\models\User;
use yii\web\NotFoundHttpException;
use Yii;
use yii\web\UploadedFile;
use frontend\modules\user\models\AvatarForm;


class ProfileController extends Controller
{
  public function actionView ($id)
  {
      return $this->render(
          'view',
          [
              'currentUser' => Yii::$app->user->identity,
              'user' => $this->findUser($id),
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

//    public function actionFaker()
//    {
//        $faker = \Faker\Factory::create();
//
//        for ($i=0; $i<=10; $i++) {
//            $user = new User;
//
//            $user->username = $faker->name;
//            $user->email = $faker->email;
//            $user->about = $faker->text(200);
//            $user->created_at = $time = time();
//            $user->updated_at = $time;
//            $user->auth_key = Yii::$app->security->generateRandomString();
//            $user->password_hash = Yii::$app->security->generateRandomString();
//
//            $user->save();
//        }
//
//        echo '10 users has been generated';
//    }


    public function actionSubscribe($id)
    {
        $currentUser = Yii::$app->user->identity;
        $user = User::findOne($id);

        $currentUser->subscribe($user);

        return $this->redirect(['/user/profile/view', 'id' => $id]);
    }

    public function actionUnsubscribe($id)
    {
        $currentUser = Yii::$app->user->identity;
        $user = User::findOne($id);

        $currentUser->unsubscribe($user);

        return $this->redirect(['/user/profile/view', 'id' => $id]);
    }

    public function actionUploadAvatar()
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;

        $model = new AvatarForm();
        $model->picture = UploadedFile::getInstanceByName('avatar');

        if ($model->validate()) {
            $user = Yii::$app->user->identity;
            $user->saveAvatarFile($model->picture);
            return [
                'success',
                $user->getAvatar(),
            ];
        } else {
            return $model->getErrors();

        }
    }
}



















