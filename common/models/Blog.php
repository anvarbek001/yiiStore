<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Blog extends ActiveRecord
{
    public static function tableName()
    {
        return '{{blog}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'created_at', 'discount_price'], 'required'],
        ];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
