<?php
/**
 * @var AppView $this
 */

//jQuery v 3.0
use App\View\AppView;

echo $this->Html->script('https://code.jquery.com/jquery-3.3.1.slim.min.js', ['integrity' => 'sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo', 'crossorigin' => 'anonymous']);

// enquiry
//echo $this->Html->script('https://cdn.jsdelivr.net/enquire.js/2.0.2/enquire.min.js', ['integrity' => 'sha256-DLTMGP8jrtWrIw8RQlVHP8YxaxaOSh0i9FeVW2zQWWA=', 'crossorigin' => 'anonymous']);

// Bootstrap Core JavaScript
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', ['integrity' => 'sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49', 'crossorigin' => 'anonymous']);
echo $this->Html->script('https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', ['integrity' => 'sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy', 'crossorigin' => 'anonymous']);

// Metis Menu Plugin JavaScript
echo $this->Html->script('https://cdn.jsdelivr.net/bootstrap.metismenu/1.1.2/js/metismenu.min.js', ['integrity' => 'sha256-MAI5Y7qcRpuhprsWe9eWvOQIw3qXfoeMIOVLxeMPcLQ=', 'crossorigin' => 'anonymous']);
echo $this->Html->script('https://cdn.jsdelivr.net/bootstrap.metismenu/1.1.2/js/jquery.metisMenu.min.js', ['integrity' => 'sha256-D8soXgWi3lwrBPuRny4yEIx9DvPV+BcQZ8D+32I4aKo=', 'crossorigin' => 'anonymous']);

// Morris Charts JavaScript
//echo $this->Html->script('raphael-min.js');
//echo $this->Html->script('morris.min.js');
//echo $this->Html->script('morris-data.js');

// DataTable Script
//echo $this->Html->script('https://cdn.jsdelivr.net/bootstrap.datatables/0.1/js/datatables.js', ['integrity' => 'sha256-dVT99dsafzuKVv/8al7mZbjm1ohxdc34BBkVj3u4VS8=', 'crossorigin' => 'anonymous']);
//echo $this->Html->script('https://cdn.jsdelivr.net/jquery.datatables/1.10.10/js/jquery.dataTables.min.js', ['integrity' => 'sha256-YKbJo9/cZwgjue3I4jsFKdE+oGkrSpqZz6voxlmn2Fo=', 'crossorigin' => 'anonymous']);


// Custom Theme JavaScript
//echo $this->Html->script('sb-admin-2.js');

// Font Awesome CDN
echo $this->Html->script('https://kit.fontawesome.com/e771944051.js', ['defer' => true, 'crossorigin' => 'anonymous']);
