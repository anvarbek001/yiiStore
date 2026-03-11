<?php

namespace common\widgets;

use Yii;
use yii\base\Widget;
use yii\bootstrap5\Html;

class LanguageSwitcher extends Widget
{
    public array $languages = [
        'uz' => 'UZ',
        'ru' => 'RU',
        'en' => 'EN',
    ];

    public function run(): string
    {
        $items = '';
        foreach ($this->languages as $code => $label) {
            $isActive = Yii::$app->language === $code;
            $items .= Html::tag(
                'li',
                Html::a($label, ['/site/language', 'lang' => $code], [
                    'class' => 'dropdown-item' . ($isActive ? ' active' : ''),
                ])
            );
        }

        return Html::tag(
            'div',
            Html::button(Yii::$app->language, [
                'class' => 'btn btn-link text-decoration-none text-white dropdown-toggle',
                'data-bs-toggle' => 'dropdown',
            ]) .
                Html::tag('ul', $items, ['class' => 'dropdown-menu dropdown-menu-end']),
            ['class' => 'd-flex dropdown']
        );
    }
}
