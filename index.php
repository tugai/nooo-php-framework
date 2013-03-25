<?php
require_once 'lib/application.php';

$layout = array(
    'title' => $app['title'],
    'content' => 'view/index.php'
);
    
require 'layout/default.php';
