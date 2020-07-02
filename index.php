<?php

require_once 'classes/Tag.php';

$div = new Tag('div');
$div->addClass('new'); // class="container"
$div->addClass('container'); // class="container"
$div->addClass('bg-blue'); // class="container bg-blue"
$div->removeClass('bg-blue');

/*if ($div->classExists('container')) // true
    $div->removeClass('container'); //class="bg-blue"*/
echo $div;