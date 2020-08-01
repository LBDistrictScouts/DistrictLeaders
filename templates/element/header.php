<?php
/**
 * @var \App\View\AppView $this
 */

$identity = $this->getRequest()->getAttribute('identity');
?>
<header>
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-4">District Leader Information System</h1>
            <p class="lead">Application for District Digital Functions.</p>
        </div>
    </div>
    <?= $this->element('search') ?>
</header>

<?= $this->element('actions') ?>

