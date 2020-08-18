<?php
/**
 * @var \App\View\AppView $this
 */
?>
<section class="masthead text-white text-center" style="background: url(<?= $this->Url->image('bg-masthead.jpg') ?>)no-repeat center center;background-size: cover;padding: 100px 0px;">
    <div class="overlay" style="height: 100px;"></div>
    <div class="container-fluid" style="margin: 0;">
        <?= $this->Form->create(null, ['type' => 'get', 'url' => ['controller' => 'Users', 'action' => 'search'], 'valueSources' => 'query']) ?>
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-7 align-self-center" style="height: 100px;padding: 25px 25px;">
                    <div class="form-group text-white-50">
                        <?= $this->Form->control('q', ['class' => 'form-control form-control-lg flex-fill search-field', 'type' => 'search', 'label' => false, 'placeholder' => 'Search Members...']) ?>
                    </div>
                </div>
                <div class="col-sm-10 col-md-4 col-lg-4" style="height: 100px;padding: 25px 15px;">
                    <?= $this->Form->button('Search', ['type' => 'submit', 'class' => 'btn btn-dark btn-block btn-lg text-center']) ?>
                </div>
            </div>
        <?= $this->Form->end() ?>
    </div>
</section>
