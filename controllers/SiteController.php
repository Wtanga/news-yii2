<?php

namespace app\controllers;

use app\models\Category;
use app\models\News;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $categoryId = (int)Yii::$app->getRequest()->getQueryParam('category');

        $sort = new Sort([
            'attributes' => [
                'date' => [
                    'asc' => ['date' => SORT_ASC],
                    'desc' => ['date' => SORT_DESC],
                    'label' => 'Sort by Date',
                ],
            ],
        ]);

        $orderBy = empty($sort->orders) ? ['date' => SORT_DESC] : $sort->orders;

        $news = News::find()->asArray()->orderBy($orderBy);
        if ($categoryId) {
            $news = $news->where(['category_id' => $categoryId]);
        }

        $pagination = new Pagination([
            'defaultPageSize' => 3,
            'totalCount' => $news->count(),
        ]);

        $news = $news
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $parentCategory = $categoryId ? Category::find()->asArray()->where(['id' => $categoryId])->one() : null;

        return $this->render('index', [
            'parentCategory' => $parentCategory,
            'categories' => $this->getCategories($categoryId),
            'news' => $news,
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }

    /**
     * Returns categories array by category id
     *
     * @param $categoryId
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getCategories($categoryId)
    {
        $categoryId = $categoryId ? : NULL;
        $query = (new \yii\db\Query())
            ->select(['category.id', 'category.parent_id', 'category.name', 'count(news.id) as count'])
            ->from('category')
            ->join('INNER JOIN', 'news', 'news.category_id = category.id')
            ->where(['is', 'category.parent_id', new \yii\db\Expression('null')])
            ->groupBy(['category.id', 'category.parent_id', 'category.name'])
            ->having('count(news.id) > 0');

        $query = $categoryId ?
            $query->where('category.parent_id=:category_id', [':category_id' => $categoryId]) :
            $query->where(['is', 'category.parent_id', new \yii\db\Expression('null')]);

        return $query->all();
    }

    /**
     * Login action
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $loginModel = new LoginForm();
        if ($loginModel->load(Yii::$app->request->post()) && $loginModel->login()) {
            return $this->goBack();
        }

        $loginModel->password = '';
        return $this->render('login', [
            'model' => $loginModel,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
