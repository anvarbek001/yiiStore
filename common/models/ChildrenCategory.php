<?php

namespace common\models;

use yii\db\ActiveRecord;

class ChildrenCategory extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%children_categories}}';
    }

    public function rules()
    {
        return [
            [['sub_sub_category_id', 'name'], 'required'],
            [['parent_id'], 'default', 'value' => null],
            [['name'], 'string']
        ];
    }

    public function getSubSubCategory()
    {
        return $this->hasOne(SubSubCategory::class, ['id' => 'sub_sub_category_id']);
    }

    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }

    public function getChildrens()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }
}
