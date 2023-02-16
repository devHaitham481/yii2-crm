<?php

namespace backend\models;

use Yii;
use backend\models\Label;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "entity_column".
 *
 * @property int $id
 * @property string|null $column
 * @property string|null $main_label_id
 * @property int|null $is_required
 * @property int|null $column_type
 * @property string|null $source_table
 * @property int|null $order
 */
class EntityColumn extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entity_column';
    }
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
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
    public function getAllLabels()
    {

        $label = Label::find()->all();
        return $labels =ArrayHelper::map($label,'id','label');
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_required',  'order', 'project_id'], 'integer'],
            [['column', 'main_label_id', 'source_table','column_type','column_label'], 'string', 'max' => 45],

        ];
    }

    public function relations()
    {
        // return array(
        //     // 'project'=>array(self::BELONGS_TO, 'Project', 'project_id')
        //     // 'categories'=>array(self::MANY_MANY, 'Category',
        //     //     'tbl_post_category(post_id, category_id)'),
        //     'project'=>array(self::HAS_ONE, 'Project', 'project_id'),
        // );
    }

    public function getLabel()
    {
        return $this->hasOne(Label::className(), ['id' => 'main_label_id']);

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
    public function getAllProjects()
    {
       $project=Project::find()->all();
       return $projectList=ArrayHelper::map($project,'id','name');
    }

    /**
     * {@inheritdoc}
     * @return EntityColumnQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EntityColumnQuery(get_called_class());
    }
}
