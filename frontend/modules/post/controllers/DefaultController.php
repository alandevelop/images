<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\post\models\PostForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\models\User;
use yii\web\Response;

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
        $current_user = Yii::$app->user->identity;

        return $this->render('view', [
            'post' => $post,
            'user' => $user,
            'current_user' => $current_user,
        ]);
    }

    private function findPost($id)
    {
        if ($post = Post::findOne($id)) {
            return $post;
        }
        throw new NotFoundHttpException();
    }

    public function actionLike()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user_id = Yii::$app->user->identity->getId();
        $post = $this->findPost(Yii::$app->request->post('id'));

        $post->like($user_id);

        return $post->countLikes();
    }

    public function actionUnlike()
    {
        $user_id = Yii::$app->user->identity->getId();
        $post = $this->findPost(Yii::$app->request->post('id'));

        $post->unlike($user_id);

        return $post->countLikes();
    }


}
