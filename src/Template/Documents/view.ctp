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
<?php foreach ($document->document_versions as $documentVersions): ?>
<div class="row">
    <div class="col">
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <h5 style="font-family: 'Nunito Sans', sans-serif;">Version <?= $this->Number->format($documentVersions->version_number) ?></h5>
                <br />
                <h6 class="text-muted card-subtitle mb-2" style="font-family: 'Nunito Sans', sans-serif;"><?= $this->Time->format($documentVersions->created, 'dd-MMM-yyyy HH:mm') ?></h6>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-6"><img class="img-fluid" src="/img/bg-showcase-2.jpg"></div>
                    <div class="col">
                        <div class="row text-center">
                            <?php foreach ($documentVersions->document_editions as $documentEditions): ?>
                                <div class="col-auto"><i class="fal fa-file-pdf fa-5x"></i>
                                    <p><?= $this->Number->toReadableSize($documentEditions->size) ?></p>
                                </div>
                            <?php endforeach; ?>

                            <div class="col-auto"><i class="fal fa-file-word fa-5x"></i>
                                <p>47GB</p>
                            </div>
                            <div class="col-auto"><i class="fab fa-markdown fa-5x"></i>
                                <p>12TB</p>
                            </div>
                            <div class="col-auto"><i class="fal fa-file-image fa-5x"></i>
                                <p>19KB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
