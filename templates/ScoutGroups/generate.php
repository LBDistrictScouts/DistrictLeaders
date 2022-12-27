<?php
/**
 * @var AppView $this
 * @var ScoutGroup[]|CollectionInterface $scoutGroups
 * @var User $authUser
 * @var SectionType[]|CollectionInterface $sectionTypes
 */

use App\Model\Entity\ScoutGroup;
use App\Model\Entity\SectionType;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Collection\CollectionInterface;
use Cake\ORM\ResultSet;

$authUser = $this->getRequest()->getAttribute('identity');

?>
<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 2018-12-31
 * Time: 17:36
 *
 * @var AppView $this
 * @var ResultSet $filterArray
 * @var array $appliedFilters
 */

$entity = 'Scout Group';
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h3>Generate Missing Sections</h3>
                    </div>
                    <?php if ($this->fetch('add')) : ?>
                        <div class="col-12 col-md-6 text-md-right">
                            <?= $this->Html->link('Add New ' . $this->Inflection->singleSpace($entity), ['controller' => $this->fetch('entity'), 'action' => 'add'], ['class' => 'btn btn-outline-primary'])  ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">
                                <?= $this->Paginator->sort('scout_group') ?>
                            </th>
                            <?php foreach ($sectionTypes as $sectionType) : ?>
                                <?php if ($sectionType->is_young_person_section) : ?>
                                    <th scope="col"><?= h($sectionType->section_type) ?></th>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tr>
                        </thead>
                        <tbody>
                            <?= $this->Form->create() ?>
                            <?php foreach ($scoutGroups as $scoutGroup) : ?>
                            <tr>
                                <td><?= h($scoutGroup->group_alias) ?></td>
                                <?php foreach ($sectionTypes as $sectionType) : ?>
                                    <?php if ($sectionType->is_young_person_section) : ?>
                                        <?php
                                        /** @var array $sectionPoint */
                                        $sectionPoint = $scoutGroup->matrix[$sectionType->id];
                                        ?>
                                        <td>
                                            <?php if ($sectionPoint['exists']) : ?>
                                                <?= $this->Icon->iconHtml('check') ?>
                                                <?= $sectionPoint['count'] > 1 ? '(' . $this->Number->format($sectionPoint['count']) . ')' : '' ?>
                                            <?php else : ?>
                                                <?php
                                                $field = $scoutGroup->id . '.' . $sectionType->id . '.' . 'generate';
                                                echo $this->Form->control($field, ['type' => 'checkbox', 'default' => false, 'label' => 'Generate New']);
                                                ?>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-muted">
                <?= $this->Form->button('Create ' . $this->Inflection->singleSpace($this->fetch('entity')), ['class' => 'btn btn-outline-success btn-lg']) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
