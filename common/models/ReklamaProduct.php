<?php

namespace common\models;

use yii\db\ActiveRecord;

class ReklamaProduct extends ActiveRecord
{
    public static function tableName()
    {
        return '{{reklama_products}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'product_id'], 'required'],
            [['created_at'], 'datetime', 'format' => 'php:Y-m-d H:i:s']
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
