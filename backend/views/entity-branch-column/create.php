<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\EntityBranchColumn */

$this->title = Yii::t('app', 'Create Entity Branch Column');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entity Branch Columns'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-branch-column-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model 
    ]) ?>

</div>
