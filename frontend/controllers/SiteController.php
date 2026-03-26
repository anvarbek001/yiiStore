<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Favourite;
use common\models\Korzinka;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Product;
use common\models\Shop;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $subsubcategory_id = Yii::$app->request->get('subsubcategory_id');
        $startSum = Yii::$app->request->get('start_sum');
        $endSum = Yii::$app->request->get('end_sum');
        $newProducts = Yii::$app->request->get('new_products');
        $tezFilter = Yii::$app->request->get('tez_filter');
        $query = Product::find()->where(['status' => 1])->with(['user', 'category', 'subcategory', 'subSubCategory', 'productImages'])->orderBy(['created_at' => SORT_DESC]);
        // dd(Yii::$app->request->get());

        if ($subsubcategory_id) {
            $query->andWhere(['sub_sub_category_id' => $subsubcategory_id]);
        }

        if ($startSum && $endSum && $newProducts == 'on') {
            $query->andWhere(['between', 'price', $startSum, $endSum])->orderBy(['created_at' => SORT_DESC]);
        } else if ($startSum) {
            $query->andWhere(['>=', 'price', $startSum]);
        } else if ($endSum) {
            $query->andWhere(['<=', 'price', $endSum]);
        } else if ($newProducts == 'on') {
            $query->orderBy(['created_at' => SORT_DESC]);
        } else if ($tezFilter == 'arzonroq') {
            $query->orderBy(['price' => SORT_ASC]);
        } else if ($tezFilter == 'qimmatroq') {
            $query->orderBy(['price' => SORT_DESC]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 9
            ]
        ]);
        $categories = Category::find()->with(['subCategories', 'subSubCategories'])->all();
        // dd($categories);
        // $products = Product::find()->with(['user', 'category', 'subcategory', 'subSubCategory', 'productImages'])->all();
        return $this->render('index', ['dataProvider' => $dataProvider, 'categories' => $categories]);
    }


    public function actionSearch()
    {
        $q = Yii::$app->request->get('q', '');

        $products = Product::find()
            ->with(['productImages'])
            ->where([
                'or',
                ['like', 'name', $q],
                ['like', 'description', $q],
            ])
            ->limit(20)
            ->all();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return array_map(function ($product) {
            $image = !empty($product->productImages)
                ? \common\components\FileUploader::getUrl($product->productImages[0]->image)
                : '/img/no-image.png';

            return [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'image' => $image,
            ];
        }, $products);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionLanguage(string $lang)
    {
        $supported = ['uz', 'ru', 'en'];
        if (in_array($lang, $supported)) {
            Yii::$app->session->set('language', $lang);
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionShop($id)
    {
        $product = Product::find()->where(['id' => $id])->with('favourite')->one();

        $categoryIds = $product->category_id;

        $recommendedProducts = Product::find()
            ->where(['category_id' => $categoryIds])
            ->andWhere(['not in', 'id', $product->id])
            ->with(['productImages', 'category', 'subcategory'])
            ->limit(8)
            ->all();

        $model = new Shop();
        $model->user_id = Yii::$app->user->id;
        $model->product_id = $id;
        $model->summa = (int) $product->price * Yii::$app->request->post('count');
        $model->count = Yii::$app->request->post('count');
        $model->yetkazish_turi = Yii::$app->request->post('yetkazish_turi');
        $model->status = 1;
        $model->created_at = date('Y-m-d');

        $model->save();

        if ($model->save()) {
            Yii::$app->session->setFlash('success', "Xarid muvaffaqiyatli");
            return $this->redirect(['site/index']);
        }

        // if ($model->load(Yii::$app->request->post())) {
        //     if ($model->save()) {
        //         Yii::$app->session->setFlash('success', "Xarid muvaffaqiyatli");
        //         return $this->redirect(['site/index']);
        //     }
        // }
        return $this->render('shop', ['product' => $product, 'model' => $model, 'recommendedProducts' => $recommendedProducts]);
    }

    public function actionSaved()
    {
        $favourites = Favourite::find()
            ->where(['favourite.user_id' => Yii::$app->user->id])
            ->with(['product.productImages', 'product.category', 'product.subcategory'])
            ->all();

        $saved = array_map(fn($f) => $f->product, $favourites);
        $saved = array_filter($saved);
        return $this->render('saved', ['saved' => $saved]);
    }

    public function actionKorzinkasaved()
    {
        $korzinkas = Korzinka::find()->where(['korzinka.user_id' => Yii::$app->user->id])->with(['product', 'product.productImages', 'product.category', 'product.subcategory'])->all();
        $korzinkasPrices = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'status' => 0])->all();
        $price = 0;
        foreach ($korzinkasPrices as $korzinka) {
            $discountPrice = $korzinka->product->blog();
            if ($discountPrice !== null && $discountPrice > 0) {
                $price += $discountPrice;
            } else {
                $price += $korzinka->price;
            }
        }
        $categoryIds = ArrayHelper::getColumn($korzinkas, 'product.category_id');
        $categoryIds = array_unique($categoryIds);
        $korzinkaProductIds = ArrayHelper::getColumn($korzinkas, 'product_id');

        $recommendedProducts = Product::find()
            ->where(['category_id' => $categoryIds])
            ->andWhere(['not in', 'id', $korzinkaProductIds])
            ->with(['productImages', 'category', 'subcategory'])
            ->limit(8)
            ->all();
        return $this->render('korzinka', ['korzinkas' => $korzinkas, 'recommendedProducts' => $recommendedProducts, 'price' => $price]);
    }

    public function actionKorzinkadelete($id)
    {
        $prod = Korzinka::findOne($id);
        $prod->delete();
        Yii::$app->session->setFlash('success', 'Savatdan o\'chirildi');
        return $this->redirect(['site/korzinkasaved']);
    }

    public function actionIncrement()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(Yii::$app->request->rawBody, true);
        $id = $data['id'] ?? null;

        if (!$id) {
            return ['success' => false, 'message' => "ID yo'q"];
        }

        $prod = Korzinka::findOne($id);

        if (!$prod) {
            return ['success' => false, 'message' => "Mahsulot topilmadi"];
        }

        $count = $prod->count++;
        $prod->price * $count;
        $prod->save(false);

        return ['success' => true, 'count' => $prod->count, 'price' => $prod->price];
    }

    public function actionDecrement()
    {

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(Yii::$app->request->rawBody, true);
        $id = $data['id'] ?? null;

        if (!$id) {
            return ['success' => false, 'message' => "ID yo'q"];
        }

        $prod = Korzinka::findOne($id);

        if (!$prod) {
            return ['success' => false, 'message' => "Mahsulot topilmadi"];
        }

        if ($prod->count >= 2) {
            $count = $prod->count--;
            $prod->price / $count;
            $prod->save(false);
        } else {
            return ['success' => true, 'count' => $prod->count, 'price' => $prod->price];
        }

        return ['success' => true, 'count' => $prod->count, 'price' => $prod->price];
    }

    public function actionRemoveFavourite($product_id)
    {
        Favourite::deleteAll([
            'user_id'    => Yii::$app->user->id,
            'product_id' => $product_id,
        ]);

        Yii::$app->session->setFlash('success', 'Saqlangandan o\'chirildi');
        return $this->redirect(['site/saved']);
    }

    public function actionSave()
    {
        $favourites = Favourite::find()
            ->where(['user_id' => Yii::$app->user->id])
            ->with(['product.productImages', 'product.category', 'product.subcategory'])
            ->all();

        $saved = array_map(fn($f) => $f->product, $favourites);

        return $this->render('saved', ['saved' => $saved]);
    }

    public function actionFavourite()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // JSON body dan olish
        $data = json_decode(Yii::$app->request->rawBody, true);
        $productId = $data['product_id'] ?? null;

        if (!$productId) {
            return ['success' => false, 'message' => 'product_id kerak'];
        }

        // Duplicate tekshirish
        $exists = Favourite::find()
            ->where(['user_id' => Yii::$app->user->id, 'product_id' => $productId])
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => 'Allaqachon saqlangan'];
        }

        $model = new Favourite();
        $model->user_id = Yii::$app->user->id;
        $model->product_id = $productId;

        if ($model->save()) {
            return ['success' => true, 'message' => 'Product saqlandi'];
        }

        return ['success' => false, 'message' => 'Xatolik', 'errors' => $model->errors];
    }

    public function actionKorzinka()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = json_decode(Yii::$app->request->rawBody, true);
        $productId = $data['product_id'] ?? null;

        if (!$productId) {
            return ['success' => false, 'message' => 'product_id kerak'];
        }
        $prod = Product::find()->where(['id' => $productId])->one();

        if (!$prod) {
            return ['success' => false, 'message' => 'Mahsulot topilmadi'];
        }

        $exists = Korzinka::find()
            ->where(['user_id' => Yii::$app->user->id, 'product_id' => $productId])
            ->exists();

        if ($exists) {
            return ['success' => false, 'message' => 'Allaqachon saqlangan'];
        }

        $model = new Korzinka();
        $model->user_id = Yii::$app->user->id;
        $model->product_id = $productId;
        $model->price = $prod->price;
        if ($model->save(false)) {
            return ['success' => true, 'message' => 'Product saqlandi'];
        }

        return ['success' => false, 'message' => 'Xatolik', 'errors' => $model->errors];
    }

    public function actionProfile()
    {
        $userId = Yii::$app->user->id;
        $user = User::findOne(Yii::$app->user->id);
        $haridlar = Shop::find()
            ->where(['user_id' => $userId])
            ->with(['product' => function ($q) {
                $q->select(['id', 'name', 'price']);
            }])
            ->all();
        $user = User::find()
            ->where(['id' => Yii::$app->user->id])
            ->with(['products.productImages', 'favourite.product'])
            ->one();

        return $this->render('profile', ['user' => $user, 'haridlar' => $haridlar]);
    }

    public function actionUpdateProfile()
    {
        $user = User::findOne(Yii::$app->user->id);

        // Foydalanuvchi topilmasa
        if (!$user) {
            return $this->redirect(['site/login']);
        }

        $data = Yii::$app->request->post('User');

        $user->username = $data['username'] ?? $user->username;
        $user->email    = $data['email']    ?? $user->email;

        $newPassword = $data['new_password'] ?? '';
        $confirmPassword = $data['confirm_password'] ?? '';
        $passwordChanged = false;

        if (!empty($newPassword)) {
            if ($newPassword !== $confirmPassword) {
                Yii::$app->session->setFlash('error', 'Parollar mos kelmadi');
                return $this->redirect(['site/profile']);
            }
            $user->setPassword($newPassword);
            $user->generateAuthKey();
            $passwordChanged = true;
        }

        if ($user->save(false)) {
            // Parol o'zgarganda sessionni yangilash
            if ($passwordChanged) {
                Yii::$app->user->login($user); // ← Qayta login
            }
            Yii::$app->session->setFlash('success', 'Profil yangilandi');
        } else {
            Yii::$app->session->setFlash('error', 'Xatolik yuz berdi');
        }

        return $this->redirect(['site/profile']);
    }

    public function actionTransaction()
    {
        $id = Yii::$app->request->post('id');
        $korzinka = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'id' => $id])->one();
        $yetkazish = Yii::$app->request->post('yetkazish');
        $address   = Yii::$app->request->post('address');
        $tolovTuri   = Yii::$app->request->post('tolov_turi');
        $bolibTolash   = Yii::$app->request->post('bolib_tolash');
        // dd(Yii::$app->request->post());

        if ($korzinka->product->blog()) {
            $korzinka->price = $korzinka->product->blog();
        } else {
            $korzinka->price = $korzinka->product->price;
        }

        $korzinka->yetkazish_turi = $yetkazish;
        $korzinka->address = $address;
        $korzinka->tolov_turi = $tolovTuri;
        $korzinka->status = 1;
        if ($bolibTolash > 0 && $bolibTolash != null) {
            $korzinka->muddatli_tolov_summasi = $bolibTolash;
        }
        $korzinka->save(false);
        Yii::$app->session->setFlash('success', 'Mahsulotlar xarid qilindi');
        return $this->redirect(['site/korzinkasaved']);
    }

    // public function actionHarid($id)
    // {
    //     $product = Product::findOne($id);
    //     if (!$product) {
    //         throw new \yii\web\NotFoundHttpException("Mahsulot topilmadi");
    //     }

    //     $model = new \common\models\Shop();

    //     if ($model->load(Yii::$app->request->post())) {

    //         // Sizning qo'lda set qiladigan maydonlaringiz
    //         $model->product_id = $id;
    //         $model->summa = (int)$model->count * (int)$product->price;
    //         $model->user_id = Yii::$app->user->id;
    //         $model->created_at = date('Y-m-d');

    //         // agar rules() da status required bo'lsa, shart!
    //         if ($model->status === null) {
    //             $model->status = 1; // masalan: 1 = new/pending
    //         }

    //         if ($model->save()) {
    //             Yii::$app->session->setFlash('success', "Mahsulot harid qilindi");
    //             return $this->redirect(['site/index']);
    //         }

    //         // save false bo'lsa - xatoni ko'rsatib beramiz
    //         Yii::$app->session->setFlash('error', json_encode($model->errors));
    //         return $this->redirect(['site/index']);
    //     }

    //     Yii::$app->session->setFlash('error', "Ma'lumot kelmadi (POST emas).");
    //     return $this->redirect(['site/index']);
    // }
}
