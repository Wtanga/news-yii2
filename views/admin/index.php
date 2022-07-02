<?php

use yii\helpers\Url;

$this->params['breadcrumbs'][] = 'Admin';
?>

<ul class="nav nav-pills nav-stacked">
    <li role="presentation">
        <a href="<?= Url::to(['/admin/category']) ?>">Category List</a>
    </li>
    <li role="presentation">
        <a href="<?= Url::to(['/admin/news']) ?>">News List</a>
    </li>
</ul>
