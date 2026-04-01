<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Login form
 */
class Product extends ActiveRecord
{
    public static function tableName()
    {
        return '{{products}}';
    }
    public $imageFiles;

    public function rules()
    {
        return [
            [['user_id', 'category_id', 'sub_category_id', 'sub_sub_category_id', 'name', 'status', 'created_at'], 'required'],
            [['price', 'description', 'updated_at', 'status'], 'safe'],
            [['user_id', 'category_id', 'sub_category_id', 'price'], 'integer'],
            [['parent_id'], 'integer'],
            [['name'], 'string'],
            // skipOnEmpty => true — rasm majburiy emas
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
        ];
    }

    public function upload()
    {
        if (empty($this->imageFiles)) {
            return true;
        }

        $uploadPath = Yii::getAlias('@uploads') . '/products/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $order = 1;
        foreach ($this->imageFiles as $file) {
            $fileName = uniqid() . '.' . $file->extension;
            $filePath = $uploadPath . $fileName;

            if ($file->saveAs($filePath)) {
                $productImage = new ProductImage();
                $productImage->product_id = $this->id;
                $productImage->image = 'products/' . $fileName;
                $productImage->order = $order++;
                $productImage->save();
            }
        }

        return true;
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getSubcategory()
    {
        return $this->hasOne(SubCategory::class, ['id' => 'sub_category_id']);
    }
    public function getSubSubCategory()
    {
        return $this->hasOne(SubSubCategory::class, ['id' => 'sub_sub_category_id']);
    }

    public function getBlogs()
    {
        return $this->hasOne(Blog::class, ['product_id' => 'id']);
    }
    public function blog()
    {
        if (!empty($this->blogs)) {
            return $this->blogs->discount_price;
        }
        return null;
    }

    public function getFavourite()
    {
        return $this->hasMany(Favourite::class, ['product_id' => 'id'])->andWhere(['user_id' => Yii::$app->user->id]);
    }

    public function getProductImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id'])->orderBy('order');
    }

    public function getLatestBlog()
    {
        return $this->hasOne(Blog::class, ['product_id' => 'id'])
            ->orderBy(['created_at' => SORT_DESC]);
    }

    public function getShops()
    {
        return $this->hasMany(Shop::class, ['user_id' => 'id']);
    }

    public function getKorzinkas()
    {
        return $this->hasMany(Korzinka::class, ['user_id' => 'id']);
    }

    public function isFavourite()
    {
        if (!Yii::$app->user->isGuest) {
            foreach ($this->favourite as $fav) {
                if ($fav->user_id == Yii::$app->user->id && $fav->product_id == $this->id) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }

    public function oneKorzinka()
    {
        if (Yii::$app->user->isGuest) {
            return false;
        }

        return Korzinka::find()
            ->where([
                'user_id' => Yii::$app->user->id,
                'product_id' => $this->id
            ])
            ->exists();
    }

    public function getChildrenCategory()
    {
        return $this->hasOne(ChildrenCategory::class, ['id' => 'parent_id']);
    }

    public function getComments()
    {
        return $this->hasMany(Comment::class, ['product_id' => 'id']);
    }
}
