<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Category;
use common\models\SubCategory;
use common\models\SubSubCategory;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class SubCategoryController extends Controller
{

    public function behaviors()
    {
        return [
            'admin' => [
                'class' => AdminFilter::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $subCategories = SubCategory::find()->with('category')->all();
        $categories = Category::find()->all();
        $model = new SubCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subkategoriya qo\'shildi');
            return $this->redirect(['index']);
        }

        return $this->render('subcategories', [
            'subCategories' => $subCategories,
            'categories' => $categories,
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        // dd(Yii::$app->request->post());
        $subcategory = SubCategory::findOne($id);
        $categoryId = $subcategory->category_id;
        if (!$subcategory) {
            Yii::$app->session->setFlash('error', 'Subkategoriya topilmadi');
            return $this->redirect('sub-category/index');
        }

        $subcategory->category_id = $categoryId;
        $subcategory->name = Yii::$app->request->post('name');
        if ($subcategory->load(Yii::$app->request->post())) {
            if ($subcategory->save()) {
                Yii::$app->session->setFlash('success', "Muvaffaqiyatli tahrirlandi");
                return $this->redirect(['site/index']);
            } else {
                $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($subcategory->errors, 0));
                Yii::$app->session->setFlash('error', $errors);
            }
        }
    }

    public function actionDelete($id)
    {
        $subCat = SubCategory::findOne($id);
        if (!$subCat) {
            Yii::$app->session->setFlash('error', 'Subkategoriya topilmadi');
            return $this->redirect('sub-category/index');
        }

        $subCat->delete();
        Yii::$app->session->setFlash('success', "Muvaffaqiyatli o'chirildi");
        return $this->redirect('sub-category/index');
    }

    public function actionCreate()
    {
        // dd(Yii::$app->request->post());
        $model = new SubCategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subkategoriya qo\'shildi');
            return $this->redirect(['site/index']);
        }
    }

    public function actionSubCreate()
    {
        $model = new SubSubCategory();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Muvaffaqiyatli qo'shildi");
                return $this->redirect(['site/index']);
            } else {
                $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->errors, 0));
                Yii::$app->session->setFlash('error', $errors);
            }
        }
    }

    public function actionSubSubUpdate($id)
    {
        $model = SubSubCategory::findOne($id);
        // dd(Yii::$app->request->post());
        $model->name = Yii::$app->request->post('name');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Muvaffaqiyatli tahrirlandi");
                return $this->redirect(['site/index']);
            } else {
                $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->errors, 0));
                Yii::$app->session->setFlash('error', $errors);
            }
        }
    }

    public function actionSubSubDelete($id)
    {
        $model = SubSubCategory::findOne($id);
        $model->delete();
        Yii::$app->session->setFlash('success', "Muvaffaqiyatli o'chirildi");
        return $this->redirect(['site/index']);
    }
}
