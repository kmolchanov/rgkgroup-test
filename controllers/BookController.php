<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\bootstrap\Html;
use yii\helpers\Url;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'view', 'delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        Yii::$app->session->setFlash('redirectUrl', Yii::$app->request->url);

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!empty($id)) {
            $model = $this->findModel($id);
            return $this->render('index', [
                'bookModel' => $model,
                'imageResponse' => Html::img(Url::toRoute($model->imageUrl), ['style' => 'width:550px;']),
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $image = UploadedFile::getInstance($model, 'imageFile');
            if(!empty($image)) {
                $model->image = Yii::$app->security->generateRandomString() . '.' .$image->extension;
                $path = Yii::$app->basePath . '/' . Book::IMAGES_DIRECTORY . $model->image;
                $model->save();
                $image->saveAs($path);
            } else {
                $model->save();
            }

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $image = UploadedFile::getInstance($model, 'imageFile');
            if(!empty($image)) {
                if(!empty($model->image)) {
                    @unlink(Yii::$app->basePath . '/' . Book::IMAGES_DIRECTORY . $model->image);
                }
                $model->image = Yii::$app->security->generateRandomString() . '.' .$image->extension;
                $path = Yii::$app->basePath . '/' . Book::IMAGES_DIRECTORY . $model->image;
                $model->save();
                $image->saveAs($path);
            } else {
                $model->save();
            }
            return $this->redirect(Yii::$app->session->hasFlash('redirectUrl') ? Yii::$app->session->getFlash('redirectUrl') : ['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        @unlink(Yii::$app->basePath . '/' . Book::IMAGES_DIRECTORY . $model->image);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
