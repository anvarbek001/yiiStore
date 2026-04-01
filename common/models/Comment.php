<?php

namespace common\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%comments}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'product_id', 'comment'], 'required'],
            [['comment'], 'string'],
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
