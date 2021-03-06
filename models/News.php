<?php

namespace app\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    /**
     * Returns news table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * Returns news models labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'category' => 'Category id',
            'title' => 'Title',
            'short_text' => 'Short text',
            'text' => 'Text',
            'is_active' => 'Is active',
        ];
    }

    /**
     * Returns news validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'short_text', 'text'], 'required'],
            ['category_id', 'integer'],
            [['title', 'short_text', 'text'], 'trim'],
            ['is_active', 'boolean'],
            ['title', 'string', 'length' => [3, 255]],
            ['short_text', 'string', 'length' => [1, 511]],
            ['text', 'string', 'length' => [1, 1000]],
            ['category_id', 'categoryValidator'],
            ['title', 'titleModifier'],
            ['slug', 'trim'],
            ['date', 'date', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * Generates slug field transliterates is from title field
     */
    public function titleModifier()
    {
        $this->slug = $this->translit($this->title);
    }

    /**
     * Validates category_id field
     */
    public function categoryValidator()
    {
        if (!$model = Category::findOne($this->category_id)) {
            $this->addError('category_id', 'Wrong category number');
        }
    }

    public static function findBySlug($slug)
    {
        return static::findOne(['slug' => strtolower($slug)]);
    }

    /**
     * Transliterates cyrillic string to latin
     *
     * @param $s
     * @return mixed|null|string|string[]
     */

    public function translit($s)
    {
        $s = (string)$s;
        $s = strip_tags($s);
        $s = str_replace(array("\n", "\r"), " ", $s);
        $s = preg_replace("/\s+/", ' ', $s);
        $s = trim($s);
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
        $s = strtr($s, array('??' => 'a', '??' => 'b', '??' => 'v', '??' => 'g', '??' => 'd', '??' => 'e', '??' => 'e', '??' => 'j', '??' => 'z', '??' => 'i', '??' => 'y', '??' => 'k', '??' => 'l', '??' => 'm', '??' => 'n', '??' => 'o', '??' => 'p', '??' => 'r', '??' => 's', '??' => 't', '??' => 'u', '??' => 'f', '??' => 'h', '??' => 'c', '??' => 'ch', '??' => 'sh', '??' => 'shch', '??' => 'y', '??' => 'e', '??' => 'yu', '??' => 'ya', '??' => '', '??' => ''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
        $s = str_replace(" ", "", $s);
        return $s;
    }
}
