<?php

namespace app\controllers;

use app\models\Category;
use app\models\News;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

/**
 * Admin panel private controller
 *
 * Class AdminController
 * @package app\controllers
 */
class AdminController extends Controller
{

    /**
     * Behaviors rules
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Admin panel main page action
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', []);
    }

    /**
     * Admin panel category list page action
     *
     * @return string
     */
    public function actionCategory()
    {
        $categories = Category::find()->orderBy(['id' => SORT_ASC])->all();

        return $this->render('category', [
            'categories' => $categories,
        ]);
    }

    /**
     * Admin panel news list page action
     *
     * @return string
     */
    public function actionNews()
    {
        $news = News::find()->orderBy(['id' => SORT_ASC])->all();

        return $this->render('news', [
            'news' => $news,
        ]);
    }

    /**
     * Admin panel remove news page action
     *
     * @return \yii\web\Response
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveNews()
    {
        $newsId = (int)Yii::$app->getRequest()->getQueryParam('id');

        if (!$news = News::findOne($newsId)) {
            Yii::$app->session->setFlash('error', 'News is not found!');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (!$news->delete()) {
            Yii::$app->session->setFlash('error', 'Deleting error');
            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->session->setFlash('success', 'News has been removed');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Admin panel remove category page action
     *
     * @return \yii\web\Response
     *
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionRemoveCategory()
    {
        $categoryId = (int)Yii::$app->getRequest()->getQueryParam('id');

        if (!$category = Category::findOne($categoryId)) {
            Yii::$app->session->setFlash('error', 'Category is not found!');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (News::findOne(['category_id' => $category->id])) {
            Yii::$app->session->setFlash('error', 'Category is not empty, therefore can\'t be removed');
            return $this->redirect(Yii::$app->request->referrer);
        }

        if (!$category->delete()) {
            Yii::$app->session->setFlash('error', 'Deleting error');
            return $this->redirect(Yii::$app->request->referrer);
        }

        Yii::$app->session->setFlash('success', 'Category has been removed');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Admin panel add news page action
     *
     * @return string|\yii\web\Response
     */
    public function actionAddNews()
    {
        $newsModel = new News();
        if ($newsModel->load(Yii::$app->request->post())) {
            if ($newsModel->save()) {
                Yii::$app->session->setFlash('success', 'News is created');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Creating Error');
            }
        }

        $categoriesList = [];
        if ($categories = Category::find()->all()) {
            foreach ($categories as $category) {
                $categoriesList[$category->id] = $category->name;
            }
        }

        return $this->render('save-news', [
            'model' => $newsModel,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Admin panel edit news page action
     *
     * @return string|\yii\web\Response
     */
    public function actionEditNews()
    {
        $newsId = Yii::$app->getRequest()->getQueryParam('id');
        $newsModel = News::findOne($newsId);

        if ($newsModel->load(Yii::$app->request->post())) {
            if ($newsModel->save()) {
                Yii::$app->session->setFlash('success', 'News is saved');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Creating Error');
            }
        }

        $categoriesList = [];
        if ($categories = Category::find()->all()) {
            foreach ($categories as $category) {
                $categoriesList[$category->id] = $category->name;
            }
        }

        return $this->render('save-news', [
            'model' => $newsModel,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Admin panel add category page action
     *
     * @return string|\yii\web\Response
     */
    public function actionAddCategory()
    {
        $categoryModel = new Category();

        if ($categoryModel->load(Yii::$app->request->post())) {
            if ($categoryModel->save()) {
                Yii::$app->session->setFlash('success', 'Category is created');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Creating Error');
            }
        }

        $categoriesList = ['0' => 'NULL'];
        if ($categories = Category::find()->all()) {
            foreach ($categories as $category) {
                $categoriesList[$category->id] = $category->name;
            }
        }

        return $this->render('save-category', [
            'model' => $categoryModel,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Admin panel edit category page action
     *
     * @return string|\yii\web\Response
     */
    public function actionEditCategory()
    {
        $categoryId = Yii::$app->getRequest()->getQueryParam('id');
        $categoryModel = Category::findOne($categoryId);

        if ($categoryModel->load(Yii::$app->request->post())) {
            if ($categoryModel->save()) {
                Yii::$app->session->setFlash('success', 'Category is saved');
                return $this->refresh();
            } else {
                Yii::$app->session->setFlash('error', 'Saving Error');
            }
        }

        $categoriesList = ['0' => 'NULL'];
        if ($categories = Category::find()->all()) {
            foreach ($categories as $category) {
                $categoriesList[$category->id] = $category->name;
            }
        }

        return $this->render('save-category', [
            'model' => $categoryModel,
            'categoriesList' => $categoriesList,
        ]);
    }
}
