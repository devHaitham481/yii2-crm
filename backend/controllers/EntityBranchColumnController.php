<?php

namespace backend\controllers;

use backend\models\EntityBranchColumn;
use backend\models\DropDownItem;
use backend\models\EntityBranchColumnSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * EntityBranchColumnController implements the CRUD actions for EntityBranchColumn model.
 */
class EntityBranchColumnController extends Controller
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
     * Lists all EntityBranchColumn models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntityBranchColumnSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EntityBranchColumn model.
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
     * Creates a new EntityBranchColumn model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($project_id)
    {

        if(Yii::$app->user->can('/entity-branch-column/create')){
        
        $model = new EntityBranchColumn();
        // $this->request->post()['EntityBranchColumn']['project_id'] = $_GET['project_id'];
        // dd($this->request->post()['EntityBranchColumn']['project_id']);
        $dropDownItemModel = new DropDownItem();
        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->project_id = $project_id;
                if($model->validate()){
                    $model->save();
                }
                else {
                    $errors = $model->errors;
                    echo $errors; 
                }
                try{
                    $dropDownListKey = $this->request->post()['DropDownListKey']??null; 
                    $dropDownListName = $this->request->post()['DropDownListName']??null;
                    $i = 0;
                    if($dropDownListKey != null && $dropDownListName != null) {
                        foreach($dropDownListKey as $key) {
                            $dropDownItemModel = new DropDownItem(); 
                            $dropDownItemModel->key = $key['key']; 
                            $dropDownItemModel->name = $dropDownListName[$i]['name']; 
                            $dropDownItemModel->source_type = 'entity_branch_column'; 
                            $dropDownItemModel->source_id = $model->id; 
                            $dropDownItemModel->save(); 
                            $i++; 
                        }
                    }
                    $this->createEntityBranchColumnInEntityBranchTable($model);
                    return $this->redirect(['view', 'id' => $model->id]);
                } catch(yii\db\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }

        } else {
            $model->loadDefaultValues();
        }
    
        return $this->render('create', [
            'model' => $model,
        ]);
    } else {
        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to access this page'));
    }
    }
   
    private function createEntityBranchColumnInEntityBranchTable($model) 
    {   
        // if($model->column_type = 'dropdown'){
        //     $model->column_type = 'tinyint';
        // return Yii::$app->db->createCommand()->addColumn($model->project->entity_branch, $model->column_name, $model->column_type)->execute();
        // }
    
        return Yii::$app->db->createCommand()->addColumn($model->project->entity_branch, $model->column_name, $model->column_type)->execute();
        

    }
    /**
     * Updates an existing EntityBranchColumn model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'successfully updated Entity Column');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EntityBranchColumn model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {   
        $project_id = $_GET['project_id']??null;
        // Yii::$app->db->createCommand()->dropColumn($this->findModel($id));
        $this->deleteEntityBranchColumnFromEntityBranchTable($this->findModel($id));
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'successfully deleted entity branch column'); 
        if($project_id){
            return $this->redirect(['/project/view', 'id' => $project_id]);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function deleteEntityBranchColumnFromEntityBranchTable($model) 
    {   
        return Yii::$app->db->createCommand()->dropColumn($model->project->entity_branch, $model->column_name, $model->column_type)->execute();
    }

    /**
     * Finds the EntityBranchColumn model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return EntityBranchColumn the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EntityBranchColumn::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
