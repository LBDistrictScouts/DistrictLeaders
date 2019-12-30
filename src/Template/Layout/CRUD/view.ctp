<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 *
 * @var \App\View\AppView $this
 */
$this->prepend('action_menu', $this->element('action_menu/begin'));
?>
<div class="row">
    <div class="col-12 col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-8 col-lg-8 col-xl-8 col-6">
                        <h3><?= $this->Icon->iconHtmlEntity($this->fetch('entity'), ['fa-fw']) ?> <?= h($this->fetch('object_title', $this->fetch('entity'))) ?></h3>
                    </div>
                    <div class="col-md-4 col-lg-4 col-xl-4 col-6">
                        <?php $this->append('action_menu', $this->element('action_menu/end')); ?>
                        <?= $this->fetch('action_menu') ?>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <?php if ($this->exists('related') && $this->exists('related_header')) : ?>
            <br />
            <div class="card">
                <div class="card-header">
                    <?= $this->fetch('related_header') ?>
                </div>
                <div class="card-body">
                    <?= $this->fetch('related') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
