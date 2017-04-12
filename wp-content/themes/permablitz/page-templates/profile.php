<?php
/**
 * Template Name: User Profile
 *
 * Allow users to update their profiles from Frontend.
 *
 */

$show_password = false;
$show_email = false;

/* Get user info. */
global $current_user, $wp_roles;
//get_currentuserinfo(); //deprecated since 3.1

$designers_guide_tags = get_the_author_meta( 'designers_guide', $current_user->ID );
$facilitators_guide_tags = get_the_author_meta( 'facilitators_guide', $current_user->ID );

/* Load the registration file. */
//require_once( ABSPATH . WPINC . '/registration.php' ); //deprecated since 3.1
$error = array();    
/* If profile was saved, update profile. */
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) && $_POST['action'] == 'update-user' ) {

    /* Update user password. */
    // if ( !empty($_POST['pass1'] ) && !empty( $_POST['pass2'] ) ) {
    //     if ( $_POST['pass1'] == $_POST['pass2'] )
    //         wp_update_user( array( 'ID' => $current_user->ID, 'user_pass' => esc_attr( $_POST['pass1'] ) ) );
    //     else
    //         $error[] = __('The passwords you entered do not match.  Your password was not updated.', 'profile');
    // }

    /* Update user information. */
    if ( !empty( $_POST['url'] ) )
        wp_update_user( array( 'ID' => $current_user->ID, 'user_url' => esc_url( $_POST['url'] ) ) );
    // if ( !empty( $_POST['email'] ) ){
    //     if (!is_email(esc_attr( $_POST['email'] )))
    //         $error[] = __('The Email you entered is not valid.  please try again.', 'profile');
    //     elseif(email_exists(esc_attr( $_POST['email'] )) != $current_user->id )
    //         $error[] = __('This email is already used by another user.  try a different one.', 'profile');
    //     else{
    //         wp_update_user( array ('ID' => $current_user->ID, 'user_email' => esc_attr( $_POST['email'] )));
    //     }
    // }

    if ( !empty( $_POST['first-name'] ) )
        update_user_meta( $current_user->ID, 'first_name', esc_attr( $_POST['first-name'] ) );
    if ( !empty( $_POST['last-name'] ) )
        update_user_meta($current_user->ID, 'last_name', esc_attr( $_POST['last-name'] ) );
    if ( !empty( $_POST['description'] ) )
        update_user_meta( $current_user->ID, 'description', esc_attr( $_POST['description'] ) );



	if ( !empty( $_POST['designers_guide'] ) )
        update_user_meta( $current_user->ID, 'designers_guide', esc_attr( $_POST['designers_guide'] ) );

	if ( !empty( $_POST['facilitators_guide'] ) )
        update_user_meta( $current_user->ID, 'facilitators_guide', esc_attr( $_POST['facilitators_guide'] ) );
    
    /* Redirect so the page will show updated info.*/
  /*I am not Author of this Code- i dont know why but it worked for me after changing below line to if ( count($error) == 0 ){ */
    if ( count($error) == 0 ) {
        //action hook for plugins and extra fields saving
        do_action('edit_user_profile_update', $current_user->ID);
        wp_redirect( get_permalink().'?updated=true' );
        exit;
    }
}
?>
<?php get_header(); ?>

<section class="content">
	
	<?php get_template_part('inc/page-title'); ?>
	
	<div class="pad group">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>">
    <div class="entry themeform">
            <?php the_content(); ?>
            <?php if ( !is_user_logged_in() ) : ?>
                    <p class="warning">
                        <?php _e('You must be logged in to edit your profile.', 'profile'); ?>
                    </p><!-- .warning -->
            <?php else : ?>
                <?php if ( count($error) > 0 ) echo '<p class="error">' . implode("<br />", $error) . '</p>'; ?>
                <?php if ( isset($_GET['updated']) && $_GET['updated'] == 'true' ) : ?> <p class="updated">Your profile has been updated.</p> <?php endif; ?>
                <div class="frm_forms  with_frm_style frm_style_formidable-style">
                <form method="post" id="adduser" action="<?php the_permalink(); ?>">
                <div class="frm_form_fields ">
                    <div class="form-username frm_form_field form-field  frm_top_container">
                        <label for="first-name"><?php _e('First Name', 'profile'); ?></label>
                        <input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" />
                    </div><!-- .form-username -->
                    <div class="form-username frm_form_field form-field  frm_top_container">
                        <label for="last-name"><?php _e('Last Name', 'profile'); ?></label>
                        <input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" />
                    </div><!-- .form-username -->
                    <?php if ($show_email) { ?>
                    <div class="form-email frm_form_field form-field  frm_top_container">
                        <label for="email"><?php _e('E-mail *', 'profile'); ?></label>
                        <input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" />
                    </div><!-- .form-email -->
                    <?php } ?>
                    <?php if ($show_password) { ?>
                    <div class="form-password frm_form_field form-field  frm_top_container">
                        <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
                        <input class="text-input" name="pass1" type="password" id="pass1" />
                    </div><!-- .form-password -->
                    <div class="form-password frm_form_field form-field  frm_top_container">
                        <label for="pass2"><?php _e('Repeat Password *', 'profile'); ?></label>
                        <input class="text-input" name="pass2" type="password" id="pass2" />
                    </div><!-- .form-password -->
                    <?php } ?>
                    <div class="form-textarea frm_form_field form-field  frm_top_container">
                        <label for="description"><?php _e('Biographical Information', 'profile') ?></label>
                        <textarea name="description" id="description" rows="12" cols="50"><?php the_author_meta( 'description', $current_user->ID ); ?></textarea>
                    </div><!-- .form-textarea -->

                    <div class="form-textarea frm_form_field form-field  frm_top_container">
                    	<label for="designers_guide">
                <input
                    id="designers_guide"
                    name="designers_guide"
                    type="checkbox"
                    value="1"
                    <?php if ( $designers_guide_tags ) echo ' checked="checked"'; ?> />
                I have read the Permablitz Designers Guide
            </label>
            <div class="frm_description">
                    		You can read the <a href="https://www.dropbox.com/s/ws18zet84awvpd9/PermablitzDesignersGuide.pdf?dl=0" target="_blank">Designers' Guide here</a>!
                   </div>
                    </div>

                    <div class="form-textarea frm_form_field form-field  frm_top_container">
                    	<label for="facilitators_guide">
                <input
                    id="facilitators_guide"
                    name="facilitators_guide"
                    type="checkbox"
                    value="1"
                    <?php if ( $facilitators_guide_tags ) echo ' checked="checked"'; ?> />
                I have read the Permablitz Facilitators Guide
            </label>
            <div class="frm_description">
                    		You can read the <a href="https://www.dropbox.com/s/3c5ei8hlm3kergy/FailitatorsGuide.pdf?dl=0" target="_blank">Facilitators' Guide here</a>!
                   </div>
                    </div>

                    <?php 
                        //action hook for plugin and extra fields
                        // do_action('edit_user_profile',$current_user); 
                    ?>
                    <div class="form-submit">
                        <?php echo isset($referer) ? $referer : ''; ?>
                        <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update', 'profile'); ?>" />
                        <?php wp_nonce_field( 'update-user' ) ?>
                        <input name="action" type="hidden" id="action" value="update-user" />
                    </div><!-- .form-submit -->

                    </div>
                </form><!-- #adduser -->
                </div>
            <?php endif; ?>
                </div>
    </article><!-- .hentry .post -->
    <?php endwhile; ?>
<?php else: ?>
    <p class="no-data">
        <?php _e('Sorry, no page matched your criteria.', 'profile'); ?>
    </p><!-- .no-data -->
<?php endif; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>