<?php

namespace common\models;

use yii\db\ActiveRecord;

class Shop extends ActiveRecord
{
    public static function tableName()
    {
        return '{{shop}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'user_id', 'count', 'yetkazish_turi', 'summa', 'status', 'created_at'], 'required']
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
