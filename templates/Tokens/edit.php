<?php
/**
 * @var AppView $this
 * @var Token $token
 */

use App\Model\Entity\Token;
use App\View\AppView;

?>
<div class="tokens form large-9 medium-8 columns content">
    <?= $this->Form->create($token) ?>
    <fieldset>
        <legend><?= __('Edit Token') ?></legend>
        <?php
            echo $this->Form->control('token');
            echo $this->Form->control('expires');
            echo $this->Form->control('utilised');
            echo $this->Form->control('active');
            echo $this->Form->control('deleted');
            echo $this->Form->control('hash');
            echo $this->Form->control('random_number');
            echo $this->Form->control('email_send_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
