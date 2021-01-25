<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */

/**
 * @param \App\Model\Entity\Audit $audit
 * @param bool $original
 * @param \Cake\View\Helper\HtmlHelper $html
 * @return string|null
 * @var \App\View\AppView $this
 * @var object $html
 * @var mixed $original
 * @var \App\Model\Entity\Role $role
 */
function auditValue(\App\Model\Entity\Audit $audit, bool $original, \Cake\View\Helper\HtmlHelper $html): ?string
{
    if ($original) {
        $value = $audit->original_value;

        switch ($audit->audit_field) {
            case 'role_type_id':
                if ($audit->has('original_role_type')) {
                    return $html->link($audit->original_role_type->role_type, ['controller' => 'RoleTypes', 'action' => 'view', $audit->original_role_type->id]);
                }

                return $value;
            case 'section_id':
                if ($audit->has('original_section')) {
                    return $html->link($audit->original_section->section, ['controller' => 'Sections', 'action' => 'view', $audit->original_section->id]);
                }

                return $value;
            case 'user_id':
                if ($audit->has('original_user')) {
                    return $html->link($audit->original_user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->original_user->id]);
                }

                return $value;
            case 'user_contact_id':
                if ($audit->has('original_user_contact')) {
                    return $html->link($audit->original_user_contact->contact_field, ['controller' => 'Users', 'action' => 'view', $audit->original_user_contact->user_id]);
                }

                return $value;
            case 'role_status_id':
                if ($audit->has('original_role_status')) {
                    return $html->link($audit->original_role_status->role_status, ['controller' => 'RoleStatuses', 'action' => 'view', $audit->original_role_status->id]);
                }

                return $value;
            default:
                return $value;
        }
    } else {
        $value = $audit->modified_value;

        switch ($audit->audit_field) {
            case 'role_type_id':
                if ($audit->has('new_role_type')) {
                    return $html->link($audit->new_role_type->role_type, ['controller' => 'RoleTypes', 'action' => 'view', $audit->new_role_type->id]);
                }

                return $value;
            case 'section_id':
                if ($audit->has('new_section')) {
                    return $html->link($audit->new_section->section, ['controller' => 'Sections', 'action' => 'view', $audit->new_section->id]);
                }

                return $value;
            case 'user_id':
                if ($audit->has('new_user')) {
                    return $html->link($audit->new_user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->new_user->id]);
                }

                return $value;
            case 'user_contact_id':
                if ($audit->has('new_user_contact')) {
                    return $html->link($audit->new_user_contact->contact_field, ['controller' => 'Users', 'action' => 'view', $audit->new_user_contact->user_id]);
                }

                return $value;
            case 'role_status_id':
                if ($audit->has('new_role_status')) {
                    return $html->link($audit->new_role_status->role_status, ['controller' => 'RoleStatuses', 'action' => 'view', $audit->new_role_status->id]);
                }

                return $value;
            default:
                return $value;
        }
    }
}

?>
<div class="row">
    <div class="col">
        <?= $this->element('image-header') ?>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;">Role</h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"></h6>
                    </div>
                    <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <?= $this->Identity->buildAndCheckCapability('UPDATE', 'Roles') ? $this->Html->link('<i class="fal fa-pencil fa-fw"></i> Edit Role', ['controller' => 'Roles', 'action' => 'edit', $role->id], ['title' => __('Edit Role'), 'class' => 'btn btn-primary', 'role' => 'button', 'escape' => false]) : '' ?>
                        <?= $this->Identity->buildAndCheckCapability('DELETE', 'Roles') ? $this->Form->postLink('<i class="fal fa-trash-alt"></i> Delete Role', ['controller' => 'Roles', 'action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete the role {0} for {1}?', $role->role_type->role_type, $role->user->full_name), 'title' => __('Delete Role'), 'class' => 'btn btn-danger', 'style' => 'margin-left: 10px;', 'escape' => false]) : '' ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <?php if ($role->has($role::FIELD_ROLE_TYPE)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Role Type</span></td>
                                                <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'RoleTypes') ? $this->Html->link($role->role_type->role_type, ['controller' => 'RoleTypes', 'action' => 'view', $role->role_type->id]) : h($role->role_type->role_type) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($role->has($role::FIELD_USER)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Member</span></td>
                                                <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'Users') ? $this->Html->link($role->user->full_name, ['controller' => 'Users', 'action' => 'view', $role->user->id]) :  $role->user->full_name ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td><span class="text-muted mb-2">Role Status</span></td>
                                            <td><?= $role->role_status->role_status ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="card thick-card">
                            <div class="card-body">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tbody>
                                        <?php if ($role->has($role::FIELD_ROLE_TYPE) && $role->role_type->has(\App\Model\Entity\RoleType::FIELD_ROLE_ABBREVIATION)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Role Abbreviation</span></td>
                                                <td><?= $this->Identity->buildAndCheckCapability('VIEW', 'RoleTypes') ? $this->Html->link($role->role_type->role_abbreviation, ['controller' => 'RoleTypes', 'action' => 'view', $role->role_type->id]) : h($role->role_type->role_abbreviation) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <?php if ($role->has($role::FIELD_USER_CONTACT)) : ?>
                                            <tr>
                                                <td><span class="text-muted mb-2">Contact Email</span></td>
                                                <td><?= $this->Text->autoLinkEmails($role->user_contact->contact_field) ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                <div class="card-header">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
                            <li class="nav-item"><a class="nav-link active" id="audit-tab" data-toggle="tab" href="#audit" role="tab" aria-controls="audit" aria-selected="false" style="font-family: 'Nunito Sans', sans-serif;">Changes to Role</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="myTabContent">
                        <?php if ($this->Identity->checkCapability('HISTORY')) : ?>
                            <div class="tab-pane fade show active" id="audit" role="tabpanel" aria-labelledby="audit-tab">
                                <div class="table-borderless">
                                    <table class="table">
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Created</span></td>
                                            <td><?= $this->Time->format($role->created, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                        <tr>
                                            <td><span class="text-muted mb-2">Date Updated</span></td>
                                            <td><?= $this->Time->format($role->modified, 'dd-MMM-yy HH:mm') ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <?php if (!empty($role->audits)) : ?>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <tr>
                                                <th scope="col"><?= __('Audit Field') ?></th>
                                                <th scope="col"><?= __('Old Value') ?></th>
                                                <th scope="col"><?= __('New Value') ?></th>
                                                <th scope="col"><?= __('Changed By') ?></th>
                                                <th scope="col"><?= __('Change Date') ?></th>
                                            </tr>
                                            <?php foreach ($role->audits as $audit) : ?>
                                                <tr>
                                                    <td><?= $this->Inflection->space(str_replace('_id', '', $audit->audit_field)) ?></td>
                                                    <td><?= auditValue($audit, true, $this->Html) ?></td>
                                                    <td><?= auditValue($audit, false, $this->Html) ?></td>
                                                    <td><?= $audit->has('user') ? $this->Html->link($audit->user->full_name, ['controller' => 'Users', 'action' => 'view', $audit->user->id]) : '' ?></td>
                                                    <td><?= $this->Time->format($audit->change_date, 'dd-MMM-yy HH:mm') ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    <div class="alert alert-dark">No Changes</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
