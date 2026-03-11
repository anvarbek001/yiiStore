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
        // echo Html::input('text', 'search', '', ['id' => 'search_input', 'class' => 'search_input form-control', 'placeholder' => 'Qidirish...']);

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
            <div id="products-container"></div>
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

    <?php $this->endBody() ?>

    <script>
        const searchInput = document.getElementById('search_input');
        const searchUrl = '<?= \yii\helpers\Url::to(['/site/search']) ?>';
        let timer;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(timer);

            timer = setTimeout(() => {
                const searchValue = e.target.value.trim();
                searchProducts(searchValue);
            }, 400)
        });

        function searchProducts(query) {
            fetch(`${searchUrl}&q=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
            }).then(res => res.json()).then(data => {
                renderProducts(data)
            }).catch(error => console.log("Xato: ", error))
        }

        function renderProducts(products) {
            const container = document.getElementById('products-container');

            if (products.length === 0) {
                container.innerHTML = '<p>Mahsulot topilmadi</p>';
                return;
            }

            container.innerHTML = products.map(product => `
                <div class="product-card">
                    <img src="${product.image}" alt="${product.name}">
                    <h5>${product.name}</h5>
                    <p>${product.price} so'm</p>
                </div>
            `).join('');
        }
    </script>
</body>

</html>
<?php $this->endPage();
