<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EntityBranch */

$this->title = Yii::t('app', 'Create Entity Branch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity Branches'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-branch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
