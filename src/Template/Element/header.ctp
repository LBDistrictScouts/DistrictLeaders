<?php
/**
 * @var \App\View\AppView $this
 */
?>
<header>
    <?php if ($this->Functional->checkFunction('search')) : ?>
        <section class="masthead text-white text-center" style="background: url(<?= $this->Url->image('bg-masthead.jpg') ?>)no-repeat center center;background-size: cover;padding: 100px 0px;">
            <div class="overlay" style="height: 100px;"></div>
            <div class="container-fluid" style="margin: 0;">
                <div class="row justify-content-center">
                    <div class="col-sm-10 col-md-7 col-lg-7 align-self-center" style="height: 100px;padding: 25px 25px;"><input class="form-control-lg form-control" type="search" placeholder="Search District Directory..."></div>
                    <div class="col-sm-10 col-md-4 col-lg-4" style="height: 100px;padding: 25px 15px;"><button class="btn btn-primary btn-block btn-lg text-center" type="submit">Search</button></div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <section class="features-icons bg-light text-center" style="padding: 0 10px 50px 10px;">
        <div class="container">
            <div class="row">
                <?php if ($this->Functional->checkFunction('directory')) : ?>
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
                                <a href="#"><button class="btn btn-primary">Edit Details</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($this->Functional->checkFunction('articles')) : ?>
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
                <?php if ($this->Functional->checkFunction('documents')) : ?>
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
                                <a href="#"><button class="btn btn-primary">District Documents</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($this->Functional->checkFunction('camps')) : ?>
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
                                <a href="#"><button class="btn btn-primary">Camps</button></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</header>