<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use common\models\User;

class SeederController extends Controller
{
    public function actionUser($count = 10)
    {
        for ($i = 1; $i <= $count; $i++) {
            $user = new User();
            $user->username = "user{$i}";
            $user->email = "user{$i}@mail.com";
            $user->role = 'user';
            $user->status = 10;

            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->password_hash = Yii::$app->security->generatePasswordHash('123456');

            $user->created_at = time();
            $user->updated_at = time();

            if ($user->save()) {
                echo "User {$i} created\n";
            } else {
                print_r($user->errors);
            }
        }
        echo "Seeder finished ";
    }
}
