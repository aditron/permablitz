jQuery(document).ready(function($) {
 
    // Add default 'Select one'
    $( '#acf-field-email_field' ).prepend( $('<option></option>').val('0').html('Select Field').attr({ selected: 'selected', disabled: 'disabled'}) );
 
    /**
     * Get country option on select menu change
     *
     */
    $( '#acf-field-email_field' ).change(function () {
 
        var selected_field = ''; // Selected value
 
        // Get selected value
        $( '#acf-field-email_field option:selected' ).each(function() {
            selected_field += $( this ).text();
        });
 
    }).change();
});