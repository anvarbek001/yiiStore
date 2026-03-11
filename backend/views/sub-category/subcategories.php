<?php

/** @var yii\web\View $this */
/** @var common\models\SubCategory[] $subCategories */
/** @var common\models\SubCategory $model */
/** @var common\models\Category[] $categories */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Subkategoriyalar';
?>

<div class="site-index">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="fw-bold mb-1">Subkategoriyalar</h1>
            <p class="text-muted mb-0">Jami: <b><?= count($subCategories) ?></b> ta subkategoriya</p>
        </div>
        <button class="btn btn-primary px-4 py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#subCategoryModal">
            + Subkategoriya qo'shish
        </button>
    </div>

    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach ($subCategories as $i => $sub): ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-body d-flex align-items-center justify-content-between p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="
                                width: 48px; height: 48px;
                                border-radius: 12px;
                                background: <?= ['#6c63ff22', '#ff658422', '#43e97b22', '#f7971e22'][$i % 4] ?>;
                                color: <?= ['#6c63ff', '#ff6584', '#43e97b', '#f7971e'][$i % 4] ?>;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 20px; flex-shrink: 0;
                            ">
                                🗂️
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 11px; letter-spacing: 1px; text-transform: uppercase;">
                                    <?= Html::encode($sub->category->name ?? '—') ?>
                                </div>
                                <div class="fw-bold fs-5"><?= Html::encode($sub->name) ?></div>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <?= Html::button('✏️', [
                                'class' => 'btn btn-sm btn-outline-secondary',
                                'style' => 'border-radius: 10px;',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#subCategoryUpdateModal' . $sub->id,
                            ]) ?>
                            <?= Html::a('🗑️', ['sub-category/delete', 'id' => $sub->id], [
                                'class' => 'btn btn-sm btn-outline-danger',
                                'style' => 'border-radius: 10px;',
                                'data-confirm' => 'O\'chirishni tasdiqlaysizmi?',
                                'data-method' => 'post',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <!-- Update Modal -->
                <div class="modal fade" id="subCategoryUpdateModal<?= $sub->id ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
                            <div class="modal-header border-0 pb-0 px-4 pt-4">
                                <h5 class="modal-title fw-bold fs-4">Subkategoriyani tahrirlash</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <?php $form = ActiveForm::begin([
                                'action' => ['sub-category/update', 'id' => $sub->id],
                                'method' => 'post',
                                'options' => ['style' => 'padding: 0;'],
                            ]) ?>

                            <div class="modal-body px-4 py-3">
                                <?= $form->field($sub, 'name')->textInput([
                                    'placeholder' => 'Subkategoriya nomi...',
                                    'class' => 'form-control form-control-lg',
                                    'style' => 'border-radius: 10px;',
                                ])->label('Nomi') ?>

                                <?= $form->field($sub, 'category_id')->dropDownList(
                                    \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                                    [
                                        'class' => 'form-select form-select-lg',
                                        'style' => 'border-radius: 10px;',
                                    ]
                                )->label('Kategoriya') ?>
                            </div>

                            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor qilish</button>
                                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary px-4 fw-semibold']) ?>
                            </div>

                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>

        <?php if (empty($subCategories)): ?>
            <div class="col-12 text-center py-5 text-muted">
                <div style="font-size: 48px;">📭</div>
                <p class="mt-2">Hali subkategoriya qo'shilmagan</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="subCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 16px;">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <h5 class="modal-title fw-bold fs-4">Yangi subkategoriya</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <?php $form = ActiveForm::begin([
                'method' => 'post',
                'options' => ['style' => 'padding: 0;'],
            ]) ?>

            <div class="modal-body px-4 py-3">
                <?= $form->field($model, 'name')->textInput([
                    'placeholder' => 'Subkategoriya nomi...',
                    'class' => 'form-control form-control-lg',
                    'style' => 'border-radius: 10px;',
                ])->label('Nomi') ?>

                <?= $form->field($model, 'category_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                    [
                        'prompt' => 'Kategoriyani tanlang...',
                        'class' => 'form-select form-select-lg',
                        'style' => 'border-radius: 10px;',
                    ]
                )->label('Kategoriya') ?>
            </div>

            <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor qilish</button>
                <?= Html::submitButton('Saqlash', ['class' => 'btn btn-primary px-4 fw-semibold']) ?>
            </div>

            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>