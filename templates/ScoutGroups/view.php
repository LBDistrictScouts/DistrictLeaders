<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ScoutGroup $scoutGroup
 */
?>
<div class="row">
    <div class="col">
        <div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(/img/activity-bg-1.jpg);background-size: cover;height: 300px;"></div>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-body">
                <div class="row">
                    <div class="col" style="margin-top: 10px;margin-bottom: 10px;">
                        <h4 style="font-family: 'Nunito Sans', sans-serif;"><?= h($scoutGroup->group_alias) ?></h4>
                        <h6 class="text-muted mb-2" style="font-family: 'Nunito Sans', sans-serif;"><?= h($scoutGroup->scout_group) ?></h6>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-4 col-xl-3 d-lg-flex d-xl-flex justify-content-lg-end justify-content-xl-end" style="margin-top: 10px;margin-bottom: 15px;">
                        <div class="dropdown d-lg-none"><button class="btn btn-primary dropdown-toggle d-sm-block d-md-block" data-toggle="dropdown" aria-expanded="false" type="button">Actions&nbsp;</button>
                            <div class="dropdown-menu" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </div>
                        <div class="dropleft d-none d-sm-none d-lg-inline"><button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button" style="font-family: 'Nunito Sans', sans-serif;">Actions</button>
                            <div class="dropdown-menu dropdown-menu-right" role="menu"><a class="dropdown-item" role="presentation" href="#">First Item</a><a class="dropdown-item" role="presentation" href="#">Second Item</a><a class="dropdown-item" role="presentation" href="#">Third Item</a></div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Section</th>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Meeting Day</th>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Start Time</th>
                            <th>End Time</th>
                            <th>Section Contact</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Beavers</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Tuesday</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">18:15</td>
                            <td>19:30</td>
                            <td>beavers@4thletchworth.com</td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Cubs</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Friday</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">18:00</td>
                            <td>19:30</td>
                            <td>cubs@4thletchworth.com</td>
                        </tr>
                        <tr>
                            <td>Scouts</td>
                            <td>Friday</td>
                            <td>19:45</td>
                            <td>21:30</td>
                            <td>scouts@4thletchworth.com</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                    <div class="card-body">
                        <h5 style="font-family: 'Nunito Sans', sans-serif;">Executive</h5>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Chair:&nbsp;</strong><a href="#">Edyta Sidzmir<br></a></p>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Treasurer:&nbsp;</strong><a href="#">Sarah Berry<br></a></p>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Secretary:&nbsp;</strong><a href="#">Andreea Weisl<br></a></p>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Committee:</strong></p>
                        <ul>
                            <li><a href="https://bootstrapstudio.io/app/?shell=4#"><span style="text-decoration: underline;">Jenny George</span></a></li>
                            <li><a href="https://bootstrapstudio.io/app/?shell=4#"><span style="text-decoration: underline;">Charles Stoten</span></a></li>
                            <li><a href="https://bootstrapstudio.io/app/?shell=4#"><span style="text-decoration: underline;">Greg Rose</span></a><br></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
                    <div class="card-body">
                        <h5 style="font-family: 'Nunito Sans', sans-serif;">Group Information</h5>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Charity Number:</strong>&nbsp;8272012</p>
                        <p class="card-text" style="font-family: 'Nunito Sans', sans-serif;"><strong>Domain:</strong> <?= $this->Html->link($scoutGroup->clean_domain, $scoutGroup->group_domain) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#" style="font-family: 'Nunito Sans', sans-serif;">Leaders</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" style="font-family: 'Nunito Sans', sans-serif;">Changes to Group</a></li>
                </ul>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Leader</th>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Leader Contact</th>
                            <th style="font-family: 'Nunito Sans', sans-serif;">Section</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Jacob Tyler</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">jacob@4thletchworth.com</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">4th Letchworth Cubs</td>
                            <td><i class="fa fa-eye"></i>&nbsp;<i class="fa fa-pencil"></i>&nbsp;<i class="fa fa-trash"></i></td>
                        </tr>
                        <tr>
                            <td style="font-family: 'Nunito Sans', sans-serif;">Russell Wake</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">russell@4thletchworth.com</td>
                            <td style="font-family: 'Nunito Sans', sans-serif;">4th Letchworth Cubs</td>
                            <td><i class="fa fa-eye"></i>&nbsp;<i class="fa fa-pencil"></i>&nbsp;<i class="fa fa-trash"></i></td>
                        </tr>
                        <tr>
                            <td>Vicki Gage</td>
                            <td>vicki@4thletchworth.com</td>
                            <td>4th Letchworth Beavers</td>
                            <td><i class="fa fa-eye"></i>&nbsp;<i class="fa fa-pencil"></i>&nbsp;<i class="fa fa-trash"></i></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
