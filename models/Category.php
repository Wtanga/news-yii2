<?php

namespace app\models;


use yii\db\ActiveRecord;

class Category extends ActiveRecord
{
    /**
     * Returns category table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * Returns category models labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'parent_id' => 'Parent category',
            'name' => 'Category name',
        ];
    }

    /**
     * Returns category validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'string', 'length' => [3, 255]],
            ['parent_id', 'categoryValidator'],
        ];
    }

    /**
     * Validates category's parent id
     */
    public function categoryValidator()
    {
        if ($this->parent_id !== NULL) {
            if ($this->parent_id === '0') {
                $this->parent_id = NULL;
            } elseif (!$model = Category::findOne($this->parent_id)) {
                $this->addError('category_id', 'Wrong parent id');
            }
        }
    }
}
