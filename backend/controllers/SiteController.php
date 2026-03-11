<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Blog;
use common\models\Category;
use common\models\LoginForm;
use common\models\Product;
use common\models\SubSubCategory;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error',],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'blog', 'user', 'update-user'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                    'update-user' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()->with(['subCategories.subSubCategories'])->all();
        $model = new Category();
        $updateModel = new Category();
        // dd($categories);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Kategoriya qoshildi');
                return $this->redirect('index');
            }
        }

        return $this->render('index', [
            'categories' => $categories,
            'model' => $model,
            'updateModel' => $updateModel
        ]);
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            // Admin tekshiruvi
            if (Yii::$app->user->identity->role !== 'admin') {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'Sizda admin huquqi yo\'q');
                return $this->redirect(['site/login']);
            }

            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionBlog()
    {
        $blogs = Blog::find()->all();

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['user_id' => Yii::$app->user->id])->innerJoinWith('blogs')->with(['user', 'category', 'subcategory', 'subSubCategory', 'productImages', 'latestBlog']),
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        return $this->render('blog', [
            'blogs' => $blogs,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUser()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()
                ->where(['!=', 'id', Yii::$app->user->id]),
            'pagination' => [
                'pageSize' => 8,
            ],
        ]);

        return $this->render('user', [
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionUpdateUser()
    {
        $data = json_decode(Yii::$app->request->rawBody, true);
        $user = User::findOne($data['id']);

        if (!$user) return $this->asJson(['success' => false, 'message' => 'Topilmadi']);

        $user->{$data['field']} = $data['value'];
        $ok = $user->save(false);

        return $this->asJson(['success' => $ok]);
    }
}
