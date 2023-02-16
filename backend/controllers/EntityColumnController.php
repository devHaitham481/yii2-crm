<?php

namespace backend\controllers;

use backend\models\EntityColumn;
use backend\models\EntityColumnSearch;
use backend\models\DropDownItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\base\Model;

use Yii;


/**
 * EntityColumnController implements the CRUD actions for EntityColumn model.
 */
class EntityColumnController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ]
            ]
        );
    }
    // public function beforeAction($action) {
    //     if($action->id == 'create') {
    //         Yii::$app->request->enableCsrfValidation = false;
    //     }
    //     return parent::beforeAction($action);
    // }

    /**
     * Lists all EntityColumn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntityColumnSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single EntityColumn model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new EntityColumn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */    
    public function actionCreate()
    {
            if(Yii::$app->user->can('/entity-column/*'))
         {

            $model = new EntityColumn();
            if ($this->request->isPost) {
                if($model->load($this->request->post())){
                    if($model->validate()){
                        $model->save();
                    }
                    else{
                        $errors = $model->errors;
                    }
                try{ 
                    $dropDownListKey = $this->request->post()['DropDownListKey']??null;
                    $dropDownListName = $this->request->post()['DropDownListName']??null;
                    $i = 0; 
                    if($dropDownListKey != null && $dropDownListName != null){
                        foreach($dropDownListKey as $key) {

                            $dropDownItemModel = new DropDownItem(); 
                            $dropDownItemModel->key = $key['key'];
                            $dropDownItemModel->name = $dropDownListName[$i]['name'];
                            $dropDownItemModel->source_type = 'entity_column';
                            $dropDownItemModel->source_id = $model->id;
                            $dropDownItemModel->save();
                            $i++;
                            
                        }

                    }

                    $this->createEntityColumnInEntityTable($model);
                    return $this->redirect(['view', 'id' => $model->id]);


                } catch(yii\db\Exception $e) { 
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
                 
                    
                }
                else {
                    $model->loadDefaultValues();
                }
    
     
            }
            // on re-direct, form must be re-freshed without any values 
            return $this->render('create', [
                'model' => $model
            ]);
           }
            else{
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
            }
    }
        
    
    private function createEntityColumnInEntityTable($model) 
    {   
        if($model->column_type == 'dropdown'){
        $model->column_type = 'tinyint';
        return Yii::$app->db->createCommand()->addColumn($model->project->entity, $model->column, $model->column_type)->execute();
        }
        else {
        return Yii::$app->db->createCommand()->addColumn($model->project->entity, $model->column, $model->column_type)->execute(); 
        }
    }


    /**
     * Updates an existing EntityColumn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EntityColumn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $project_id = $_GET['project_id']??null;
        try{ 
            $this->deleteEntityColumnFromEntityTable($this->findModel($id));
            $this->findModel($id)->delete();
            Yii::$app->session->setFlash('success', "successfully deleted entity column");
            if($project_id){
                return $this->redirect(['/project/view', 'id' => $project_id]);
            }
            return $this->redirect(Yii::$app->request->referrer);
        } catch(\yii\db\Exception $e) {
            Yii::$app->session->setFlash('error', $e.getMessage()); 
        }

    }
    protected function deleteEntityColumnFromEntityTable($model) 
    {   
      return Yii::$app->db->createCommand()->dropColumn($model->project->entity, $model->column, $model->column_type)->execute();
    }
    /**
     * Finds the EntityColumn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EntityColumn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntityColumn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
