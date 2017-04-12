<?php

function guild_member_login_text() {
  return "<p>These pages are restricted to the Permablitz Designers Guild.</p><p><a href='".wp_login_url( get_permalink() )."'>Click here</a> to login.</p><p> If you are a member of the Guild and don't have a password, just use the Lost Password tool below.</p><p>If you've already logged in and it's still not showing correctly, please try a <a href='https://wiki.scratch.mit.edu/wiki/Help:Hard_Refresh' target='_blank'>hard-refresh</a>.</p>";
}

// Ihave read the Designers Guide

function guild_members_fields( $user ) {
    // get product categories
    $designers_guide_tags = get_the_author_meta( 'designers_guide', $user->ID );
    $facilitators_guide_tags = get_the_author_meta( 'facilitators_guide', $user->ID );
    ?>
    <table class="form-table">
        <tr>
            <th>Permablitz Guides:</th>
            <td>
            <p><label for="designers_guide">
                <input
                    id="designers_guide"
                    name="designers_guide"
                    type="checkbox"
                    value="1"
                    <?php if ( $designers_guide_tags ) echo ' checked="checked"'; ?> />
                I have read the Permablitz Designers Guide
            </label></p> 
            <p><label for="facilitators_guide">
                <input
                    id="facilitators_guide"
                    name="facilitators_guide"
                    type="checkbox"
                    value="1"
                    <?php if ( $facilitators_guide_tags ) echo ' checked="checked"'; ?> />
                I have read the Permablitz Facilitators Guide
            </label></p>           
              </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'guild_members_fields' );
add_action( 'edit_user_profile', 'guild_members_fields' );


function guild_members_fields_save( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
    update_user_meta( $user_id, 'designers_guide', $_POST['designers_guide'] );
    update_user_meta( $user_id, 'facilitators_guide', $_POST['facilitators_guide'] );
}
add_action( 'personal_options_update', 'guild_members_fields_save' );
add_action( 'edit_user_profile_update', 'guild_members_fields_save' );



add_action('frm_form_classes', 'guildform_classes');
function guildform_classes($form){
if($form->id == 14){
  $designers_guide = get_user_meta( get_current_user_id(), 'designers_guide', true );
       if ( $designers_guide ) {
            echo ' hide_designer_checkbox';
       }
   }
}

add_filter('frm_setup_new_fields_vars', 'frm_set_checked', 10, 2);
function frm_set_checked($values, $field){


if($field->id == 418){
$designers_guide = get_user_meta( get_current_user_id(), 'designers_guide', true );
       if ( $designers_guide ) {

     $values['value'] = "Yes, I've read the Designer's Guide";
     }
   }
   return $values;
}

add_action('frm_after_create_entry', 'updateDesignersGuideOnSubmission', 30, 2);
function updateDesignersGuideOnSubmission( $entry_id, $form_id ) {
 if($form_id == 14){
   $entry = FrmEntry::getOne($entry_id);
   if ( ! $entry->user_id ) {
       return; //don't continue if no user
   }

   update_user_meta( $entry->user_id, 'designers_guide', 1 );
 }
}