<?php
/**
 * @var AppView $this
 * @var int $loggedInUserId
 */

use App\View\AppView;

?>
<?php if ($this->Identity->buildAndCheckCapability('VIEW', 'CompassRecords')) : ?>
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'search'], 'class' => 'form-inline ml-auto', 'valueSources' => 'query']) ?>
        <div class="form-group text-white-50">
            <?= $this->Form->label('q', '<i class="fal fa-search"></i>', ['escape' => false]) ?>
            <?= $this->Form->control('q', ['class' => 'form-control flex-fill search-field', 'type' => 'search', 'label' => false, 'placeholder' => 'Search Compass Records...']) ?>
        </div>
    <?= $this->Form->end() ?>
<?php endif; ?>

