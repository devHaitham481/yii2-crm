<?php

namespace backend\controllers;

use backend\models\Project;
use backend\models\ProjectSearch;
use backend\models\EntityColumnSearch;
use backend\models\EntityBranchColumnSearch;
use backend\models\Label; 
use backend\models\LabelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\db\QueryBuilder;
use yii\db\Query;
use yii\db\Command;
use yii\db\Connection;
use Yii;
use yii\filters\AccessControl;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends Controller
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
                ],
                // 'access' => [
                //     'class' => AccessControl::className(),
                //     'rules' => [
                //       [
                //           'allow' => true,
                //           'actions' => ['create', 'index'], // applies to all actions
                //           'roles' => ['admin'], // your defined roles or permissions to use
                //       ],
                //     ]
                // ]
            ]

        );
    }



    /**
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProjectSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $entityColumnModel = new EntityColumnSearch(); 
        $entityColumnDataProvider = $entityColumnModel->search($this->request->queryParams, $id);
        $entityBranchColumnModel = new EntityBranchColumnSearch();
        $entityBranchColumnDataProvider = $entityBranchColumnModel->search($this->request->queryParams, $id);
        $entityColumnLabelModel = new LabelSearch(); 
        $entityColumnLabelDataProvider = $entityColumnLabelModel->search($this->request->queryParams, $id);
        // dd($entityColumnDataProvider);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'entityColumnDataProvider' => $entityColumnDataProvider,
            'entityColumnModel' => $entityColumnModel, 
            'entityBranchColumnModel' => $entityBranchColumnModel, 
            'entityBranchColumnDataProvider' => $entityBranchColumnDataProvider,
            'entityColumnLabelModel' => $entityColumnLabelModel,
            'entityColumnLabelDataProvider' => $entityColumnLabelDataProvider, 
        ]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('/project/create')) 
        {
            $model = new Project();

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) ) {
                    if($model->validate()){
                        $model->save();
                    }
                    else {
                        $errors = $model->errors;
                        Yii::$app->session->setFlash('error', 'Please fix errors before submitting again');
                    }
                    try{
                        $labelModel = $this->createToolLabel($model);
                        // dd($labelModel);

                        $this->createEntityTable($model, $labelModel);
                        $this->createEntityBranchTable($model, $labelModel);

                        Yii::$app->session->setFlash('success', 'Project Created Successfully');
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                    catch(\Exception $e) {
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }

                }
                else {
                    Yii::$app->session->setFlash('error', "Save failed");
                }
            } else {
                $model->loadDefaultValues();
            }
    
            return $this->render('create', [
                'model' => $model,
            ]);

        }
        else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
        }
     
    }
    public function createEntityBranchTable($model, $labelModel) {
    
            Yii::$app->db->createCommand("CREATE TABLE {$model->entity_branch} (
                id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                entity_id BIGINT NOT NULL,
                created_at DATETIME,
                updated_at DATETIME, 
                deleted_at DATETIME,
                FOREIGN KEY (entity_id)
                REFERENCES {$model->entity}(id)
                ON DELETE CASCADE
                )")->execute();
                Yii::$app->db->createCommand("INSERT INTO entity_branch_column (`column_name`, main_label_id, is_required, source_table, `order`, column_type, project_id, hide_columns) VALUES 
                ('created_at', {$labelModel->id}, 0, 'tool', 0,'DATETIME', {$model->id}, 1),
                ('updated_at', {$labelModel->id}, 0, 'tool', 0, 'DATETIME' ,  {$model->id}, 1),
                ('deleted_at', {$labelModel->id}, 0, 'tool', 0, 'DATETIME', {$model->id}, 1 ),
                ('id', {$labelModel->id}, 0, 'tool', 0,'BIGINT',  {$model->id}, 0),
                ('entity_id', {$labelModel->id}, 0, 'tool', 0, 'BIGINT', {$model->id}, 0)")->execute();
    }

    public function createEntityTable($model, $labelModel) 
    {   
             Yii::$app->db->createCommand("CREATE TABLE {$model->entity} (
                id BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                project_id BIGINT NOT NULL,
                created_at DATETIME, 
                updated_at DATETIME, 
                deleted_at DATETIME, 
                FOREIGN KEY (project_id)
                REFERENCES project(id)
                ON DELETE CASCADE
                )")->execute();
                Yii::$app->db->createCommand("INSERT INTO entity_column (`column`, main_label_id, is_required, source_table, `order`, column_type, project_id, hide_columns) VALUES 
                ('created_at', {$labelModel->id}, 0, 'tool', 0,'DATETIME', {$model->id}, 1),
                ('updated_at', {$labelModel->id}, 0, 'tool', 0, 'DATETIME' ,  {$model->id}, 1),
                ('deleted_at', {$labelModel->id}, 0, 'tool', 0, 'DATETIME', {$model->id}, 1 ),
                ('id', {$labelModel->id}, 0, 'tool', 0,'BIGINT',  {$model->id}, 0)")->execute();
    }

    protected function createToolLabel($model) 
    {  $labelModel = new Label(); 
       $labelModel->label = 'tool'; 
       $labelModel->project_id = $model->id; 
       if($labelModel->validate()){
           $labelModel->save();
       }
       else {
           $errors = $labelModel->errors; 
           echo $errors; 
       }
       return $labelModel; 
    //    return Yii::$app->db->createCommand("INSERT INTO `label` (`label`, project_id) VALUES ('tool', '{$model->id}')");
    }
    
    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $entityTableName = $model->entity; 
        $entityBranchTableName = $model->entity_branch;
        // dd($entityTableName, $entityBranchTableName);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->validate()) {
                $model->save();
            }
            else {
                $errors = $model->errors; 
                echo $errors; 
            }
            try {
                $this->updateEntityTableName($model, $entityTableName);
                $this->updateEntityBranchTableName($model, $entityBranchTableName);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
        else{
            return $this->render('update', [
                'model' => $model,
            ]);  
        }

    }
    
    /**
     * Deletes an existing Project model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->can('/project/delete')) {
            try{
                // dd($this->findModel($id)->entity_branch);
                $this->deleteEntityBranchTable($this->findModel($id));
                $this->deleteEntityTable($this->findModel($id));
                $this->deleteToolLabel($this->findModel($id));
                $this->findModel($id)->delete();
                Yii::$app->session->setFlash('success', 'Project deleted successfully');
                return $this->redirect(['index']);
               } 
               catch(\yii\db\Exception $e) {
                   echo $e->getMessage();
               }
        }
        else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page.'));
        }
    }

    protected function deleteToolLabel($model) 
    {
        return Yii::$app->db->createCommand("DELETE FROM `label` WHERE `label` LIKE 'tool' AND project_id={$model->id}")->execute(); 
    }

    protected function deleteEntityTable($model) {
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute(); 
       return Yii::$app->db->createCommand()->dropTable($model->entity)->execute();
    }
    protected function deleteEntityBranchTable($model) {
        Yii::$app->db->createCommand("SET FOREIGN_KEY_CHECKS=0")->execute(); 
        return Yii::$app->db->createCommand()->dropTable($model->entity_branch)->execute(); 
    }

    protected function updateEntityTableName($model, $entityTableName) {
        return Yii::$app->db->createCommand("RENAME TABLE {$entityTableName} TO {$model->entity}")->execute();
    }

    protected function updateEntityBranchTableName($model, $entityBranchTableName) {
        return Yii::$app->db->createCommand("RENAME TABLE {$entityBranchTableName} TO {$model->entity_branch}")->execute();
    }

    /**
     * Finds the Project model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Project the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Project::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
