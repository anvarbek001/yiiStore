<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use common\widgets\LanguageSwitcher;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        .search_input {
            margin-right: 15px;
            width: 15rem;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        NavBar::begin([
            'brandLabel' => Yii::$app->name,
            'brandUrl' => Yii::$app->homeUrl,
            'options' => [
                'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top',
            ],
        ]);
        $menuItems = [
            ['label' => Yii::t('app', 'home'), 'url' => ['/site/index']],
            // ['label' =>  Yii::t('app', 'about'), 'url' => ['/site/about']],
            // ['label' => Yii::t('app', 'contact'), 'url' => ['/site/contact']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('app', 'signup'), 'url' => ['/site/signup']];
        }

        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
            'items' => $menuItems,
        ]);
        echo Html::input('text', 'search', '', ['id' => 'search_input', 'class' => 'search_input form-control', 'placeholder' => 'Qidirish...']);

        if (Yii::$app->user->isGuest) {
            echo Html::tag('div', Html::a(Yii::t('app', 'login'), ['/site/login'], ['class' => ['btn btn-link login text-decoration-none']]), ['class' => ['d-flex']]);
        } else {
            echo Html::a('<i class="bi bi-heart-fill"></i>', ['/site/saved'], ['encode' => false]);
            echo Html::a('<i class="bi bi-cart-fill"></i>', ['/site/korzinkasaved'], ['encode' => false, 'style' => "margin-left:5px;"]);
            echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
                . Html::submitButton(
                    Yii::t('app', 'logout') . '(' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout text-decoration-none']
                )
                . Html::endForm();
            echo Html::a('<i class="bi bi-person-circle"></i>', ['/site/profile'], ['encode' => false]);
        }
        echo LanguageSwitcher::widget();
        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-start">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-end"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <!-- Modal o'rniga dropdown -->
    <div id="searchDropdown" style="
            display: none;
            position: fixed;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            width: 700px;
            max-width: 95vw;
            max-height: 70vh;
            overflow-y: auto;
            background: #17171f;
            border: 1px solid #2a2a38;
            border-radius: 16px;
            z-index: 1050;
            box-shadow: 0 16px 48px rgba(0,0,0,0.6);
        ">
        <div style="padding:16px 20px; border-bottom:1px solid #2a2a38; display:flex; justify-content:space-between; align-items:center;">
            <span style="color:#e8e8f0; font-weight:700;">Qidiruv natijalari</span>
            <span onclick="closeSearch()" style="color:#6b6b80; cursor:pointer; font-size:1.2rem;">✕</span>
        </div>
        <div id="search-modal-body" style="padding:16px;">
            <p style="color:#6b6b80;">Qidirilmoqda...</p>
        </div>
    </div>

    <?php $this->endBody() ?>

    <script>
        const searchInput = document.getElementById('search_input');
        const searchUrl = '<?= \yii\helpers\Url::to(['/site/search']) ?>';
        let timer;
        let searchModal;

        document.addEventListener('DOMContentLoaded', () => {
            searchModal = new bootstrap.Modal(document.getElementById('searchModal'));
        });

        document.addEventListener('click', (e) => {
            const dropdown = document.getElementById('searchDropdown');
            const input = document.getElementById('search_input');
            if (!dropdown.contains(e.target) && e.target !== input) {
                closeSearch();
            }
        });

        searchInput.addEventListener('input', (e) => {
            clearTimeout(timer);
            const val = e.target.value.trim();
            if (val.length < 2) return;

            timer = setTimeout(() => {
                searchProducts(val);
            }, 400);
        });

        function searchProducts(query) {
            document.getElementById('searchDropdown').style.display = 'block';
            document.getElementById('search-modal-body').innerHTML = '<p style="color:#6b6b80; text-align:center; padding:20px;">Qidirilmoqda...</p>';

            fetch(`${searchUrl}&q=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.json())
                .then(data => renderProducts(data))
                .catch(err => console.log("Xato:", err));
        }

        function closeSearch() {
            document.getElementById('searchDropdown').style.display = 'none';
        }

        function renderProducts(products) {
            const body = document.getElementById('search-modal-body');

            if (!products.length) {
                body.innerHTML = '<p style="color:#6b6b80; text-align:center; padding:40px 0;">Mahsulot topilmadi</p>';
                return;
            }

            body.innerHTML = `
                <div style="display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:16px;">
                    ${products.map(p => `
                        <a href="/index.php?r=site/shop&id=${p.id}" style="text-decoration:none;">
                            <div style="background:#1e1e2a; border:1px solid #2a2a38; border-radius:12px; overflow:hidden; transition:border-color .2s;"
                                onmouseover="this.style.borderColor='#6c63ff'" onmouseout="this.style.borderColor='#2a2a38'">
                                <img src="${p.image}" alt="${p.name}"
                                    style="width:100%; height:140px; object-fit:cover;">
                                <div style="padding:12px;">
                                    <div style="font-weight:700; color:#e8e8f0; font-size:0.9rem; margin-bottom:4px;">${p.name}</div>
                                    <div style="color:#43d9a2; font-weight:700; font-size:0.95rem;">${parseInt(p.price).toLocaleString('ru-RU')} so'm</div>
                                </div>
                            </div>
                        </a>
                    `).join('')}
                </div>
            `;
        }
    </script>
</body>

</html>
<?php $this->endPage();
