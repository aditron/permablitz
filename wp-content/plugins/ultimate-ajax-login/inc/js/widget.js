/* 
 * Copyright (C) 2014 Samer Bechara <sam@thoughtengineer.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


jQuery(document).ready(function($) {
    
    // Detect form submission
    $("[id^='ual_form_']").on("submit",function ( event ) {                

        // Prevent form from being submitted
        event.preventDefault();
        
        // Get form ID
        var form_id = $("[name='form_id']", this).val();                
        
        // Block ajax interface
        $('#ual_div_' + form_id).block({ message: null }); 
        
        // Send POST request via AJAX
        jQuery.post(ajaxurl, {

            action:     'ual_ajax_login',
            data:       $(this).serialize()
           }, function (response) {

                // Unblock UI
                $('#ual_div_' + form_id).unblock(); 
                
               // Parse JSON response
               result = $.parseJSON(response);

               // User has logged in, reload page
               if(result.logged_in === true){
                   
                   // Check if redirect URL is set
                   if (result.hasOwnProperty('redirect')){
                       
                       // Redirect user to set URL
                       $(location).attr('href', result.redirect);
                   }
                   
                   // No URL is set, reload page
                   else{
                        location.reload();    
                   }
                   
               }
               
               // Invalid login, display error message
               else {
                   // Show error on regular form
                   $("#ual_error_" + form_id).html(result.error);     
                   
                   // Show error on dialog boxes
                   $("#ual_error_"+form_id).html(result.error);                   
                   
                  // Show forgot password form on click
                    jQuery("#ual_error_" + form_id + " a").on("click", function( event) {
                        
                        // Do nothing for custom errors (If set for custom errors, any link that is clicked will display the forgot password form)
                        if(result.custom_error === true)
                            return true;
                        
                        event.preventDefault();
                        
                        $("#ual_forgot_form_" + form_id).show('slow'); 
                        
                        return false;
                    });
                    
                    // Cancel button in form is clicked
                    $('#ual_forgot_form_' + form_id + ' .ual_forgot_form_cancel').on("click", function(event) {
                        $(this).parents("[id^='ual_forgot_form_']").hide('slow');   
                        return false;
                    });                    
               }

               
           });     
           
        
    }); 
    
    
    // Forgot password form has been submitted
    $("[id^='ual_forgot_form_']").on("submit",function ( event ) {  
        
        // Prevent form from being submitted
        event.preventDefault();

        // Get form ID
        var form_id = $("[name='form_id']", this).val();         
        
        // Block ajax interface
        $('#ual_div_' + form_id).block({ message: null }); 
        
        // Send POST request via AJAX
        jQuery.post(ajaxurl, {

            action:     'ual_ajax_forgot_pw',
            data:       $(this).serialize()
           }, function (response) {

                // Unblock UI
                $('#ual_div_' + form_id).unblock();
                
            // Show error on dialog boxes
                $("#ual_forgot_error_"+form_id).html(response);                                           
               
           });  
        
    });   
    
});