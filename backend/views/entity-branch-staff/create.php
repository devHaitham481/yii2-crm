<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EntityBranchStaff */

$this->title = Yii::t('app', 'Create Entity Branch Staff');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity Branch Staff'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-branch-staff-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
