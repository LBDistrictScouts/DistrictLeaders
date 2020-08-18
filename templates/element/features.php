<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="container">
    <div class="intro"></div>
    <div class="row justify-content-center features">
        <div class="col-sm-6 col-md-5 col-lg-4 item">
            <div class="box"><?= $this->Icon->iconHtml('address-book', ['icon']) ?>
                <h3 class="name">Find Other Members</h3>
                <p class="description">Use the digitised district directory to find users from across the district and have their latest roles and contact information.</p>
                <?php if ($this->Identity->isLoggedIn()) :
                    ?><a class="learn-more" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'search']) ?>">Search for a Member »</a><?php
                endif; ?>
            </div>
        </div>
        <div class="col-sm-6 col-md-5 col-lg-4 item">
            <div class="box"><?= $this->Icon->iconHtml('paw', ['icon']) ?>
                <h3 class="name">Section Information</h3>
                <p class="description">View other's section information: meeting times, leaders, contact emails. Manage your own section's information.</p>
                <?php if ($this->Identity->isLoggedIn()) :
                    ?><a class="learn-more" href="<?= $this->Url->build(['controller' => 'Sections', 'action' => 'search']) ?>">Search for a Section »</a><?php
                endif; ?>
            </div>
        </div>
        <div class="col-sm-6 col-md-5 col-lg-4 item">
            <div class="box"><?= $this->Icon->iconHtml('sitemap', ['icon']) ?>
                <h3 class="name">Group Information</h3>
                <p class="description">View information on Groups across the District. A central and accurate list of people in roles for that group.</p>
                <?php if ($this->Identity->isLoggedIn()) :
                    ?><a class="learn-more" href="<?= $this->Url->build(['controller' => 'ScoutGroups', 'action' => 'index']) ?>">Whats going on »</a><?php
                endif; ?>
            </div>
        </div>
    </div>
</div>

