<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Document $document
 */
?>
<div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-2.jpg);background-size: cover;height: 300px;background-position: center;"></div>
<div class="card" style="margin-top: 15px;margin-bottom: 15px;">
    <div class="card-body">
        <div class="row">
            <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($document->document) ?></h4>
                <br />
                <h6 style="font-family: 'Nunito Sans', sans-serif;"><span class="text-muted mb-2">Type:</span> <?= $document->has('document_type') ? $this->Html->link($document->document_type->document_type, ['controller' => 'Documents', 'action' => 'index', '?' => [$document->document_type->document_type => true]]) : '' ?></h6>
                <h6 style="font-family: 'Nunito Sans', sans-serif;"><span class="text-muted mb-2">Date Created:</span> <?= $this->Time->format($document->created, 'dd-MMM-yyyy HH:mm') ?></h6>
                <h6 style="font-family: 'Nunito Sans', sans-serif;"><span class="text-muted mb-2">Date Modified:</span> <?= $this->Time->format($document->modified, 'dd-MMM-yyyy HH:mm') ?></h6>
                <h6 style="font-family: 'Nunito Sans', sans-serif;"><span class="text-muted mb-2" >Latest version:</span> <?= $this->Number->format($document->latest_version) ?></h6>
            </div>
        </div>
    </div>
</div>
<?php foreach ($document->document_versions as $documentVersions) : ?>
<div class="row">
    <div class="col">
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h5 style="font-family: 'Nunito Sans', sans-serif;">Version <?= $this->Number->format($documentVersions->version_number) ?></h5>
                    </div>
                    <div class="col align-right">
                        <div class="row">
                            <div class="col">
                                <div class="d-inline">
                                    <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button">Actions</button>
                                    <div class="dropdown-menu" role="menu">
                                        <?= $this->Identity->buildAndCheckCapability('VIEW', 'CompassRecords') && $document->document_type->document_type == 'Compass Upload' ? $this->Html->link('View Records Imported', ['controller' => 'CompassRecords', 'action' => 'index', $documentVersions->id], ['class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                        <?= $this->Identity->buildAndCheckCapability('UPDATE', 'DocumentVersions') && $document->document_type->document_type == 'Compass Upload' ? $this->Html->link('Map Fields', ['controller' => 'DocumentVersions', 'action' => 'map', $documentVersions->id], ['class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                        <?= $this->Identity->buildAndCheckCapability('CREATE', 'CompassRecords') && $document->document_type->document_type == 'Compass Upload' ? $this->Form->postLink('Parse Compass Upload', ['controller' => 'DocumentVersions', 'action' => 'compass', $documentVersions->id], ['confirm' => __('Are you sure you want to parse upload: "{0}" version #{1}?', $document->document, $documentVersions->version_number), 'title' => __('Parse Compass'), 'class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                        <?= $this->Identity->buildAndCheckCapability('CREATE', 'CompassRecords') && $document->document_type->document_type == 'Compass Upload' ? $this->Form->postLink('Auto Merge All Uploaded Records', ['controller' => 'DocumentVersions', 'action' => 'auto-merge', $documentVersions->id], ['confirm' => __('Are you sure you want to auto merge the upload: "{0}" version #{1}?', $document->document, $documentVersions->version_number), 'title' => __('Auto Merge Uploaded Compass Records'), 'class' => 'dropdown-item', 'role' => 'presentation']) : '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <?= $documentVersions->has($documentVersions::FIELD_FIELD_MAPPING) ? $this->Icon->iconHtml('map-marked-alt', ['fa-3x', 'float-right']) : '' ?>
                            </div>
                        </div>
                    </div>
                </div>
                <h6 class="text-muted card-subtitle mb-2" style="font-family: 'Nunito Sans', sans-serif;"><?= $this->Time->format($documentVersions->created, 'dd-MMM-yyyy HH:mm') ?></h6>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6">
                        <img class="img-fluid" src="/img/bg-showcase-2.jpg">
                    </div>
                    <div class="col">
                        <div class="table-responsive table-hover">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">File Type</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($documentVersions->document_editions as $documentEditions) : ?>
                                    <tr>
                                        <td><i class="fal fa-file-csv fa-3x"></i></td>
                                        <td><?= $this->Number->toReadableSize($documentEditions->size) ?></td>
                                        <td><?= $this->Time->format($documentEditions->created, 'dd-MMM-yyyy HH:mm') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
