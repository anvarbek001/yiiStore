<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class ProductImage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{product_images}}';
    }

    public function rules()
    {
        return [
            [['product_id', 'order'], 'required'],
            [['product_id', 'order'], 'integer'],
            [['image'], 'string'],
        ];
    }
}
