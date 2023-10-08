<?php
/**
 * @var AppView $this
 */

use App\View\AppView;

$imageUrl = '/img/';
$imageArray = [
    'activity-bg-1.jpg',
    'activity-bg-2.jpg',
    'activity-bg-3.jpg',
];

try {
    $imageKey = random_int(0, count($imageArray) - 1);
    $imageUrl .= $imageArray[$imageKey];
} catch (Exception $e) {
    $imageUrl .= '/img/activity-bg-1.jpg';
}

?>
<div class="jumbotron d-none d-sm-none d-md-flex d-lg-flex d-xl-flex" style="background-image: url(<?= $imageUrl ?>);background-size: cover;height: 300px;">
</div>
