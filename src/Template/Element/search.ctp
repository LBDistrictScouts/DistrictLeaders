<?php
/**
 * @var \App\View\AppView $this
 */

$function = $this->Functional->checkFunction('search');
$element = $this->Functional->checkSearchConfigured($this->fetch('entity'));

if ($function && $element) : ?>
    <section class="masthead text-white text-center" style="background: url(<?= $this->Url->image('bg-masthead.jpg') ?>)no-repeat center center;background-size: cover;padding: 100px 0px;">
        <div class="overlay" style="height: 100px;"></div>
        <div class="container-fluid" style="margin: 0;">
            <div class="row justify-content-center">
                <div class="col-sm-10 col-md-7 col-lg-7 align-self-center" style="height: 100px;padding: 25px 25px;"><input class="form-control-lg form-control" type="search" placeholder="Search <?= h($this->fetch('entity')) ?>..."></div>
                <div class="col-sm-10 col-md-4 col-lg-4" style="height: 100px;padding: 25px 15px;"><button class="btn btn-primary btn-block btn-lg text-center" type="submit">Search</button></div>
            </div>
        </div>
    </section>
<?php endif; ?>
