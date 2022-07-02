<?php

use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'Main page';

?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-2">
                <?php if (is_iterable($categories) || $parentCategory): ?>
                    <ul class="nav nav-pills nav-stacked">
                        <?php if ($parentCategory): ?>
                            <li role="presentation">
                                <a href="<?= Url::to(['/', 'category' => $parentCategory['parent_id']]) ?>">Get Back</a>
                            </li>
                        <?php endif; ?>

                        <?php foreach ($categories as $category): ?>
                            <li role="presentation">
                                <a href="<?= Url::to(['/', 'category' => $category['id']]) ?>"><?= $category['name'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            <div class="col-lg-10">
                <?= $sort->link('date') ?>
                <?php if (count($news)): ?>
                    <?php foreach ($news as $new): ?>
                        <div class="">
                            <a href="<?= Url::to(['news/news', 'slug' => $new['slug']]) ?>">
                                <h2><?= $new['title'] ?></h2></a>
                            <p><?= $new['short_text'] ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?= LinkPager::widget(['pagination' => $pagination]); ?>
            </div>
        </div>

    </div>
</div>
