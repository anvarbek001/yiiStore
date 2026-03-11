<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Category;
use common\models\SubCategory;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class CategoryController extends Controller
{
    public function behaviors()
    {
        return [
            'admin' => [
                'class' => AdminFilter::class,
            ],
        ];
    }

    public function actionUpdate($id)
    {
        $category = Category::findOne($id);
        $category->name = Yii::$app->request->post('name');
        if ($category->load(Yii::$app->request->post())) {
            if ($category->save()) {
                Yii::$app->session->setFlash('success', 'Yangilandi');
                return $this->redirect('site/index');
            } else {
                Yii::$app->session->setFlash('error', 'Xatolik');
                return $this->redirect('site/index');
            }
        }
        die();
    }

    public function actionDelete($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            Yii::$app->session->setFlash('error', "Kategoriya topilmadi");
            return $this->redirect('site/index');
        }

        $category->delete();
        Yii::$app->session->setFlash('success', "Kategoriya o'chirildi");
        return $this->redirect('site/index');
    }

    public function actionCreate()
    {
        // dd(Yii::$app->request->post());
        $model = new SubCategory();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Subkategoriya qo'shildi");
                return $this->redirect(['site/index']);
            } else {
                $errors = implode('<br>', \yii\helpers\ArrayHelper::getColumn($model->errors, 0));
                Yii::$app->session->setFlash('error', $errors);
            }
        }
        return $this->redirect(['site/index']);
    }
}
