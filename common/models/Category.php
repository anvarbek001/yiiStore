<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return '{{categories}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required']
        ];
    }

    public function getSubCategories()
    {
        return $this->hasMany(SubCategory::class, ['category_id' => 'id']);
    }

    public function getSubSubCategories()
    {
        return $this->hasMany(SubSubCategory::class, ['category_id' => 'id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category_id' => 'id']);
    }
}
