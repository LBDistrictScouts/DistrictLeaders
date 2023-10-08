<?php
/**
 * @var AppView $this
 */

use App\View\AppView;

$identity = $this->getRequest()->getAttribute('identity');
?>
<section class="features-icons bg-light text-center" style="padding: 0 10px 50px 10px;">
    <div class="container">
        <div class="row">
            <?php if ($this->Functional->checkFunction('directory', $identity)) : ?>
                <div class="col">
                    <div class="row" style="padding: 25px 0px;">
                        <div class="col">
                            <?= $this->Icon->iconHtmlEntity('Directory', ['fa-5x', 'm-auto', 'text-primary']) ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col">
                            <h3>My District Record</h3>
                            <p class="lead mb-0">Edit your contact details, sharing settings and subscriptions.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">

                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $this->Identity->getId()]) ?>"><button class="btn btn-primary">Edit Details</button></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->Functional->checkFunction('articles', $identity)) : ?>
                <div class="col">
                    <div class="row" style="padding: 25px 0px;">
                        <div class="col">
                            <?= $this->Icon->iconHtmlEntity('Articles', ['fa-5x', 'm-auto', 'text-primary']) ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col">
                            <h3>Submit a News Article</h3>
                            <p class="lead mb-0">Submit a News Article to Co-ordinator, the website and email subscriptions.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="#"><button class="btn btn-primary">Submit Article</button></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->Functional->checkFunction('documents', $identity)) : ?>
                <div class="col">
                    <div class="row" style="padding: 25px 0px;">
                        <div class="col">
                            <?= $this->Icon->iconHtmlEntity('Documents', ['fa-5x', 'm-auto', 'text-primary']) ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col">
                            <h3>Documents</h3>
                            <p class="lead mb-0">District Document Repository: Policies, Forms etc.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?= $this->Url->build(['controller' => 'Documents', 'action' => 'index']) ?>"><button class="btn btn-primary">District Documents</button></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->Functional->checkFunction('camps', $identity)) : ?>
                <div class="col">
                    <div class="row" style="padding: 25px 0px;">
                        <div class="col">
                            <?= $this->Icon->iconHtmlEntity('Camps', ['fa-5x', 'm-auto', 'text-primary']) ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col">
                            <h3>Camps</h3>
                            <p class="lead mb-0">Record camps, build NAN forms and log your Nights Away activity ready for renewal.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?= $this->Url->build(['controller' => 'Camps', 'action' => 'index']) ?>"><button class="btn btn-primary">Camps</button></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if ($this->Functional->checkFunction('Tasks', $identity)) : ?>
                <div class="col">
                    <div class="row" style="padding: 25px 0px;">
                        <div class="col">
                            <?= $this->Icon->iconHtmlEntity('Tasks', ['fa-5x', 'm-auto', 'text-primary']) ?>
                        </div>
                    </div>
                    <div class="row" style="padding-bottom: 25px;">
                        <div class="col">
                            <h3>Tasks</h3>
                            <p class="lead mb-0">View assigned tasks.</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?= $this->Url->build(['controller' => 'Camps', 'action' => 'index']) ?>"><button class="btn btn-primary">Camps</button></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
