<?php
/**
 * Created by PhpStorm.
 * User: jacob
 * Date: 10/12/2017
 * Time: 18:44
 *
 * @var \App\View\AppView $this
 */

echo $this->Html->meta('icon');

echo $this->Html->css('styles.css');

echo $this->Html->css('https://cdn.jsdelivr.net/bootstrap.metismenu/1.1.2/css/metismenu.min.css', ['integrity' => 'sha256-7K7McfQ/UPBtbdwy48S6xEZH3gWIl3lAQQap565MJjI=', 'crossorigin' => 'anonymous']);
echo $this->Html->css('https://cdn.jsdelivr.net/jquery.metismenu/2.5.2/metisMenu.min.css', ['integrity' => 'sha256-XjZ0z1dEt5rG6mqMEhy+ssUiX+83tigMsRhQX1nqvKs=', 'crossorigin' => 'anonymous']);

echo $this->Html->css('https://fonts.googleapis.com/css?family=Nunito+Sans');

echo $this->Html->css('https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic');
echo $this->Html->css('https://fonts.googleapis.com/css?family=Cookie');

echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css');
