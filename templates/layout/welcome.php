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
    <body style="font-family: 'Nunito Sans', sans-serif;">
        <div data-bs-parallax-bg="true" style="height: 500px;background: url('/img/firelighting-with-steve-backshall-jpg.jpg') top / cover;"></div>
        <?= $this->element('navbar'); ?>
        <div class="container" style="padding-bottom: 120px; padding-top: 20px;">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
            <!-- Modal -->
            <?php $identity = $this->getRequest()->getAttribute('identity'); ?>

            <?php if (!is_null($identity)) : ?>
                <?= $this->cell('NotifyModal', [$identity->get('id')])->render() ?>
                <?php if (isset($PolicyResult)) {
                    echo $this->cell('AuthModal', [$PolicyResult])->render();
                } ?>
            <?php endif; ?>
        </div>
        <br/>
        <?= $this->element('footer'); ?>
        <?= $this->element('script'); ?>
    </body>
</html>
