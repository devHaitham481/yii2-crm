<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string|null $details
 * @property string|null $category
 * @property string|null $entity
 * @property string|null $entity_branch
 * @property string|null $entity_label
 * @property string|null $entity_branch_label
 */
class Project extends \yii\db\ActiveRecord
{
    use yii\base\ArrayableTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }
    public function getEntityColumn()
    {   
        //project_id is in EntityColumn // id is in Project 
        return $this->hasMany(EntityColumn::className(), ['project_id' => 'id']);
    }
    public function getEntityBranchColumn()
    {
        return $this->hasMany(EntityBranchColumn::className(), ['project_id' => 'id']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'details', 'category', 'entity', 'entity_branch', 'entity_label', 'entity_branch_label'], 'string', 'max' => 255],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Project ID'),
            'name' => Yii::t('app', 'Name'),
            'details' => Yii::t('app', 'Details'),
            'category' => Yii::t('app', 'Category'),
            'entity' => Yii::t('app', 'Entity'),
            'entity_branch' => Yii::t('app', 'Entity Branch'),
            'entity_label' => Yii::t('app', 'Entity Label'),
            'entity_branch_label' => Yii::t('app', 'Entity Branch Label'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ProjectQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProjectQuery(get_called_class());
    }
    // public static function getCount() 
    // {
    //     $projectsCount = ProjectQuery::find(array('id' => Yii::$app->user->id))->count();
    // }
}
