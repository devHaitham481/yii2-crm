<?php

namespace backend\models;

use yii\helpers\ArrayHelper; 
use Yii;

/**
 * This is the model class for table "city".
 *
 * @property int $cityId
 * @property string|null $name
 * @property string|null $countryId
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'countryId'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cityId' => Yii::t('app', 'City ID'),
            'name' => Yii::t('app', 'Name'),
            'countryId' => Yii::t('app', 'Country ID'),
        ];
    }

    public static function getAllCities() 
    {
        $city = City::find()->all(); 
        return $citiesList = ArrayHelper::map($city, 'id', 'name'); 
    }
    

    /**
     * {@inheritdoc}
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }
}
