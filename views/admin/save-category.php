<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Admin', 'url' => ['/admin']];
$this->params['breadcrumbs'][] = ['label' => 'Category List', 'url' => ['/admin/category']];
$this->params['breadcrumbs'][] = 'Category Form';

?>

<h1>Category Form</h1>

<?php $activeForm = ActiveForm::begin(['options' => ['id' => 'comment-form']]); ?>

<?= $activeForm->field($model, 'parent_id')->dropDownList($categoriesList); ?>

<?= $activeForm->field($model, 'name'); ?>

<?= Html::submitButton('Send', ['class' => 'btn btn-success']); ?>

<?php $activeForm = ActiveForm::end(); ?>
