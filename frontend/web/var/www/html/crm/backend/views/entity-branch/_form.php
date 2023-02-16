<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EntityBranch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-branch-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'entity_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
