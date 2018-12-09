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
    public function actionView($id)
    {
        return $this->render(
            'view',
            [
                'currentUser' => Yii::$app->user->identity,
                'user' => $this->findUser($id),
            ]
        );
    }

    public function actionDelete($id)
    {
        $user = $this->findUser($id);
        Yii::$app->user->logout();
        $user->delete();
        return $this->goHome();
    }


    public function findUser($id)
    {
        if (User::find()->where(['id' => $id])->exists()) {
            return $user = User::find()->where(['id' => $id])->with('posts')->one();
        }

        throw new NotFoundHttpException();
    }


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
        $response = Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

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

    public function actionChangeDescription()
    {
        $response = Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $id = Yii::$app->request->get('id');
        $text = Yii::$app->request->get('text');

        $user = $this->findUser($id);
        $user->about = $text;
        if ($user->validate()) {
            $user->save();
            return $user->about;
        } else {
            return null;
        }
    }
}



















