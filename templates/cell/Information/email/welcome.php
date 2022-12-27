<?php
/**
 * @var AppView $this
 * @var string $system
 * @var string $creator
 */

use App\View\AppView;

$preview = 'Welcome to the ' . $system;
$this->assign('preview', $preview);
?>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?= $this->fetch('preview') ?></p>
<?php if (isset($creator) && !empty($creator)) : ?>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">You have been added to the system by <?= $creator ?>.</p>
<?php endif; ?>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;"><?= $this->element('system-description') ?></p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; Margin-bottom: 15px;">Please proceed by setting your username and password below.</p>



