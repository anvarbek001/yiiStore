<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

class Korzinka extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%korzinka}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'product_id', 'count'], 'required'],
            [['price'], 'integer'],
            [['status'], 'integer'],
            [['address'], 'string'],
            [['yetkazish_turi'], 'string'],
            [['tolov_turi'], 'string'],
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

    public function countProduct()
    {
        $products = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'status' => 0])->all();
        $count = 0;
        foreach ($products as $product) {

            $count += $product->count;
        }
        return $count;
    }

    public function countProductSuccess()
    {
        $products = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'status' => 1])->all();
        $count = 0;
        foreach ($products as $product) {
            $count += $product->count;
        }
        return $count;
    }

    public function priceProduct()
    {
        $korzinkas = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'status' => 0])->all();
        $price = 0;
        foreach ($korzinkas as $korzinka) {
            $discount = $korzinka->product?->blogs?->discount_price;

            if ($discount) {
                $price += $discount;
            } else {
                $price += $korzinka->price;
            }
        }
        return $price;
    }

    public function priceProductSuccess()
    {
        $products = Korzinka::find()->where(['user_id' => Yii::$app->user->id, 'status' => 1])->all();
        $price = 0;
        foreach ($products as $product) {
            $price += $product->price * $product->count;
        }
        return $price;
    }
}
