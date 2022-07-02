<?php

namespace app\models;

use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    /**
     * Returns comment table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * Returns comment models labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Name',
            'text' => 'Comment',
        ];
    }

    /**
     * Returns comment validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Field "Name" is required'],
            ['text', 'required', 'message' => 'Field "Text" is required'],
            [['name', 'text'], 'trim'],
            ['name', 'string', 'min' => 3, 'tooShort' => 'Name must not be shorter then 3 characters'],
            ['name', 'string', 'max' => 10, 'tooLong' => 'Name must not be longer then 10 characters'],
            ['text', 'string', 'max' => 1000, 'tooLong' => 'Text must not be longer then 1000 characters'],
            ['news_id', 'integer'],
        ];
    }
}
