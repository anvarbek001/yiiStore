<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Blog;
use common\models\Category;
use common\models\Korzinka;
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
                        'actions' => ['logout', 'index', 'blog', 'user', 'update-user', 'chegirma', 'edit-chegirma', 'delete-chegirma', 'order', 'order-status', 'order-cancel'],
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
        $categories = Category::find()->with(['subCategories.subSubCategories.childrenCategories.childrens.childrens.childrens'])->all();
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
        $items = SubSubCategory::find()->with(['products' => function ($query) {
            $query->where(['user_id' => Yii::$app->user->id]);
        }])->all();
        $model = new Blog();
        $blogs = Blog::find()
            ->joinWith('product')
            ->with(['product.productImages', 'product.subSubCategory'])
            ->where(['products.user_id' => Yii::$app->user->id])
            ->all();
        // dd(Yii::$app->request->post());

        return $this->render('blog', [
            'items' => $items,
            'model' => $model,
            'blogs' => $blogs
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

    public function actionChegirma()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['site/blog']);
        }
        if (Yii::$app->request->isPost && !empty(Yii::$app->request->post())) {
            $sub_sub_category_id = Yii::$app->request->post('sub_sub_category_id');
            $chegirma_foiz = Yii::$app->request->post('chegirma_foiz');

            $products = Product::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['sub_sub_category_id' => $sub_sub_category_id])
                ->all();

            if (empty($products)) {
                Yii::$app->session->setFlash('error', "Mahsulot topilmadi");
            } else {
                $savedCount = 0;

                foreach ($products as $product) {
                    $chegirma = round(($product->price * $chegirma_foiz) / 100);

                    $blog = new Blog();
                    $blog->product_id    = $product->id;
                    $blog->discount_price = $product->price - $chegirma;
                    $blog->chegirma_foiz  = $chegirma_foiz;
                    $blog->created_at = date('Y-m-d H:i:s');

                    if ($blog->save()) {
                        $savedCount++;
                    } else {
                        Yii::error($blog->errors);
                    }
                }

                if ($savedCount > 0) {
                    Yii::$app->session->setFlash('success', "$savedCount ta mahsulotga chegirma qo'shildi");
                    return $this->redirect(['site/blog']);
                } else {
                    Yii::$app->session->setFlash('error', "Saqlashda xatolik yuz berdi");
                    return $this->redirect(['site/blog']);
                }
            }
        }
    }

    public function actionEditChegirma()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['site/blog']);
        }

        $sub_sub_category_id = Yii::$app->request->post('sub_sub_category_id');
        $chegirma_foiz = Yii::$app->request->post('chegirma_foiz');

        if (!$sub_sub_category_id || $chegirma_foiz === null) {
            Yii::$app->session->setFlash('error', "Ma'lumotlar to'liq emas");
            return $this->redirect(['site/blog']);
        }

        $blogs = Blog::find()
            ->joinWith(['product' => function ($query) use ($sub_sub_category_id) {
                $query->where([
                    'user_id' => Yii::$app->user->id,
                    'sub_sub_category_id' => $sub_sub_category_id,
                ]);
            }])
            ->all();

        if (empty($blogs)) {
            Yii::$app->session->setFlash('error', "Mahsulot topilmadi");
            return $this->redirect(['site/blog']);
        }

        $savedCount = 0;

        foreach ($blogs as $blog) {
            if (!$blog->product) continue;

            $chegirma = round(($blog->product->price * $chegirma_foiz) / 100);

            $blog->discount_price = $blog->product->price - $chegirma;
            $blog->chegirma_foiz  = $chegirma_foiz;
            $blog->updated_at = date('Y-m-d H:i:s');

            if ($blog->save(false)) {
                $savedCount++;
            } else {
                Yii::error($blog->errors);
            }
        }

        if ($savedCount > 0) {
            Yii::$app->session->setFlash('success', "$savedCount ta mahsulotga chegirma yangilandi");
        } else {
            Yii::$app->session->setFlash('error', "Saqlashda xatolik yuz berdi");
        }

        return $this->redirect(['site/blog']);
    }

    public function actionDeleteChegirma()
    {
        if (!Yii::$app->request->isPost) {
            return $this->redirect(['site/blog']);
        }

        $sub_sub_category_id = Yii::$app->request->post('sub_sub_category_id');
        $chegirma_foiz = Yii::$app->request->post('chegirma_foiz');

        if (!$sub_sub_category_id) {
            Yii::$app->session->setFlash('error', "Ma'lumotlar to'liq emas");
            return $this->redirect(['site/blog']);
        }

        $blogs = Blog::find()
            ->joinWith(['product' => function ($query) use ($sub_sub_category_id) {
                $query->where([
                    'user_id' => Yii::$app->user->id,
                    'sub_sub_category_id' => $sub_sub_category_id,
                ]);
            }])
            ->all();

        if (empty($blogs)) {
            Yii::$app->session->setFlash('error', "Mahsulot topilmadi");
            return $this->redirect(['site/blog']);
        }

        $savedCount = 0;

        foreach ($blogs as $blog) {
            if (!$blog->product) continue;

            $blog->delete();
        }

        if ($savedCount > 0) {
            Yii::$app->session->setFlash('success', "$savedCount ta mahsulot o'chirildi");
        }

        return $this->redirect(['site/blog']);
    }

    public function actionOrder()
    {
        $korzinkas = Korzinka::find()->joinWith(['product'])
            ->where(['products.user_id' => Yii::$app->user->id])->with(['product.productImages'])->all();

        return $this->render('order', [
            'korzinkas' => $korzinkas
        ]);
    }

    public function actionOrderStatus($id)
    {
        $order = Korzinka::findOne($id);
        if (!$order) {
            Yii::$app->session->setFlash('error', "Mahsulot topilmadi");
            return $this->redirect(['site/order']);
        }

        $order->status = 2;
        $order->save();
        Yii::$app->session->setFlash('success', "Mahsulot yetkazildi");
        return $this->redirect(['site/order']);
    }

    public function actionOrderCancel($id)
    {
        $order = Korzinka::findOne($id);
        if (!$order) {
            Yii::$app->session->setFlash('error', "Mahsulot topilmadi");
            return $this->redirect(['site/order']);
        }

        $order->status = 3;
        $order->save();
        Yii::$app->session->setFlash('error', "Mahsulot bekor qilindi");
        return $this->redirect(['site/order']);
    }
}
