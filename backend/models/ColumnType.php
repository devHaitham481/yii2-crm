<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "column_type".
 *
 * @property int $id
 * @property string|null $name
 */
class ColumnType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'column_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return ColumnTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ColumnTypeQuery(get_called_class());
    }
}
