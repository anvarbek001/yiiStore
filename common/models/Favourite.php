<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Favourite extends ActiveRecord
{
    public static function tableName()
    {
        return '{{favourite}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'user_id'], 'required'],
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'product_id']);
    }
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
