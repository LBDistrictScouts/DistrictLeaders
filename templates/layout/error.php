<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Core\Configure;

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->getTemplate() == 'error500' && Configure::read('debug') ? '' : $this->element('style') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div class="container" style="padding-bottom: 120px; padding-top: 20px;">
        <div class="card">
            <div class="card-header">
                <h1><?= __('Error') ?></h1>
            </div>
            <div class="card-body">
                <?= $this->Flash->render() ?>

                <?= $this->fetch('content') ?>
            </div>
            <div class="card-footer">
                <?= $this->Html->link(__('Back'), 'javascript:history.back()', ['class' => 'btn btn-block btn-primary']) ?>
            </div>
        </div>
    </div>
</body>
</html>
