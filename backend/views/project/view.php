<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model backend\models\Project */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Projects'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>

    <?= Html::a(Yii::t('app', 'Take me to data sheet'), ['entity/entity-sheet-data', 'project_id' => $model->id], ['class' => 'btn btn-warning']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'details',
            'category',
            'entity',
            'entity_branch',
            'entity_label',
            'entity_branch_label',
        ],
    ]) ?>


<h3> Column Labels </h3> 
<p>
     <?= Html::a(Yii::t('app', 'Create Column Labels'), ['label/create'], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
        'dataProvider' => $entityColumnLabelDataProvider,
        'filterModel' => $entityColumnLabelModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'label',

            ['class' => 'yii\grid\ActionColumn',
            'buttons'  => [

                'view' => function($url, $model) {
                
                    $url = Url::to(['label/view', 'id' => $model->id, 'project_id' => $model->project_id]);
                
                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url);
                
                }
                
            ],
             'controller' => 'label'],
        ],
    ]); ?>

<h3> Entity Columns </h3> 
<p>
        <?= Html::a(Yii::t('app', 'Create Entity Column'), ['entity-column/create', 'project_id' => $model->id], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
        'dataProvider' => $entityColumnDataProvider,
        'filterModel' => $entityColumnModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'column',
            [
                'class' => 'yii\grid\DataColumn', 
                'attribute' => 'label', 
                'value' => function($data) {
                    return $data->label->label;
                }
            ],
            'column_label',
            'column_type',
            'order', 

            ['class' => 'yii\grid\ActionColumn', 
            'buttons'  => [

                'view' => function($url, $model) {
                
                    $url = Url::to(['entity-column/view', 'id' => $model->id, 'project_id' => $model->project_id]);
                
                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url);
                
                }
                
            ],
             'controller' => 'entity-column'], 

        ],
    ]); ?>

<h3> Entity Branch Columns </h3> 
<p>
     <?= Html::a(Yii::t('app', 'Create Entity Branch Column'), ['entity-branch-column/create',   'project_id' => $model->id ], ['class' => 'btn btn-success']) ?>
</p>
<?= GridView::widget([
        'dataProvider' => $entityBranchColumnDataProvider,
        'filterModel' => $entityBranchColumnModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'column_name',
            [
                'class' => 'yii\grid\DataColumn', 
                'attribute' => 'label', 
                'value' => function($data) {
                    return $data->label->label;
                }
            ],
            'column_label',
            'column_type',
            'order', 

            ['class' => 'yii\grid\ActionColumn',
            'buttons'  => [

                'view' => function($url, $model) {
                
                    $url = Url::to(['entity-branch-column/view', 'id' => $model->id, 'project_id' => $model->project_id]);
                
                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url);
                
                }
                
            ],
             'controller' => 'entity-branch-column'
        ],
        ],
    ]); ?>

</div>
