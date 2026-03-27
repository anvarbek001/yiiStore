<?php

/**
 * @var ChildrenCategory[] $nodes
 * @var int $depth  (3 dan boshlanadi, chunki 0,1,2 allaqachon band)
 * @var int $subSubCategoryId
 */

use yii\bootstrap5\Html;
use yii\helpers\Url;

// Depth ga qarab rang palette
$palettes = [
    ['border' => '#fde68a', 'bg' => '#fffbeb', 'hover' => '#fef9c3', 'icon_bg' => '#fef3c7', 'icon_color' => '#d97706', 'badge_color' => '#d97706', 'badge_bg' => '#fef3c7', 'add_hover' => '#d97706'],
    ['border' => '#fbcfe8', 'bg' => '#fdf2f8', 'hover' => '#fce7f3', 'icon_bg' => '#fce7f3', 'icon_color' => '#db2777', 'badge_color' => '#db2777', 'badge_bg' => '#fce7f3', 'add_hover' => '#db2777'],
    ['border' => '#c7d2fe', 'bg' => '#eef2ff', 'hover' => '#e0e7ff', 'icon_bg' => '#e0e7ff', 'icon_color' => '#4338ca', 'badge_color' => '#4338ca', 'badge_bg' => '#e0e7ff', 'add_hover' => '#4338ca'],
];
$p = $palettes[($depth - 3) % count($palettes)];
$indent = ($depth - 3) * 16; // px chuqurlik
$icons = ['🏷️', '🔖', '📌', '🗃️'];
$icon = $icons[($depth - 3) % count($icons)];
?>

<?php foreach ($nodes as $node): ?>
    <div style="margin-left: <?= $indent ?>px;">
        <div style="
            background: #fff;
            border-radius: <?= max(10 - $depth, 6) ?>px;
            border: 1.5px solid <?= $p['border'] ?>;
            overflow: hidden;
            margin-bottom: 6px;
        ">
            <!-- Header -->
            <div class="d-flex align-items-center justify-content-between"
                style="padding: <?= max(10 - $depth, 7) ?>px 13px; cursor: pointer; transition: background .15s; background: #fff;"
                data-bs-toggle="collapse"
                data-bs-target="#collapse_children_<?= $node->id ?>"
                onmouseover="this.style.background='<?= $p['hover'] ?>'"
                onmouseout="this.style.background='#fff'">
                <div class="d-flex align-items-center gap-2">
                    <div style="
                        width: <?= max(28 - $depth * 2, 20) ?>px;
                        height: <?= max(28 - $depth * 2, 20) ?>px;
                        border-radius: 6px;
                        background: <?= $p['icon_bg'] ?>;
                        color: <?= $p['icon_color'] ?>;
                        display: flex; align-items: center; justify-content: center;
                        font-size: <?= max(13 - $depth, 10) ?>px;
                        flex-shrink: 0;
                    "><?= $icon ?></div>
                    <div>
                        <div style="
                            font-size: 10px; font-weight: 600; letter-spacing: .7px;
                            text-transform: uppercase; color: <?= $p['badge_color'] ?>;
                            background: <?= $p['badge_bg'] ?>; padding: 2px 8px;
                            border-radius: 20px; margin-bottom: 3px; display: inline-block;
                        ">Daraja <?= $depth ?></div>
                        <div style="font-size: <?= max(14 - $depth, 12) ?>px; font-weight: 600; color: #1e293b;">
                            <?= Html::encode($node->name) ?>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="text-muted" style="font-size:12px;"><?= count($node->childrens) ?> ta</span>
                    <button class="btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#modal_editChildren_<?= $node->id ?>"
                        onclick="event.stopPropagation()">✏️</button>
                    <form method="post"
                        action="<?= Url::to(['children-category/delete', 'id' => $node->id]) ?>"
                        style="display:inline" onclick="event.stopPropagation()">
                        <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                        <button type="submit" class="btn-del"
                            onclick="event.stopPropagation(); return confirm('O\'chirishni tasdiqlaysizmi?')">🗑️</button>
                    </form>
                    <span class="chevron">▼</span>
                </div>
            </div>

            <!-- Children body (collapse) -->
            <?php if (!empty($node->childrens)): ?>
                <div class="collapse" id="collapse_children_<?= $node->id ?>">
                    <div style="border-top: 1.5px solid <?= $p['border'] ?>; padding: 8px 10px; background: <?= $p['bg'] ?>;">
                        <?= $this->render('_children', [
                            'nodes'             => $node->childrens,
                            'depth'             => $depth + 1,
                            'subSubCategoryId'  => $subSubCategoryId,
                        ]) ?>

                        <!-- Add child button -->
                        <button class="add-row mt-1"
                            style="--hover-border: <?= $p['add_hover'] ?>; --hover-color: <?= $p['add_hover'] ?>;"
                            data-bs-toggle="modal"
                            data-bs-target="#modal_addChildren_<?= $node->id ?>">
                            <span>＋</span> Pastki daraja qo'shish
                        </button>
                    </div>
                </div>
            <?php else: ?>
                <!-- Agar farzand yo'q bo'lsa ham add tugmasini ko'rsatish uchun collapse kerak emas -->
                <div class="collapse" id="collapse_children_<?= $node->id ?>">
                    <div style="border-top: 1.5px solid <?= $p['border'] ?>; padding: 8px 10px; background: <?= $p['bg'] ?>;">
                        <button class="add-row"
                            data-bs-toggle="modal"
                            data-bs-target="#modal_addChildren_<?= $node->id ?>">
                            <span>＋</span> Pastki daraja qo'shish
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="modal_editChildren_<?= $node->id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <h5 class="modal-title fw-bold"><?= $icon ?> Tahrirlash (Daraja <?= $depth ?>)</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= Url::to(['children-category/update', 'id' => $node->id]) ?>">
                    <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                    <div class="modal-body px-4 py-3">
                        <label class="form-label fw-semibold">Nomi</label>
                        <input type="text" name="ChildrenCategory[name]"
                            value="<?= Html::encode($node->name) ?>"
                            class="form-control form-control-lg" style="border-radius:10px" required>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold">Saqlash</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Child Modal -->
    <div class="modal fade" id="modal_addChildren_<?= $node->id ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <h5 class="modal-title fw-bold"><?= $icon ?> Yangi pastki daraja</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="<?= Url::to(['children-category/create']) ?>">
                    <?= Html::hiddenInput(\Yii::$app->request->csrfParam, \Yii::$app->request->getCsrfToken()) ?>
                    <div class="modal-body px-4 py-3">
                        <input type="hidden" name="ChildrenCategory[sub_sub_category_id]" value="<?= $subSubCategoryId ?>">
                        <input type="hidden" name="ChildrenCategory[parent_id]" value="<?= $node->id ?>">
                        <label class="form-label fw-semibold">Nomi</label>
                        <input type="text" name="ChildrenCategory[name]"
                            class="form-control form-control-lg" style="border-radius:10px"
                            placeholder="Nomi..." required>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 pt-0 gap-2">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Bekor</button>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold">Qo'shish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php endforeach; ?>