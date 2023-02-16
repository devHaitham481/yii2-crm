<?php 

use yii\bootstrap4\ActiveForm; 
use yii\bootstrap4\Html; 
use \backend\helpers\siteHelper; 


$this->title = 'Create Account'; 
?> 

<div class="create-account"> 
    <div class="mt-5 offset-lg-3 col-lg-6"> 
        <h1><?= Html::encode($this->title) ?></h1> 
        
        <p> Please fill out the following fields to create an account </p> 
        <?php $form = ActiveForm::begin(['id' => 'create-account']); ?> 

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?> 

            <?= $form->field($model, 'email')->input('email') ?> 

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'roles')->dropdownList($model->getRoles(), 
    ['prompt' => 'Select Column Type', 'id' => 'roles'])?>

    <div class="form-group">
        <?= Html::submitButton('Create Account', ['class' => 'btn btn-primary btn-block', 'name' => 'createAccount-button']) ?>;
</div> 

<?php ActiveForm::end(); ?>
</div>
        