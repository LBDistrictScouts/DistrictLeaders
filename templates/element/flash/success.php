<?php
/**
 * @var \App\View\AppView $this
 * @var array $params
 */
$class = [
	'alert',
	'alert-dismissible',
	'alert-success'
];

if (isset($params) && key_exists('class', $params) && is_array($params['class'])) {
	array_merge($class, $params['class']);
}

if (key_exists('error', $class)) {
	array_push($class, 'alert-danger');
}

//$class .= ' ' . array_unique($params['class']);

if (!isset($params['escape']) || $params['escape'] !== false) {
	$message = h($message);
}

if (in_array('alert-dismissible', $class)) {
	$button = <<<BUTTON
<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
BUTTON;
	$message = $button . $message;
}

$classString = '';

foreach ($class as $idx => $classItem) {
    if ($idx == 0) {
        $classString .= $classItem;
    } else {
        $classString .= ' ' . $classItem;
    }
}

if (key_exists('attributes',$params)) {
	echo $this->Html->div($classString, $message, $params['attributes']);
} else {
	echo $this->Html->div($classString, $message);
}
