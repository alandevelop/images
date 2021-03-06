<?php

namespace frontend\modules\post\controllers;

use Yii;
use yii\web\Controller;
use frontend\modules\post\models\PostForm;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use frontend\models\Post;
use frontend\models\User;
use frontend\components\Storage;


class DefaultController extends Controller
{

    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/user/default/login']);
        }

        $form_model = new PostForm(Yii::$app->user->identity);

        if ($form_model->load(Yii::$app->request->post())) {
            $form_model->picture = UploadedFile::getInstance($form_model, 'picture');
            $form_model->save();

            return $this->redirect(['/user/profile/view', 'id' => Yii::$app->user->id]);
        }

        return $this->render('create', [
            'form_model' => $form_model,
            'currentUser' => Yii::$app->user->identity,
        ]);
    }

    public function actionDelete()
    {
        $id = Yii::$app->request->post('id');
        $post = $this->findPost($id);
        if ($post->picture) {
            Storage::removeFile($post->picture);
        }
        $post->delete();

        return true;
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

    public function actionComplain()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/user/default/login');
        }

        $user = Yii::$app->user->identity;
        $post_id = Yii::$app->request->post('id');
        $post = $this->findPost($post_id);

        if ($post->complain($user)) {
            return 'Жалоба подана';
        }

        return 'Ошибка';

    }


}
