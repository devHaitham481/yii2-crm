<?php

/* @var $this \yii\web\View */

/* @var $content string */

use backend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

// use Yii;
use backend\models\Entity;
use yii\helpers\ArrayHelper;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>" class="h-100">
    <head>
        <link href="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.css" rel="stylesheet">
        <!-- Scripts -->

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="bootstable.js" ></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>

        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'innerContainerOptions' => ['class' => 'container-fluid'],
        'options' => [
            'class' => 'navbar navbar-expand-xl navbar-dark bg-dark flex-nowrap fixed-top  ',
        ],
    ]);
    // $rows = (new \yii\db\Query())
    // ->select(['id', ''])
    // ->from('user')
    // ->all();

    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],

                [
                    'label' => 'الإدارة',
                    'items' => [
                      
                         ['label' => 'Projects', 'url' => ['/project/index']],
                        //  ['label' => 'View all Entity Column', 'url' => ['/entity-column/index']],
                        //  ['label' => 'View all Entity Branch', 'url' => ['/entity-branch/index']],
                        //  ['label' => 'View all Entity Branch Column', 'url' => ['/entity-branch-column/index']],
                        //  ['label' => 'View all Entity Branch Staff', 'url' => ['/entity-branch-staff/index']],
                         ['label' => 'Company Users', 'url' => ['/user/index']],
            ],
        ],

        // [
        //     'label' => 'Management',
        //     'items' => [
        //          ['label' => 'Projects', 'url' => ['/project/index']],
        //         //  ['label' => 'View all Entity Column', 'url' => ['/entity-column/index']],
        //         //  ['label' => 'View all Entity Branch', 'url' => ['/entity-branch/index']],
        //         //  ['label' => 'View all Entity Branch Column', 'url' => ['/entity-branch-column/index']],
        //         //  ['label' => 'View all Entity Branch Staff', 'url' => ['/entity-branch-staff/index']],
        //         //  '<li class="dropdown-header">Dropdown Header</li>',
        //         //  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
        //     ],
        // ],
        ['label' => 'المشاريع', 'url' => ['/project/index']],
        ['label' => 'العملاء', 'url' => ['/entity/index']],

    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    // $menuItems[] =   [
    //     'label' => 'Administration',
    //     'items' => [
    //          ['label' => 'Create a Project', 'url' => ['/project/create']],
    //          ['label' => 'Create an Entity Column', 'url' => ['/entity-column/create']],
    //          ['label' => 'Create an Entity Branch', 'url' => ['/entity-branch/create']],
    //          ['label' => 'Create an Entity Branch Column', 'url' => ['/entity-branch-column/create']],
    //          ['label' => 'Create an Entity Branch Staff', 'url' => ['/entity-branch-staff/create']],


    //         //  '<li class="dropdown-header">Dropdown Header</li>',
    //         //  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
    //     ],
    // ];
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => $menuItems,
    ]);
//     $entityList = Project::find()
//     ->all();
//     $e = [];
//     foreach($entityList as $entity) {
// $e[] = $entity->entity;
//     }
    // var_dump(Entity::getAllEntities());
    // $entityList = Entity::getAllEntities();
    // // $array = [
    // //     ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
    // //     ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
    // //     ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
    // // ];
    
    // $array = [
    //     ['id' => '123', 'name' => 'aaa', 'class' => 'x'],
    //     ['id' => '124', 'name' => 'bbb', 'class' => 'x'],
    //     ['id' => '345', 'name' => 'ccc', 'class' => 'y'],
    // ];
    
    // $result = ArrayHelper::map($array, 'entity');

    // var_dump($result);
    // echo Nav::widget([
    //     'items' => [
    //         // [
    //         //     'label' => 'Administration',
    //         //     'url' => ['site/index'],
    //         //     'linkOptions' => [],
    //         // ],
    //         [
    //             'label' => 'Administration',
    //             'items' => [
    //                  ['label' => 'Create a Project', 'url' => ['/project/create']],
    //                  ['label' => 'Create an Entity Column', 'url' => ['/entity-column/create']],
    //                  ['label' => 'Create an Entity Branch', 'url' => ['/entity-branch/create']],
    //                  ['label' => 'Create an Entity Branch Column', 'url' => ['/entity-branch-column/create']],
    //                  ['label' => 'Create an Entity Branch Staff', 'url' => ['/entity-branch-staff/create']],


    //                 //  '<li class="dropdown-header">Dropdown Header</li>',
    //                 //  ['label' => 'Level 1 - Dropdown B', 'url' => '#'],
    //             ],
    //         ],
    //     ],
    //     'options' => ['class' =>'nav navbar-nav'],
    // ]);
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
            <p class="float-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
            <p class="float-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage();
