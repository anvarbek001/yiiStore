<?php

namespace backend\components;

use Yii;
use yii\base\ActionFilter;

class AdminFilter extends ActionFilter
{
    public $except = ['site/login'];

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->redirect(['/site/login']);
            return false;
        }

        if (Yii::$app->user->identity->role !== 'admin') {
            throw new \yii\web\ForbiddenHttpException('Sizda ruxsat yo\'q');
        }

        return parent::beforeAction($action);
    }
}
