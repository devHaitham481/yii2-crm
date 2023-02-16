<?php

namespace backend\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "label".
 *
 * @property int $id
 * @property string|null $label
 */
class Label extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'label';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'project_id'], 'integer'],
            [['label'], 'string', 'max' => 50],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'label' => Yii::t('app', 'Label'),
        ];
    }

    public function getAllProjects()
    {
       $project=Project::find()->all();
       return $projectList=ArrayHelper::map($project,'id','name');
    }


    /**
     * {@inheritdoc}
     * @return LabelQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LabelQuery(get_called_class());
    }
}
