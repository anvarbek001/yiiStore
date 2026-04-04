<?php

namespace backend\controllers;

use backend\components\AdminFilter;
use common\models\Category;
use common\models\ChildrenCategory;
use common\models\SubCategory;
use Yii;
use yii\web\Controller;


class ChildrenCategoryController extends Controller
{
    public function actionCreate()
    {
        $model = new ChildrenCategory();
        // dd(Yii::$app->request->post());
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

    public function actionUpdate($id)
    {
        $childCategory = ChildrenCategory::findOne($id);

        if (!$childCategory) {
            throw new \yii\web\NotFoundHttpException('Topilmadi');
        }

        if ($childCategory->load(Yii::$app->request->post()) && $childCategory->save()) {
            Yii::$app->session->setFlash('success', "Tahrirlandi");
        } else {
            Yii::$app->session->setFlash('error', "Xatolik: " . json_encode($childCategory->errors));
        }

        return $this->redirect(['site/index']);
    }

    public function actionDelete($id)
    {
        $childCategory = ChildrenCategory::findOne($id);

        if (!$childCategory) {
            throw new \yii\web\NotFoundHttpException('Topilmadi');
        }

        $childCategory->delete();
        Yii::$app->session->setFlash('success', "O'chirildi");
        return $this->redirect(['site/index']);
    }
}
