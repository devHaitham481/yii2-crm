<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm; 
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\EntityBranchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Entity Branches');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entity-branch-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Entity Branch'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'entity_name',
            'entity_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end();
$url = Url::to(['entity-branch/create-data']);

    ?>

</div>


<form action=<?= $url ?> method = "post" >
<input type="hidden" name="_csrf-backend" value="qII7tPdNFXCi_kzXTM1Tub-Fgudegzy4MuAtML7vldjnzHT2rz5ePvuNCoYfiWfxz8vygTi1W9RBs2FF6J7CkQ==">  <div class="form-group">
    <label for="email">Entity Branch :</label>
    <input type="email" class="form-control" id="email" value=>
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>

 </form> 

