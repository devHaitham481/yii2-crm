<?php

namespace backend\controllers;

use backend\models\EntityBranch;
use backend\models\EntityBranchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;


/**
 * EntityBranchController implements the CRUD actions for EntityBranch model.
 */
class EntityBranchController extends Controller
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
            ]
        );
    }

    /**
     * Lists all EntityBranch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntityBranchSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new EntityBranch();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }


    public function actionCreateData() 
    {       
            $model = new EntityBranch();
            $tableName = $_GET['entityBranchTable'];
            // \backend\assets\AppAsset::dd($tableName);
            if ($this->request->isPost) {
                if ($model->load($this->request->post())) {
                try{
                    $request = Yii::$app->request->post();
                    $keys = array_keys($request);
                    $formData = $request['EntityBranch'];
                    $columns = array_keys($formData);
                    $fields = array_values($formData);
                    $model->insertEntityBranchData($tableName, $formData);
                }
                catch(\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }

                    // return $this->redirect(['index', 'id' => $model->id]);
                    // var_dump($request["EntityBranch"]["new_entity_branch_column"]); die();
                
            } else {
                $model->loadDefaultValues();
            }
    
            return $this->render('create', [
                'model' => $model,
            ]);
    }

    }

    public function actionCreateEntityBranchRow($project_id, $entity_id){
        $model = new EntityBranch();
        $entityBranchSearch = new EntityBranchSearch(); 
        $entityBranchTable = $_GET['entityBranchTable'];
        $project_id = $_GET['project_id']; 
        // \backend\assets\AppAsset::dd($entityBranchTable);
        if($this->request->isPost) {
            if($model->load($this->request->post())) {
                $request = Yii::$app->request->post();
                $keys = array_keys($request);
                $formData = $request['EntityBranch'];
                $columns = array_keys($formData); 
                $fields = array_values($formData); 
                $model->insertEntityBranchData($entityBranchTable, $formData); 
            }
        
        else {
            $model->loadDefaultValues(); 
        }
        return $this->redirect(['entity/entity-sheet-data', 'project_id' => $project_id]);
    }
    }
    public function actionUpdateEntityBranchRow($project_id, $entity_id) {

        $model = new EntityBranch(); 
        $entityBranchSearch = new EntityBranchSearch(); 
        $entityBranchTable = $_GET['tableName'];
        $project_id = $_GET['project_id']; 
        if($this->request->isPost) {
            if($model->load($this->request->post())) {
                $request = Yii::$app->request->post(); 
                $formData = $request['EntityBranch']; 
                // dd($formData);

                $model->updateEntityBranchData($entityBranchTable, $formData); 
            }
        }
        else {
            $model->loadDefaultValues(); 
        }
        return $this->redirect(['entity/entity-sheet-data', 'project_id' => $project_id]);
    }

    /**
     * Displays a single EntityBranch model.
     * @param int $id ID
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
     * Creates a new EntityBranch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EntityBranch();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EntityBranch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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
     * Deletes an existing EntityBranch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the EntityBranch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return EntityBranch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntityBranch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
