<?php

namespace backend\models;
use yii\helpers\ArrayHelper;
use backend\models\Label;
use Yii;

/**
 * This is the model class for table "entity_branch_column".
 *
 * @property int $id
 * @property string|null $column
 * @property string|null $main_label_id
 * @property int|null $is_required
 * @property int|null $column_type
 * @property string|null $source_table
 * @property int|null $order
 */
class EntityBranchColumn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entity_branch_column';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'is_required', 'main_label_id', 'order', 'project_id'], 'integer'],
            [['column_name',  'column_type', 'source_table', 'column_label'], 'string', 'max' => 45],
        ];
    }
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
    public function getAllLabels()
    {

        $label = Label::find()->all();
        return $labels =ArrayHelper::map($label,'id','label');
    }
    public function getColumnTypes()
    {
        $column_type = ColumnType::find()->all(); 
        return $columnTypes = ArrayHelper::map($column_type, 'name', 'name');
    }

    public function getDropDownItems() 
    {
        return $this->hasMany(DropDownItem::className(), ['source_id', 'id']);
    }

    public function getLabel()
    {   
        // dd($this->hasOne(Label::className(), ['id', 'main_label_id']));
        return $this->hasOne(Label::className(), ['id' => 'main_label_id']);

        // return "HI";
    }



    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Entity Column ID'),
            'column' => Yii::t('app', 'Column'),
            'main_label_id' => Yii::t('app', 'Main Label ID'),
            'is_required' => Yii::t('app', 'Is Required'),
            'column_type' => Yii::t('app', 'Column Type'),
            'source_table' => Yii::t('app', 'Source Table'),
            'order' => Yii::t('app', 'Order'),
        ];
    }


    public function getAllEntityBranches()
    {
       $entityBranch = EntityBranch::find()->all();
       return $entityBranchList = ArrayHelper::map($entityBranch, 'id', 'entity_name');
    }
    public function getAllProjects()
    {
       $project=Project::find()->all();
       return $projectList=ArrayHelper::map($project,'id','name');
    }

    /**
     * {@inheritdoc}
     * @return EntityBranchColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntityBranchColumnQuery(get_called_class());
    }
}
