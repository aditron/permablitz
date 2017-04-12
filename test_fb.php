<?php

require_once('wp-load.php');

// $path = get_home_path();
// echo ABSPATH;

// $blog = get_bloginfo();
// print_r($blog);
$test = 'test<br>more more <br><br> <br><br>';
// echo preg_replace('\*{<br>}', '', $test);
echo $test;
echo preg_replace("/<br\W*?\/>/", "", $test);