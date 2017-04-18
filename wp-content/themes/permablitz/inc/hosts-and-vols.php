<?php

/***

    VOLUNTEER DROP-OUT MANAGEMENT

*/

function volunteer_add_query_vars($aVars) {
    $aVars[] = "vol_key";
    $aVars[] = "host_key";
    return $aVars;
}
// hook add_query_vars function into query_vars
add_filter('query_vars', 'volunteer_add_query_vars');

function volunteer_add_rewrite_rules($aRules) {
    $aNewRules = array('volunteers/([^/]+)/?$' => 'index.php?pagename=volunteers&vol_key=$matches[1]');
    $aRules = $aNewRules + $aRules;
    return $aRules;
}
 
// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'volunteer_add_rewrite_rules');

function host_add_rewrite_rules($aRules) {
    $aNewRules = array('hosts/([^/]+)/?$' => 'index.php?pagename=hosts&host_key=$matches[1]');
    $aRules = $aNewRules + $aRules;
    return $aRules;
}
 
// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'host_add_rewrite_rules');

add_filter('frm_to_email', 'notifyHostOfDropout', 10, 4);

function notifyHostOfDropout($recipients, $values, $form_id, $args){
    if($form_id == 5 && $args['email_key'] == 4108){ // email_key is the Action ID
        foreach ( $values as $value ) {
            if ( $value->field_id != 465 ) continue; //465 is the USER id

            global $wpdb;
            $form_id = $wpdb->get_var( $wpdb->prepare(  "
                                                          SELECT form_id 
                                                          FROM `pbz_frm_items`
                                                          WHERE `item_key` = %s
                                                        ", 
                                                        $value->meta_value
                                                      ) );

            if ($form_id) {
              $users = get_users(array('meta_key' => 'host_form', 'meta_value' => $form_id ) );
              foreach ($users as $user) {
                $recipients[] = $user->user_email;
              }
              
            }
      unset( $field_id, $value );
        }
    }
    return $recipients;
}

add_filter('frm_get_default_value', 'volunteer_defaults', 10, 2);
function volunteer_defaults($new_value, $field) {

$vol_key = get_query_var('vol_key');
  
  if($field->field_key == '49oase'){
    global $wp_query;
    $new_value = stripslashes( getVolunteerNameFromFormidableForm( $vol_key ) );
  }
  global $wpdb;

  if($field->field_key == 'ksh74x'  ){
      $form_id = $wpdb->get_var( "SELECT form_id FROM pbz_frm_items WHERE item_key = '$vol_key' " );
      $email = getVolunteerEmailFromFormidableForm($form_id, $vol_key);
      $new_value = $email;
  }
  return $new_value;
}

function getVolunteerNameFromFormidableForm($vol_key) {
  global $wpdb;
  $name = $wpdb->get_var( "SELECT name FROM pbz_frm_items WHERE item_key = '$vol_key' " );
  return $name;
}

function getFieldIDFromFormidableForm($form_id, $name) {
  global $wpdb;
  $field_id = $wpdb->get_var( "SELECT id FROM pbz_frm_fields WHERE form_id = '$form_id' AND name='$name' " );
  return $field_id;
}

function getVolunteerEmailFromFormidableForm($form_id, $vol_key) {
  global $wpdb;

  $item_id = $wpdb->get_var( "SELECT id FROM pbz_frm_items WHERE item_key = '$vol_key' " );
  $email = $wpdb->get_var( 
        "SELECT IM.meta_value
  FROM pbz_frm_fields as F,
  pbz_frm_item_metas as IM
  WHERE F.id = IM.field_id
  AND F.form_id = $form_id
  AND F.type = 'Email'
  AND IM.item_id = $item_id ");

  return $email;
}


add_action('frm_after_create_entry', 'updateVolunteerData', 30, 2);
add_action('frm_after_update_entry', 'updateVolunteerData', 10, 2);
function updateVolunteerData($entry_id, $form_id){

  $formID = get_id_from_key_frm('wl4svy', 'form');
  $vol_key_ID = get_id_from_key_frm('ztvnp');
  $name_ID = get_id_from_key_frm('49oase');
  $email_ID = get_id_from_key_frm('ksh74x');
  $comments_ID = get_id_from_key_frm('yh4zap');

     if ( $form_id == $formID ) {
         global $wpdb, $frmdb;

          $vol_key = $_POST['item_meta'][$vol_key_ID];

          $form_to_update = $wpdb->get_var( "SELECT form_id FROM pbz_frm_items WHERE item_key = '$vol_key' " );

          $user = $wpdb->get_var($wpdb->prepare("SELECT user_id FROM $frmdb->entries WHERE id=%d", $entry_id));

         $attending_id = $wpdb->get_var($wpdb->prepare("SELECT id FROM $frmdb->fields WHERE name=%s AND form_id=%d", 'Attending', $form_to_update));
         
         //See if this user already has an entry in second form
         $entry_id = $wpdb->get_var("Select id from $frmdb->entries where form_id='" . $form_to_update . "' and user_id=". $user);
         if ( $entry_id ) {
             //update entry
             $wpdb->update( 
                        $frmdb->entry_metas, 
                        array('meta_value' => 'No'), 
                        array('item_id' => $entry_id, 
                        'field_id' => $attending_id
                        )
                      );
         }

         // and now send out the email
        $sql = "SELECT post_content FROM pbz_posts WHERE post_type = 'frm_form_actions' AND post_title LIKE '%Host Notification%' AND menu_order = 48";
        $result = $wpdb->get_results($sql);
        foreach( $result as $results ) {

            $result = json_decode($results->post_content);
        }

          $vol_name = stripslashes($_POST['item_meta'][$name_ID]);
          $vol_email = $_POST['item_meta'][$email_ID];
          $vol_comments = stripslashes($_POST['item_meta'][$comments_ID]);

$message = 'The below volunteer is no longer to attend the blitz. If you have backup volunteers, you may wish to contact them.'."\n\n";
$message .= 'Name: '.$vol_name."\n";
$message .= 'Email: '.$vol_email."\n\n";
if ($vol_comments) {
    $message .= 'Comment: '."\n" . $vol_comments ."\n\n";
}
$message .= 'If you are having any issues with volunteers or the blitz in general, please don\'t hestitate to contact the Permablitz Collective at permablitz@gmail.com ';

$headers[] = array('Content-Type: text/html; charset=UTF-8');
$headers[] = 'From: ' .  $vol_name .' <' . $vol_email .'>' . "\r\n";

$subject = 'Volunteer Dropout';

add_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );

if (is_array($result->email_to)) {
    foreach($result->email_to as $to) {
  $sent = wp_mail($to, $subject, $message);
}  
} else {
   $sent = wp_mail($result->email_to, $subject, $message);
}
  
remove_filter( 'wp_mail_content_type', 'wpdocs_set_html_mail_content_type' );
        
  }
}

add_action( 'show_user_profile', 'host_extra_profile_fields' );
add_action( 'edit_user_profile', 'host_extra_profile_fields' );

function host_extra_profile_fields( $user ) { 
  if (in_array('host', $user->caps)) {

    global $wpdb;
    $results = $wpdb->get_results( 'SELECT * FROM pbz_frm_forms ORDER BY name ASC', OBJECT );
    
    ?>

  <h3>Host Permissions</h3>

  <table class="form-table">

    <tr>
      <th><label for="host_form">Visible Form</label></th>

      <td>
        <select name="host_form" id="host_form">
          <option value="">Please select</option>
        <?php
          foreach ( $results as $result ) 
          {
            echo '<option value="' . $result->id . '"';
            if ( get_the_author_meta( 'host_form', $user->ID ) == $result->id ) {
              echo ' selected="selected"';
            }
            echo '>' . $result->name . '</option>';
          }
          ?>
        </select>
        <br />
        <span class="description">Please choose the form this user is able to review.</span>
      </td>
    </tr>
    <?php
    $args = array(
          'post_type'=>'event',
          'posts_per_page'=>-1,
           'tax_query' => array(  
    'relation' => 'AND',        
      array(
        'taxonomy' => 'event-categories',
        'field' => 'id',
        'terms' => 57,   
        'operator' => 'IN' 
          )
      )
           );

    $blitzes = new WP_Query( $args );
      ?>

    <tr>
      <th><label for="host_blitz">Associated Blitz</label></th>

      <td>
        <select name="host_blitz" id="host_blitz">
          <option value="">Please select</option>
        <?php        
          while ( $blitzes->have_posts() ) : $blitzes->the_post();
            echo '<option value="' . get_the_ID() . '"';
            if ( get_the_author_meta( 'host_blitz', $user->ID ) == get_the_ID() ) {
              echo ' selected="selected"';
            }
            echo '>' . get_the_title() . '</option>';
          endwhile; 
          wp_reset_postdata();
          ?>
        </select>
        <br />
        <span class="description">Please choose the blitz associated with this user.</span>
      </td>
    </tr>

  </table>
<?php } }

add_action( 'personal_options_update', 'host_extra_profile_fields_update' );
add_action( 'edit_user_profile_update', 'host_extra_profile_fields_update' );

function host_extra_profile_fields_update( $user_id ) {

  if ( !current_user_can( 'edit_user', $user_id ) )
    return false;

  update_usermeta( $user_id, 'host_form', $_POST['host_form'] );
  update_usermeta( $user_id, 'host_blitz', $_POST['host_blitz'] );
}


function host_form_access() {
  global $wpdb;
  $current_user = wp_get_current_user();
  $access = get_the_author_meta( 'host_form', $current_user->ID);
  if ($access) {
    $results = $wpdb->get_row( "SELECT * FROM pbz_frm_forms WHERE id = $access ", OBJECT );
    
    if (isset($results)) {
      // get field IDs for meta
      $email_id = getFieldIDFromFormidableForm($access, 'Email Address');
      $comment = getFieldIDFromFormidableForm($access, 'Comments');
      $is_attending = getFieldIDFromFormidableForm($access, 'Attending');
      if (!$is_attending || $is_attending == '') {  $is_attending = 'unassigned'; }
      $number = getFieldIDFromFormidableForm($access, 'How many people are you bringing to the blitz?');
      $output = '<h2>'.$results->name.'</h2>';
      
      $output .= '<div class="row stats">';
      $output .= '<div class="grid one-fourth"><span class="vol-stats">Unassigned: <span class="vol-num show-unassigned">0</span></span></div>';
      $output .= '<div class="grid one-fourth"><span class="vol-stats">Attending: <span class="vol-num show-attending">0</span></span></div>';
      $output .= '<div class="grid one-fourth"><span class="vol-stats">Waiting List: <span class="vol-num show-waitinglist">0</span></span></div>';
      $output.= '<div class="grid one-fourth last"><span class="vol-stats">Not Attending: <span class="vol-num show-notattending">0</span></span></div></div>';
      $output .= do_shortcode('[hr]');
      // $entries = FrmEntry::getAll( array( 'it.form_id' => $access ), true );
      $my_entries = FrmEntry::getAll( array( 'form_id' => $access ) );
      $total = count($my_entries);
      $i = 0;
      foreach ($my_entries as $current_form_entry) {
        $my_entry = FrmEntry::getOne($current_form_entry->id, true);
        // print_r($my_entry);
        $attending_class = strtolower( isset($my_entry->metas[$is_attending]) ? $my_entry->metas[$is_attending] : 'unassigned' );
  
          // print_r($my_entry);  
          if ( !$i || ($i % 4 == 0)) {
            $output .= '<div class="row bookings">';
          }
          $output .= '<div class="'.$attending_class.' grid one-fourth';
          if ( ($i==$total-1) || ($i % 4 == 3)) {
            $output .= ' last';
          }
          $output .= '">';
          $output .= '<div class="record">';
          $output .= '<strong>' . $my_entry->name . '</strong><br/>';
	  $mynum = ($my_entry->metas[$number] >= 1) ? $my_entry->metas[$number] : 1;
          $output .= '<div class="num">' . $mynum . '</div>';
          $output .= '<a href="mailto:' . $my_entry->metas[$email_id] . '">Email</a><br/>';
          if (isset($my_entry->metas[$comment])) {
            $output .= '<em>' . $my_entry->metas[$comment] . '</em><br/>';
          }

          $output .= '<select id="status_'.$my_entry->id.'" name="status" data-num="'.$myNum.'" data-member="'.$my_entry->id.'" data-field="'.$is_attending.'" data-form="'.$access.'">';
          $output .= '<option value="">Change Status</option>';
          $output .= '<option value="Yes">Attending</option>';
          $output .= '<option value="Waiting-List">Waiting List</option>';
          $output .= '<option value="No">Not Attending</option>';
          $output .= '</select>';
          $output .= '</div>'; // end record
          $output .= '</div>'; // end grid
          if ( ($i==$total-1) || ($i % 4 == 3)) {
            $output .= '</div>'; // end row bookings
          }
          
        $i++;
      }
      
    } else {
      $output = '<p>There are no forms available for you - please check with the Collective.</p>';
    }

      return $output;
    }
}
add_shortcode( 'host_access', 'host_form_access' );

function pbz_changeVolStatus() {

    $form_fields = array('form_id', 'field_id', 'member_id', 'status');

    foreach ($form_fields as $fields) {
      $data[$fields] = $_POST[$fields];
    }

    global $wpdb, $frmdb;

     //See if this user already has an entry in second form
     $entry_id = $wpdb->get_var("Select id from $frmdb->entry_metas where field_id='" . $data['field_id'] . "' and item_id=". $data['member_id']);
     if ( $entry_id ) {
         //update entry
         $success = $wpdb->update( 
                    $frmdb->entry_metas, 
                    array('meta_value' => $data['status']), 
                    array('item_id' => $data['member_id'],
                      'field_id' => $data['field_id'],
                      )
                  );
     } else {
      $success= $wpdb->insert( 
          $frmdb->entry_metas,
          array( 
            'meta_value' => $data['status'],
            'field_id' => $data['field_id'],
            'item_id' => $data['member_id'],
          ), 
          array( 
            '%s', 
            '%d', 
            '%d'
          ) 
        );
     }
    
    $output['success'] = true;
    $output['dbsuccess'] = $success;
    $output['last_query'] = $wpdb->last_query;
    $output['class'] = strtolower($data['status']);

    echo json_encode($output);

    die();
}

add_action('wp_ajax_pbz_changeVolStatus', 'pbz_changeVolStatus');
add_action('wp_ajax_nopriv_pbz_changeVolStatus', 'pbz_changeVolStatus');

function get_hostpage() {
  return 4217;
}

function showEmailsByUser() {
  global $frmdb, $wpdb;
	$user_id = get_current_user_id();
  $list = get_user_meta( $user_id, 'host_form');
  $entries = $wpdb->get_results("Select id, name, updated_at from $frmdb->entries where form_id='59' and user_id=". $user_id);

  $sent_id = 556; // this is the SENT field

  $output = '';

  if (count($entries)) {
     $output .= '<table width="80%">';
     $output .= '<tr>';
     $output .= '<th>Subject Line</th>';
     $output .= '<th>&nbsp;</th>';
     $output .= '<th>&nbsp;</th>';
     $output .= '<th>Date Written</th>';
     $output .= '<th>&nbsp;</th>';
     $output .= '</tr>';
     foreach ($entries as $entry) {

        $my_entry = FrmEntry::getOne($entry->id, true);
        $sent_data = $my_entry->metas[$sent_id];

        $output .= '<tr>';
        $output .= '<td>'.$entry->name.'</td>';
        $output .= '<td><a href="'.get_stylesheet_directory_uri().'/inc/email-review.php?id='.$entry->id.'" target="_blank">Preview</a></td>';
        $output .= '<td>';
        $output .= do_shortcode('[frm-entry-edit-link form_id=59 id='.$entry->id.' label="Edit" page_id=7063]');
        $output .= '</td>';
        $output .= '<td>'.$entry->updated_at.'</td>';
        if (isset($sent_data) && $sent_data != '') {
          $output .= '<td>Sent</td>';
        } else {
          $output .= '<td class="send-container"><a href="#" data-id="'.$entry->id.'">Send</a></td>';
        }
        $output .= '</tr>';
     }
     $output .= '</table>';
   }
  return $output;
}
add_shortcode( 'host_emails', 'showEmailsByUser' );

function pbz_handleSendToVols() {

  $output['success'] = false;

  $preview_id = $_POST['form_id'];

  $current_user = wp_get_current_user();
  $form_id = get_the_author_meta( 'host_form', $current_user->ID );
  $blitz_id = get_the_author_meta( 'host_blitz', $current_user->ID );

  $output['form_id'] = $form_id;
  $output['blitz_id'] = $blitz_id;
  $output['preview_id'] = $preview_id;
  $output['emails'] = '';

  if (isset($form_id) && isset($blitz_id) ) {

    $content_id = getFieldIDFromFormidableForm(59, 'Email Message');
    $my_entry = FrmEntry::getOne($preview_id, true);

    $subject_id = getFieldIDFromFormidableForm(59, 'Subject Line');
    $subject = $my_entry->metas[$subject];    
  
    $blitz_blurb = nl2br( $my_entry->metas[$content_id] );

    $msg = compileEmailToVolunteer($blitz_id, $blitz_blurb);
  }
  $output['subject'] = $subject;

  $recipients = getEmailsFromFormidableForm($form_id);
    foreach ($recipients as $rec) {
        $to = $rec;
        $output['emails'] .= $to . ' ';
        $output['success'] = true;
        //$sent = wp_mail($to, $subject, $msg, $headers);
        //$_POST['acf'][$send_notes] .= sendRecord($subject, $sent, $to) . $prev_sends;  
    }
    echo json_encode($output);
    die();
}

add_action( 'wp_ajax_pbz_handleSendToVols', 'pbz_handleSendToVols' );  
add_action( 'wp_ajax_nopriv_pbz_handleSendToVols', 'pbz_handleSendToVols' );

