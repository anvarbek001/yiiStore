<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Category;
use common\models\Product;
use common\models\SubCategory;
use common\components\FileUploader;
use common\models\Blog;
use common\models\ChildrenCategory;
use common\models\ProductImage;
use common\models\ReklamaProduct;
use common\models\SubSubCategory;
use DateTime;
use DateTimeZone;
use PDO;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class ProductsController extends Controller
{
    public function behaviors()
    {
        return [
            'admin' => [
                'class' => AdminFilter::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id === 'update-status') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = new Product();
        $reklama = new ReklamaProduct();

        $dataProvider = new ActiveDataProvider([
            'query' => Product::find()->where(['user_id' => Yii::$app->user->id])->with(['user', 'category', 'subcategory', 'subSubCategory', 'childrenCategory', 'productImages', 'latestBlog'])->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 8
            ]
        ]);

        // $products = Product::find()->where(['user_id' => Yii::$app->user->id])->with(['user', 'category', 'subcategory', 'subSubCategory', 'productImages', 'latestBlog'])->all();
        $categories = Category::find()->all();
        $subSubCategories = SubSubCategory::find()->all();

        // dd(Yii::$app->request->post());

        if (Yii::$app->request->isPost) {
            if ($model->load(Yii::$app->request->post())) {
                $model->user_id = Yii::$app->user->id;
                if (Yii::$app->request->post('tez_orada')) {
                    $model->status = 0;
                } else {
                    $model->status = 1;
                }
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');

                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');

                if ($model->save()) {
                    $model->upload();
                    if (Yii::$app->request->post('tez_orada')) {
                        $reklama->user_id = Yii::$app->user->identity->id;
                        $reklama->product_id = $model->id;
                        $time = new DateTime('now', new DateTimeZone('Asia/Tashkent'));
                        $reklama->created_at = $time->format('Y-m-d H:i:s');
                        $reklama->save();
                        Yii::$app->session->setFlash('success', 'Product muvaffaqiyatli saqlandi');
                        return $this->redirect(['index']);
                    }
                    Yii::$app->session->setFlash('success', 'Product muvaffaqiyatli saqlandi');
                    return $this->redirect(['index']);
                } else {
                    $errors = $model->getErrors();
                    $errorMessages = [];
                    foreach ($errors as $messages) {
                        $errorMessages[] = implode(', ', $messages);
                    }
                    Yii::$app->session->setFlash('error', implode(' | ', $errorMessages));
                }
            }
        }

        return $this->render('product', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'categories' => $categories,
            'subSubCategories' => $subSubCategories
        ]);
    }

    public function actionGetSubcategories($category_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $subcategories = SubCategory::find()
            ->where(['category_id' => $category_id])
            ->all();

        return \yii\helpers\ArrayHelper::map($subcategories, 'id', 'name');
    }

    public function actionGetSubSubcategories($sub_category_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $subcategories = SubSubCategory::find()
            ->where(['sub_category_id' => $sub_category_id])
            ->all();

        return \yii\helpers\ArrayHelper::map($subcategories, 'id', 'name');
    }

    public function actionGetChildrens($sub_sub_category_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $children = ChildrenCategory::find()
            ->where(['sub_sub_category_id' => $sub_sub_category_id])
            ->all();

        return \yii\helpers\ArrayHelper::map($children, 'id', 'name');
    }

    public function actionUpdate($id)
    {
        $model = Product::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Yangi rasmlar
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if ($model->imageFiles) {
                $model->upload();
            }

            Yii::$app->session->setFlash('success', 'Yangilandi');
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteImage($id)
    {
        $image = ProductImage::findOne($id);
        if ($image) {
            FileUploader::delete($image->image);
            $image->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDelete($id)
    {
        $product = Product::findOne($id);

        if (!$product) {
            throw new \yii\web\NotFoundHttpException('product topilmadi');
        }

        foreach ($product->productImages as $image) {
            FileUploader::delete($image->image);
            $image->delete();
        }

        $product->delete();

        Yii::$app->session->setFlash('success', 'product muvaffaqiyatli o\'chirildi');
        return $this->redirect(['products/index']);
    }


    public function actionChegirma($id)
    {
        $product = Product::findOne($id);
        $chegirmaFoiz = (int) Yii::$app->request->post('chegirma_foiz');

        if ($chegirmaFoiz >= 100) {
            Yii::$app->session->setFlash('error', 'Chegirma 100% teng bo\'lishi mumkin emas');
            return $this->redirect(['/products/index']);
        }
        $model = new Blog();
        $model->product_id = $id;
        $model->discount_price = $product->price - round(($product->price * $chegirmaFoiz) / 100);
        $model->chegirma_foiz = $chegirmaFoiz;
        $model->created_at = date('Y-m-d H:i:s');
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Chegirma qoshildi');
            return $this->redirect(['/products/index']);
        }
        return $this->redirect(['/products/index']);
    }

    public function actionChegirmaedit($id)
    {
        $model = Blog::findOne($id);
        $product = Product::findOne($model->product_id);
        $chegirmaFoiz = (int) Yii::$app->request->post('chegirma_foiz');
        $productId = $model->product_id;

        if ($chegirmaFoiz >= 100) {
            Yii::$app->session->setFlash('error', 'Chegirma 100% dan katta yoki teng bo\'lishi mumkin emas');
            return $this->redirect(['/products/index']);
        }
        $model->product_id = $productId;
        $model->discount_price = $product->price - round(($product->price * $chegirmaFoiz) / 100);
        $model->chegirma_foiz = $chegirmaFoiz;
        $model->created_at = date('Y-m-d H:i:s');
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Chegirma yangilandi');
            return $this->redirect(['/products/index']);
        }
        return $this->redirect(['/products/index']);
    }

    public function actionChegirmadelete($id)
    {
        $cheg = Blog::findOne($id);
        $cheg->delete();
        Yii::$app->session->setFlash('success', 'Chegirma o\'chirildi');
        return $this->redirect(['/products/index']);
    }

    public function actionUpdateStatus()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data = json_decode(Yii::$app->request->rawBody, true);
        $id = $data['id'];
        $status = $data['status'];

        $product = Product::findOne($id);

        if ($product) {
            $product->status = $status;
            if ($product->save()) {
                return ['success' => true];
            }
        }

        return ['success' => false];
    }
}
