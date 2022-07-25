<?php

namespace app\controllers;

use app\models\Category;
use app\models\Comment;
use app\models\News;
use Yii;
use yii\base\Controller;

/**
 * Controller for creating testing data
 *
 * Class CreateController
 * @package app\controllers
 */
class CreateController extends Controller
{
    /**
     * Data for the category table
     *
     * @var array
     */
    public $categories = [
        [1, null, 'Category A'],
        [2, null, 'Category B'],
        [3, null, 'Category C'],

        [4, 1, 'Category AD'],
        [5, 2, 'Category BE'],
        [6, 3, 'Category CF'],

        [7, 4, 'Category ADG'],
        [8, 5, 'Category BEH'],
        [9, 6, 'Category CFI'],
    ];

    /**
     * Data for the news table
     *
     * @var array
     */
    public $news = [
        1,
        1,
        1,
        1,

        2,
        2,
        2,
        2,

        3,
        3,
        3,
        3,

        4,
        4,
        4,
        4,

        5,
        5,
        5,
        5,

        6,
        6,
        6,
        6,

        7,
        7,
        7,
        7,

        8,
        8,
        8,
        8,

        9,
        9,
        9,
        9,
    ];

    /**
     * News title template string
     *
     * @var string
     */
    public $newsTitleTemplate = 'Title';

    /**
     * News short text template string
     *
     * @var string
     */
    public $newsShortTextTemplate = 'Pack my box with five dozen liquor jugs.';

    /**
     * News text template string
     *
     * @var string
     */
    public $newsTextTemplate = 'Pack my box with five dozen liquor jugs. Cozy sphinx waves quart jug of bad milk. Crazy Fredrick bought many very exquisite opal jewels.';

    /**
     * News slug template string
     *
     * @var string
     */
    public $newsSlugTemplate = 'slug';

    /**
     * Comments author template string
     *
     * @var string
     */
    public $commentNameTemplate = 'User';

    /**
     * Comments text template string
     *
     * @var string
     */
    public $commentTextTemplate = 'text #';

    /**
     * Trancates selected table
     *
     * @param $tableName
     *
     * @return \yii\db\DataReader
     *
     * @throws \yii\db\Exception
     */
    public function trancateTable($tableName)
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand("DELETE FROM {$tableName};");
        return $command->query();
    }

    /**
     * Fills category table
     *
     * @return string
     *
     * @throws \yii\db\Exception
     */
    public function actionCategories()
    {

        $this->trancateTable(Category::tableName());

        foreach ($this->categories as $category) {

            $categoryModel = new Category();

            $categoryModel->id = $category[0];
            $categoryModel->parent_id = $category[1];
            $categoryModel->name = $category[2];

            $categoryModel->save();
        }

        return sprintf("%s categories created", count($this->categories));
    }

    /**
     * Fills news table
     *
     * @return string
     *
     * @throws \yii\db\Exception
     */
    public function actionNews()
    {

        $this->trancateTable(News::tableName());

        $increment = 1;

        $date = new \DateTime('-1 year');
        $dateInterval = \DateInterval::createFromDateString('1 day');

        foreach ($this->news as $news) {

            $newsModel = new News();


            $newsModel->category_id = $news;
            $newsModel->title = sprintf("%s %s", $this->newsTitleTemplate, $increment);
            $newsModel->short_text = sprintf("%s", $this->newsShortTextTemplate);;
            $newsModel->text = sprintf("%s", $this->newsTextTemplate);
            $newsModel->is_active = true;
            $newsModel->slug = sprintf("%s_%s", $this->newsSlugTemplate, $increment);

            $newsModel->date = $date->format('Y-m-d H:i:s');
            $date->add($dateInterval);

            $newsModel->save();

            $increment++;
        }

        return sprintf("%s news created", count($this->news));
    }

    /**
     * Fills comment table
     *
     * @return string
     *
     * @throws \yii\db\Exception
     */
    public function actionComments()
    {
        $this->trancateTable(Comment::tableName());

        $firstNew = News::find()->orderBy(['id' => SORT_ASC])->one();
        $firstNewId = (int)$firstNew->id;
        $count = count($this->news);

        for ($i = 0; $i < $count; $i++) {

            $model = new Comment();


            $model->news_id = $firstNewId;
            $model->name = sprintf("%s%s", $this->commentNameTemplate, $firstNewId);;
            $model->text = sprintf("%s%s", $this->commentTextTemplate, $firstNewId);

            $model->save();
            $firstNewId++;
        }

        return sprintf("%s comments created", $count);
    }

    /**
     * Aggregating method, fills all tables
     *
     * @return string
     *
     * @throws \yii\db\Exception
     */
    public function actionAll()
    {

        $result = '';

        $result .= $this->actionCategories() . "<br />";
        $result .= $this->actionNews() . "<br />";
        $result .= $this->actionComments() . "<br />";

        return $this->render('all', [
            'result' => $result,
        ]);
    }
}
