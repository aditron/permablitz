<?php

require_once('wp-load.php');

global $wpdb;

$test = 'v9amk';

$form_id = $wpdb->get_var( $wpdb->prepare(  "
                                                          SELECT form_id 
                                                          FROM `pbz_frm_items`
                                                          WHERE `item_key` = %s
                                                        ", 
                                                        $test
                                                      ) );

            if ($form_id) {
              $users = get_users(array('meta_key' => 'host_form', 'meta_value' => $form_id ) );
              print_r($users);
            }

//echo do_shortcode('[permablitz_news edm="true" post_id=5050]')

// sendBlitzNotification(5434);	