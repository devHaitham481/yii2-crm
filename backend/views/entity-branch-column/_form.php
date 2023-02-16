<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\EntityBranchColumn */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entity-branch-column-form">

    <?php $form = ActiveForm::begin(); ?>




    <?= $form->field($model, 'column_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column_label')->textInput(['maxLength' => true]) ?>

    <?= $form->field($model, 'main_label_id')->dropdownList($model->getAllLabels(),
        ['prompt' => 'Select Label']);
    ?>

    <?= $form->field($model, 'column_type')->dropdownList($model->getColumnTypes(), 
    ['prompt' => 'Select Column Type', 'id' => 'columnTypes', 'onchange'=>'checkValue(this)'])?>


    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
