<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use backend\models\EntityColumn;
use backend\models\DropDownItem;

   //use app\models\user;
/* @var $this yii\web\View */
/* @var $model backend\models\EntityColumn */
/* @var $form yii\widgets\ActiveForm */

// var_dump($project[0]["name"]);
//     die();  

?>

<div class="entity-column-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->errorSummary($model); ?>


    <?= $form->field($model, 'column')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'column_label')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'main_label_id')->dropdownList($model->getAllLabels(),
        ['prompt' => 'Select Label']); ?>

    <?= $form->field($model, 'column_type')->dropdownList($model->getColumnTypes(), 
    ['prompt' => 'Select Column Type', 'id' => 'columnTypes', 'onchange'=>'checkValue(this)'])?>

    <?= $form->field($model, 'order')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
