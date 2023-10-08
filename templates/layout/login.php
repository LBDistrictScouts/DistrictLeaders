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
 * @var AppView $this
 * @var mixed $PolicyResult
 */

use App\View\AppView;

$cakeDescription = 'Home - Letchworth, Baldock &amp; Ashwell';

$backgrounds = [
    'explorer-belt-expedition.jpg',
    'scout-jumping-into-lake.jpg',
    'two-cubs-leaping-into-water.jpg',
];
try {
    $background = $backgrounds[random_int(0, 2)];
} catch (Exception $e) {
    $background = $backgrounds[0];
}

?>
<!DOCTYPE html>
<html>
    <head>
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <title>
            <?= $cakeDescription ?>:
            <?= $this->fetch('title') ?>
        </title>

        <?= $this->Html->meta('icon') ?>

        <?= $this->fetch('meta') ?>
        <?= $this->element('style'); ?>

    </head>
    <body>
        <?= $this->element('navbar'); ?>
        <div class="login-dark" style="font-family: 'Nunito Sans', sans-serif;background-image: url('/img/<?= $background ?>');">
            <div class="container" style="padding-bottom: 120px;">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
                <?php $identity = $this->getRequest()->getAttribute('identity'); ?>

                <?php if (!is_null($identity)) : ?>
                    <?= $this->cell('NotifyModal', [$identity->get('id')])->render() ?>
                    <?php if (isset($PolicyResult)) {
                        echo $this->cell('AuthModal', [$PolicyResult])->render();
                    } ?>
                <?php endif; ?>
            </div>
        </div>
        <?= $this->element('dark-footer'); ?>
        <?= $this->element('script'); ?>
    </body>
</html>
