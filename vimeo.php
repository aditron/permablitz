<?php

$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/135218297.php"));
echo $hash[0]['thumbnail_large']

?>