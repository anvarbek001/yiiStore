<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <title>Productlar</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #0f0f13;
            --surface: #17171f;
            --surface2: #1e1e2a;
            --border: #2a2a38;
            --accent: #6c63ff;
            --accent2: #ff6584;
            --text: #e8e8f0;
            --muted: #6b6b80;
            --success: #43d9a2;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
        }

        /* ── Header ── */
        .page-header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            padding: 48px 48px 32px;
            border-bottom: 1px solid var(--border);
        }

        .page-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 2.6rem;
            font-weight: 800;
            letter-spacing: -1px;
            background: linear-gradient(135deg, #fff 40%, var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .page-header .count {
            color: var(--muted);
            font-size: 0.9rem;
            margin-top: 4px;
        }

        .page-header .count b {
            color: var(--accent);
        }

        .btn-add {
            background: var(--accent);
            color: #fff;
            border: none;
            padding: 12px 28px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            cursor: pointer;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(108, 99, 255, .35);
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(108, 99, 255, .5);
        }

        /* ── Grid ── */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            padding: 40px 48px;
        }

        /* ── Card ── */
        .product-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 20px;
            overflow: hidden;
            transition: transform .25s, border-color .25s, box-shadow .25s;
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: var(--accent);
            box-shadow: 0 12px 40px rgba(108, 99, 255, .2);
        }

        .card-img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: linear-gradient(135deg, var(--surface2), var(--border));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
        }

        .card-body {
            padding: 20px;
        }

        .card-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .badge {
            font-size: 0.72rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: .3px;
        }

        .badge-user {
            background: rgba(108, 99, 255, .15);
            color: var(--accent);
        }

        .badge-cat {
            background: rgba(255, 101, 132, .12);
            color: var(--accent2);
        }

        .badge-subcat {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
        }

        .card-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .card-desc {
            font-size: 0.85rem;
            color: var(--muted);
            line-height: 1.55;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-price {
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: var(--success);
        }

        .btn-detail {
            background: var(--surface2);
            color: var(--text);
            border: 1px solid var(--border);
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 0.82rem;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, border-color .2s;
        }

        .btn-detail:hover {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }

        /* ── Empty ── */
        .empty-state {
            grid-column: 1/-1;
            text-align: center;
            padding: 80px 20px;
            color: var(--muted);
        }

        .empty-state .icon {
            font-size: 4rem;
            margin-bottom: 16px;
        }

        .empty-state p {
            font-size: 1rem;
        }

        /* ── Flash ── */
        .flash {
            padding: 14px 48px;
            font-size: 0.9rem;
        }

        .flash-success {
            background: rgba(67, 217, 162, .1);
            color: var(--success);
            border-left: 3px solid var(--success);
        }

        .flash-error {
            background: rgba(255, 101, 132, .1);
            color: var(--accent2);
            border-left: 3px solid var(--accent2);
        }

        /* ── Modal ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            backdrop-filter: blur(6px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.active {
            display: flex;
            overflow: scroll;
        }

        .modal-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 24px;
            width: 100%;
            max-width: 480px;
            padding: 36px;
            animation: modalIn .3s cubic-bezier(.34, 1.56, .64, 1);
            max-height: 90vh;
            overflow-y: auto;
        }

        @keyframes modalIn {
            from {
                opacity: 0;
                transform: scale(.92) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .modal-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .modal-close {
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            width: 36px;
            height: 36px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, color .2s;
        }

        .modal-close:hover {
            background: var(--accent2);
            color: #fff;
            border-color: var(--accent2);
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .6px;
            color: var(--muted);
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            width: 100%;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--text);
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            font-family: 'DM Sans', sans-serif;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            appearance: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(108, 99, 255, .2);
        }

        .form-control::placeholder {
            color: var(--muted);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 90px;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-cancel {
            flex: 1;
            background: var(--surface2);
            border: 1px solid var(--border);
            color: var(--muted);
            padding: 13px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-cancel:hover {
            background: var(--border);
        }

        .btn-save {
            flex: 2;
            background: var(--accent);
            border: none;
            color: #fff;
            padding: 13px;
            border-radius: 12px;
            font-family: 'Syne', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(108, 99, 255, .35);
            transition: transform .2s, box-shadow .2s;
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 28px rgba(108, 99, 255, .5);
        }

        /* scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 4px;
        }

        /* ── Pagination ── */
        .pager-wrap {
            margin-top: 28px;
            display: flex;
            justify-content: center;
        }

        .pager-wrap .pagination {
            display: flex;
            list-style: none;
            gap: 4px;
            padding: 0;
            margin: 0;
        }

        .pager-wrap .page-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            font-family: var(--mono);
            font-size: 0.8rem;
            text-decoration: none;
            color: var(--ink);
            border: 1px solid var(--line);
            background: #969595;
            transition: .2s;
        }

        .pager-wrap .page-link:hover {
            background: var(--ink);
            border-color: var(--ink);
            color: #fff;
        }

        .pager-wrap .active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: #fff;
        }
    </style>
</head>

<body>

    <?php

    use common\components\FileUploader;
    use yii\helpers\Html;
    use yii\helpers\Url;
    use yii\widgets\ActiveForm;
    use yii\widgets\LinkPager;

    $products = $dataProvider->getModels();

    // Flash xabarlar
    if (Yii::$app->session->hasFlash('success')): ?>
        <div class="flash flash-success">✓ <?= Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="flash flash-error">✕ <?= Yii::$app->session->getFlash('error') ?></div>
    <?php endif; ?>

    <!-- Header -->
    <div class="page-header">
        <div>
            <h1>Productlar</h1>
            <p class="count">Jami: <b><?= count($products) ?></b> ta product</p>
        </div>
        <button class="btn-add" onclick="document.getElementById('productModal').classList.add('active')">
            + Product qo'shish
        </button>
    </div>

    <!-- Grid -->
    <div class="products-grid">
        <?php foreach ($products as $i => $product): ?>
            <div class="product-card" style="animation-delay: <?= $i * 0.06 ?>s">
                <div class="card-img" style="position:relative; overflow:hidden;">
                    <?php
                    $images = $product->productImages;
                    if (!empty($images)): ?>

                        <div id="carousel-<?= $product->id ?>" class="carousel slide" data-bs-ride="carousel">

                            <!-- Rasmlar -->
                            <div class="carousel-inner" style="height:100%;">
                                <?php foreach ($images as $i => $img): ?>
                                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>" style="height:100%;">
                                        <img src="<?= FileUploader::getUrl($img->image) ?>"
                                            class="d-block w-100"
                                            alt="<?= Html::encode($product->name) ?>"
                                            style="height:100%; object-fit:cover;">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <?php if (count($images) > 1): ?>
                                <div class="carousel-indicators">
                                    <?php foreach ($images as $i => $img): ?>
                                        <button type="button"
                                            data-bs-target="#carousel-<?= $product->id ?>"
                                            data-bs-slide-to="<?= $i ?>"
                                            <?= $i === 0 ? 'class="active"' : '' ?>>
                                        </button>
                                    <?php endforeach; ?>
                                </div>

                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carousel-<?= $product->id ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carousel-<?= $product->id ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            <?php endif; ?>

                        </div>

                    <?php else: ?>
                        <div style="display:flex; align-items:center; justify-content:center; height:100%; font-size:48px;">📦</div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="card-meta">
                        <span class="badge badge-user">👤 <?= Html::encode($product->user->username) ?></span>
                        <span class="badge badge-cat"><?= Html::encode($product->category->name) ?></span>
                        <span class="badge badge-subcat"><?= Html::encode($product->subcategory->name) ?></span>
                        <span class="badge badge-subcat"><?= Html::encode($product->subSubCategory->name) ?></span>
                    </div>
                    <div class="card-title"><?= Html::encode($product->name) ?></div>
                    <p class="card-desc"><?= Html::encode($product->description) ?></p>
                </div>
                <div style="display:flex; gap:8px; padding: 0 20px 12px;">
                    <button class="btn-detail" data-bs-toggle="modal" data-bs-target="#editModal<?= $product->id ?>">
                        ✏️
                    </button>
                    <?= Html::a('🗑️', ['products/delete', 'id' => $product->id], [
                        'class' => 'btn-detail',
                        'style' => 'color: var(--accent2); border-color: var(--accent2)',
                        'data-confirm' => 'O\'chirishni tasdiqlaysizmi?',
                        'data-method' => 'post',
                    ]) ?>
                    <button class="btn-detail" data-bs-toggle="modal" data-bs-target="#exampleModalChegirma-<?= $product->id ?>"><i class="bi bi-tag-fill"></i></button>
                </div>
                <div class="form-check form-switch mx-3">
                    <input class="form-check-input status-toggle" type="checkbox"
                        data-id="<?= $product->id ?>"
                        <?= $product->status == 1 ? 'checked' : '' ?>>
                    <span class="status-label" style="color:<?= $product->status == 1 ? 'green' : 'red' ?>;">
                        <?= $product->status == 1 ? 'Active' : 'No active' ?>
                    </span>
                </div>
                <div class="card-footer">
                    <?php if ($product->latestBlog): ?>
                        <div style="display:flex; flex-direction:column; gap:2px;">
                            <span style="font-size:0.75rem; color:var(--muted); text-decoration:line-through;">
                                <?= number_format($product->price, 0, '.', ' ') ?>
                            </span>
                            <span class="card-price" style="color:var(--accent2);">
                                <?= number_format($product->latestBlog->discount_price, 0, '.', ' ') ?>
                                <span style="font-size:0.7rem; background:rgba(255,101,132,.15); color:var(--accent2); padding:2px 6px; border-radius:5px; margin-left:4px;">
                                    -<?= round((1 - $product->latestBlog->discount_price / $product->price) * 100) ?>%
                                </span>
                            </span>
                        </div>
                    <?php else: ?>
                        <span class="card-price"><?= number_format($product->price, 0, '.', ' ') ?></span>
                    <?php endif; ?>
                    <div>
                        <?php if ($product->latestBlog && $product->latestBlog->discount_price != null): ?>
                            <button data-bs-toggle="modal" data-bs-target="#exampleModalChegirmaEdit-<?= $product->id ?>" style="border: none; outline:none; background:transparent;">✏️</button>
                            <?= Html::a('🗑️', ['products/chegirmadelete', 'id' => $product->latestBlog->id ?? 0], [
                                'data-confirm' => 'O\'chirishni tasdiqlaysizmi?',
                                'data-method' => 'post',
                            ]) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalChegirma-<?= $product->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background: var(--surface); border-radius: 20px;">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $product->name ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php $form = ActiveForm::begin(['action' => ['products/chegirma', 'id' => $product->id], 'method' => 'post']); ?>
                        <div class="modal-body">
                            <label class="form-label">Chegirma summasi</label>
                            <input type="text" name="discount_price" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Saqlash', ['class' => 'btn-save']) ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <!-- Modal edit chegirma -->
            <div class="modal fade" id="exampleModalChegirmaEdit-<?= $product->id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background: var(--surface); border-radius: 20px;">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?= $product->name ?></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <?php $form = ActiveForm::begin(['action' => ['products/chegirmaedit', 'id' => $product->latestBlog->id ?? 0], 'method' => 'post']); ?>
                        <div class="modal-body">
                            <label class="form-label">Chegirma summasi</label>
                            <input type="text" name="discount_price" value="<?= $product->latestBlog->discount_price ?? 0 ?>" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <?= Html::submitButton('Saqlash', ['class' => 'btn-save']) ?>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Orqaga</button>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal<?= $product->id ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow" style="background: var(--surface); border-radius: 20px;">
                        <div class="modal-header border-0 px-4 pt-4 pb-0">
                            <h5 class="modal-title" style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.4rem;">
                                Productni tahrirlash
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>

                        <?php
                        $editModel = \common\models\Product::findOne($product->id);
                        $editForm = ActiveForm::begin([
                            'id' => 'edit-form-' . $product->id,
                            'action' => ['products/update', 'id' => $product->id],
                            'method' => 'post',
                            'options' => ['enctype' => 'multipart/form-data', 'style' => 'margin:0'],
                        ]); ?>

                        <div class="modal-body px-4 py-3">
                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'name', ['template' => "<label class='form-label'>Nomi</label>{input}{error}"])
                                    ->textInput(['class' => 'form-control', 'placeholder' => 'Product nomi...']) ?>
                            </div>

                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'category_id', ['template' => "<label class='form-label'>Kategoriya</label>{input}{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                                        [
                                            'prompt' => 'Kategoriyani tanlang...',
                                            'class' => 'form-select',
                                            'id' => 'edit-category-' . $product->id,
                                        ]
                                    ) ?>
                            </div>

                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'sub_category_id', ['template' => "<label class='form-label'>Subkategoriya</label>{input}{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map(
                                            \common\models\Subcategory::find()->where(['category_id' => $product->category_id])->all(),
                                            'id',
                                            'name'
                                        ),
                                        [
                                            'prompt' => 'Subkategoriyani tanlang...',
                                            'class' => 'form-select',
                                            'id' => 'edit-subcategory-' . $product->id,
                                        ]
                                    ) ?>
                            </div>
                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'sub_sub_category_id', ['template' => "<label class='form-label'>Bo'lim</label>{input}{error}"])
                                    ->dropDownList(
                                        \yii\helpers\ArrayHelper::map(
                                            \common\models\SubSubcategory::find()->where(['sub_category_id' => $product->sub_category_id])->all(),
                                            'id',
                                            'name'
                                        ),
                                        [
                                            'prompt' => 'Bo\'limni tanlang...',
                                            'class' => 'form-select',
                                            'id' => 'edit-subsubcategory-' . $product->id,
                                        ]
                                    ) ?>
                            </div>

                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'price', ['template' => "<label class='form-label'>Narx (so'm)</label>{input}{error}"])
                                    ->input('number', ['class' => 'form-control', 'placeholder' => '500000']) ?>
                            </div>

                            <div class="form-group mb-3">
                                <?= $editForm->field($editModel, 'description', ['template' => "<label class='form-label'>Tavsif</label>{input}{error}"])
                                    ->textarea(['class' => 'form-control', 'rows' => 3]) ?>
                            </div>

                            <!-- RASMLAR -->
                            <div class="form-group mb-3">
                                <label class="form-label">Mavjud rasmlar</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($product->productImages as $img): ?>
                                        <div style="position:relative; width:80px; height:80px;">
                                            <img src="<?= \common\components\FileUploader::getUrl($img->image) ?>"
                                                style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                                            <!-- O'chirish tugmasi -->
                                            <?= Html::a('✕', ['products/delete-image', 'id' => $img->id], [
                                                'style' => 'position:absolute; top:-6px; right:-6px; background:red; color:#fff;
                                                    border-radius:50%; width:20px; height:20px; display:flex;
                                                    align-items:center; justify-content:center; font-size:11px;
                                                    text-decoration:none; line-height:1;',
                                                'data-confirm' => 'Rasmni o\'chirasizmi?',
                                                'data-method' => 'post',
                                            ]) ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Yangi rasmlar qo'shish</label>
                                <input type="file" name="Product[imageFiles][]" multiple accept="image/*" class="form-control">
                            </div>
                        </div>

                        <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                            <button type="button" class="btn-cancel" data-bs-dismiss="modal">Bekor</button>
                            <?= Html::submitButton('Saqlash', ['class' => 'btn-save']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>

            <?php
            // Har bir edit modal uchun dynamic subcategory
            $this->registerJs("
        document.getElementById('edit-category-{$product->id}').addEventListener('change', function() {
            var categoryId = this.value;
            var subSelect = document.getElementById('edit-subcategory-{$product->id}');
            subSelect.innerHTML = '<option value=\"\">Yuklanmoqda...</option>';
            if (categoryId) {
                fetch('/index.php?r=products/get-subcategories&category_id=' + categoryId)
                    .then(function(r) { return r.json(); })
                    .then(function(data) {
                        subSelect.innerHTML = '<option value=\"\">Subkategoriyani tanlang...</option>';
                        Object.entries(data).forEach(function([id, name]) {
                            subSelect.innerHTML += '<option value=\"' + id + '\">' + name + '</option>';
                        });
                    });
            }
        });
    ");
            ?>

        <?php endforeach; ?>

        <?php if (empty($products)): ?>
            <div class="empty-state">
                <div class="icon">📭</div>
                <p>Hali product qo'shilmagan</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="pager-wrap" style="text-align:center; margin:30px 0;">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'options' => ['class' => 'pagination'],
            'linkOptions' => ['class' => 'page-link'],
            'prevPageLabel' => '&laquo;',
            'nextPageLabel' => '&raquo;',
        ]) ?>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="productModal">
        <div class="modal-box">
            <div class="modal-header">
                <span class="modal-title">Yangi product</span>
                <button class="modal-close" onclick="document.getElementById('productModal').classList.remove('active')">✕</button>
            </div>

            <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['enctype' => 'multipart/form-data', 'style' => 'margin:0']]); ?>

            <div class="form-group">
                <?= $form->field($model, 'name', ['template' => "<label class='form-label'>Nomi</label>{input}{error}"])
                    ->textInput(['placeholder' => 'Product nomi...', 'class' => 'form-control']) ?>
            </div>
            <div class="form-group">
                <?= $form->field($model, 'imageFiles[]', [
                    'template' => "<label class='form-label'>Rasmlar</label>{input}{error}"
                ])->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'category_id', ['template' => "<label class='form-label'>Kategoriya</label>{input}{error}"])
                    ->dropDownList(
                        \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                        ['prompt' => 'Kategoriyani tanlang...', 'class' => 'form-select', 'id' => 'category-dropdown']
                    ) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'sub_category_id', ['template' => "<label class='form-label'>Subkategoriya</label>{input}{error}"])
                    ->dropDownList(
                        [],
                        ['prompt' => 'Subkategoriyani tanlang...', 'class' => 'form-select', 'id' => 'subcategory-dropdown']
                    ) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'sub_sub_category_id', ['template' => "<label class='form-label'>Bo'limni tanlang</label>{input}{error}"])
                    ->dropDownList(
                        [],
                        ['prompt' => 'Bo\'limni tanlang...', 'class' => 'form-select', 'id' => 'subsubcategory-dropdown']
                    ) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'price', ['template' => "<label class='form-label'>Narx (so'm)</label>{input}{error}"])
                    ->input('number', ['placeholder' => 'Masalan: 500000', 'class' => 'form-control']) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'description', ['template' => "<label class='form-label'>Tavsif</label>{input}{error}"])
                    ->textarea(['placeholder' => 'Product haqida...', 'class' => 'form-control']) ?>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="document.getElementById('productModal').classList.remove('active')">Bekor</button>
                <?= Html::submitButton('Saqlash', ['class' => 'btn-save']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>



    <?php
    $this->registerJs("
    // Modal tashqarisiga bosish
    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    // Dynamic subcategory
    document.getElementById('category-dropdown').addEventListener('change', function() {
        var categoryId = this.value;
        var subcategoryDropdown = document.getElementById('subcategory-dropdown');

        subcategoryDropdown.innerHTML = '<option value=\"\">Yuklanmoqda...</option>';

        if (categoryId) {
            fetch('/index.php?r=products/get-subcategories&category_id=' + categoryId)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    subcategoryDropdown.innerHTML = '<option value=\"\">Subkategoriyani tanlang...</option>';
                    Object.entries(data).forEach(function([id, name]) {
                        subcategoryDropdown.innerHTML += '<option value=\"' + id + '\">' + name + '</option>';
                    });
                })
                .catch(function() {
                    subcategoryDropdown.innerHTML = '<option value=\"\">Xatolik yuz berdi</option>';
                });
        } else {
            subcategoryDropdown.innerHTML = '<option value=\"\">Subkategoriyani tanlang...</option>';
        }
    });
");
    ?>

    <?php
    $this->registerJs("
    // Modal tashqarisiga bosish
    document.getElementById('productModal').addEventListener('click', function(e) {
        if (e.target === this) this.classList.remove('active');
    });

    // Dynamic subcategory
    document.getElementById('subcategory-dropdown').addEventListener('change', function() {
        var sub_categoryId = this.value;
        var subsubcategoryDropdown = document.getElementById('subsubcategory-dropdown');

        subsubcategoryDropdown.innerHTML = '<option value=\"\">Yuklanmoqda...</option>';

        if (sub_categoryId) {
            fetch('/index.php?r=products/get-sub-subcategories&sub_category_id=' + sub_categoryId)
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    subsubcategoryDropdown.innerHTML = '<option value=\"\">Subkategoriyani tanlang...</option>';
                    Object.entries(data).forEach(function([id, name]) {
                        subsubcategoryDropdown.innerHTML += '<option value=\"' + id + '\">' + name + '</option>';
                    });
                })
                .catch(function() {
                    subsubcategoryDropdown.innerHTML = '<option value=\"\">Xatolik yuz berdi</option>';
                });
        } else {
            subsubcategoryDropdown.innerHTML = '<option value=\"\">Subkategoriyani tanlang...</option>';
        }
    });
");
    ?>

    <?php
    $updateStatusUrl = Url::to(['/products/update-status']);
    $this->registerJs("
    document.querySelectorAll('.status-toggle').forEach(function(toggle) {
        toggle.addEventListener('change', function() {
            var productId = this.dataset.id;
            var status = this.checked ? 1 : 0;
            var label = this.nextElementSibling;

            fetch('{$updateStatusUrl}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ id: productId, status: status })
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data.success) {
                    label.textContent = status == 1 ? 'Active' : 'No active';
                    label.style.color = status == 1 ? 'green' : 'red';
                }
            });
        });
    });
");
    ?>

</body>

</html>