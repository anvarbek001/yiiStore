<?php

namespace  common\models;

use yii\db\ActiveRecord;

class SubSubCategory extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%sub_sub_categories}}';
    }

    public function rules()
    {
        return [
            [['category_id', 'sub_category_id', 'name'], 'required'],
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getSubCategory()
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }

    public function getProducts()
    {
        return $this->hasMany(Product::class, ['sub_sub_category_id' => 'id']);
    }

    public function getChildrenCategories()
    {
        return $this->hasMany(ChildrenCategory::class, ['sub_sub_category_id' => 'id'])->andWhere(['parent_id' => null]);
    }
}
