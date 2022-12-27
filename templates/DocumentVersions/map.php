<?php
/**
 * @var AppView $this
 * @var DocumentVersion $documentVersion
 * @var array $fieldMap
 * @var string[] $fieldList
 */

use App\Model\Entity\DocumentVersion;
use App\View\AppView;

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <?php if (!empty($fieldMap)) : ?>
            <?= $this->Form->create() ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <h2>Field Mapping</h2>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <th scope="col"><?= __('Column') ?></th>
                                <th scope="col"><?= __('Original Name') ?></th>
                                <th scope="col"><?= __('Parsed Name') ?></th>
                                <th scope="col"><?= __('First Row Data') ?></th>
                                <th scope="col"><?= __('Mapped Model Field') ?></th>
                            </tr>
                            <?php foreach ($fieldMap['fields'] as $key => $field) : ?>
                                <tr>
                                    <td><?= $this->Number->format($key) ?></td>
                                    <td><?= h($fieldMap['original'][$key]) ?></td>
                                    <td><?= h($field) ?></td>
                                    <td><?= h($fieldMap['data'][0][$field]) ?></td>
                                    <td><?= $this->Form->select('field' . $key, $fieldList, [
                                            'empty' => true,
                                            'val' => $field,
                                        ]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <?= $this->Form->submit('Submit Mapping', ['class' => 'btn btn-outline-success btn-lg btn-block']) ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        <?php endif; ?>
    </div>
</div>
