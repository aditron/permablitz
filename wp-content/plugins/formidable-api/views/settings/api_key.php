<table class="form-table">
    <tr class="form-field">
        <td width="200px"><label><?php _e('API Key', 'formidable') ?></label></td>
    	<td>
            <input type="text" class="frm_select_box frm_long_input" value="<?php echo esc_attr($api_key) ?>" style="background:transparent;border:none;text-align:left;box-shadow:none;"/>
    	</td>
    </tr>
    <tr>
        <td colspan="2">
            <?php if ( ! class_exists('WP_REST_Posts_Controller') ){ ?>
                You are missing the <a href="https://wordpress.org/plugins/rest-api/">JSON Rest Api</a> plugin.
            <?php } ?>
        </td>
    </tr>
    
</table>

