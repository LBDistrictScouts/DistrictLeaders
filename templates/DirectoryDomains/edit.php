<?php
/**
 * @var AppView $this
 * @var DirectoryDomain $directoryDomain
 * @var mixed $directories
 */

use App\Model\Entity\DirectoryDomain;
use App\View\AppView;

$this->extend('../layout/CRUD/edit');

$this->assign('entity', 'DirectoryDomains');
?>
<?= $this->Form->create($directoryDomain) ?>
<fieldset>
    <?php
        $args = [
            'CHANGE',
            $directoryDomain->getSource(),
            null,
            null,
        ];

        $args[4] = $directoryDomain::FIELD_ID;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryDomain::FIELD_ID) : '';

        $args[4] = $directoryDomain::FIELD_DIRECTORY_DOMAIN;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryDomain::FIELD_DIRECTORY_DOMAIN) : '';

        $args[4] = $directoryDomain::FIELD_DIRECTORY_ID;
        /** @var array $directories The Directory Id List */
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryDomain::FIELD_DIRECTORY_ID, ['options' => $directories]) : '';

        $args[4] = $directoryDomain::FIELD_INGEST;
        echo $this->Identity->buildAndCheckCapability(...$args) ? $this->Form->control($directoryDomain::FIELD_INGEST) : '';

        ?>
</fieldset>
