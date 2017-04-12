<?php

// $user_name = "permablitz@gmail.com";
$user_name = '113886493944065832069';
$picasa_album_id = "6223926516706581249";

// build feed URL
$feedURL ="http://picasaweb.google.com/data/feed/api/user/$user_name/albumid/$picasa_album_id";

// echo $feedURL;

// read feed into SimpleXML object
$sxml = simplexml_load_file($feedURL);

// get album names and number of photos in each
//echo "<ul>";

$photos = array();
foreach ($sxml->entry as $entry) {
  
	$source = $entry->content['src'];
  $src_parts = explode('/',$source);

  $temp['lrg'] = 'http://' . $src_parts[2] . '/' . $src_parts[3] . '/' . $src_parts[4] . '/' . $src_parts[5]
    . '/'. $src_parts[6] . '/s1024/' . $src_parts[7];
  $temp['thumb'] = 'http://' . $src_parts[2] . '/' . $src_parts[3] . '/' . $src_parts[4] . '/' . $src_parts[5]
    . '/'. $src_parts[6] . '/s110/' . $src_parts[7];
  $temp['title'] = $entry->title;

  $photos[] = $temp;
}

print_r($photos);