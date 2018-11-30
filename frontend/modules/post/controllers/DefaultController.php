<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\post\models\PostForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\models\User;

/**
 * Default controller for the `post` module
 */
class DefaultController extends Controller
{

    public function actionCreate()
    {
        $formModel = new PostForm(Yii::$app->user->identity);

        if ($formModel->load(Yii::$app->request->post())) {
            $formModel->picture = UploadedFile::getInstance($formModel, 'picture');
            $formModel->save();

            return $this->goHome();
        }

        return $this->render('create', [
            'formModel' => $formModel,
        ]);
    }

    public function actionView($id)
    {
        $post = $this->findPost($id);
        $user = User::findOne($post->user_id);

        return $this->render('view', [
            'post' => $post,
            'user' => $user,
        ]);
    }

    private function findPost($id)
    {
        if ($post = Post::findOne($id)) {
            return $post;
        }
        throw new NotFoundHttpException();
    }
}
