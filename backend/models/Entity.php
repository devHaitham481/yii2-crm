<?php

namespace backend\models;
use backend\models\Project;
use Yii;
use yii\base\Application;
use yii\helpers\ArrayHelper; 


/**
 * This is the model class for table "entity_branch".
 *
 * @property int $id
 * @property string|null $entity_name
 * @property int $entity_id
 */
class Entity extends \yii\db\ActiveRecord
{
    

    public function insertEntityData($tableName, $formData, $project_id) 
    {
        $formData['project_id'] = $project_id;

       return Yii::$app->db->createCommand()->insert($tableName, $formData)->execute();
         
    }

    public function updateEntityData($tableName, $formData, $project_id)
    {
        $formData['project_id'] = $project_id; 
        $id = $formData['id'];
        return Yii::$app->db->createCommand()->update($tableName, $formData, "id = $id")->execute();
    //    dd($status);
    }


}
