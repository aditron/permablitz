<p>
<label><?php _e( 'Notification URL', 'frmapi' ); ?> <span class="frm_required">*</span></label>
<a class="frmapi_test_connection button-secondary alignright" style="margin-bottom:4px;margin-left:5px;"><?php _e( 'Test Connection', 'frmapi' ) ?></a>
<span class="spinner"></span>
<span class="frmapi_test_resp frm_required alignright"></span>
<br/>
<input type="text" name="<?php echo esc_attr( $action_control->get_field_name('url') ) ?>" value="<?php echo esc_attr( $form_action->post_content['url'] ); ?>" class="widefat" />
<span class="howto"><?php _e('Notify this URL when the hook selected above is triggered.', 'frmapi') ?></span>
</p>

<p>
<label><?php _e( 'Handshake Key', 'frmapi' ); ?> <span class="frm_help frm_icon_font frm_tooltip_icon" title="<?php esc_attr_e( 'This key will be provided by the service you are connecting to if it is required.', 'frmapi' ) ?>" ></span></label><br/>
<input type="text" name="<?php echo esc_attr( $action_control->get_field_name('api_key') ) ?>" value="<?php echo esc_attr( $form_action->post_content['api_key'] ); ?>" class="widefat" />
</p>

<p>
<label><?php _e('Data Format', 'frmapi'); ?></label>
<a class="frmapi_insert_default_json button-secondary alignright" style="margin-bottom:4px;"><?php _e( 'Insert Default', 'frmapi' ) ?></a><br/>
<textarea name="<?php echo esc_attr( $action_control->get_field_name('data_format') ) ?>" class="frm_not_email_message large-text" rows="5"><?php echo esc_html( $form_action->post_content['data_format'] ); ?></textarea>
<span class="howto"><?php _e( 'Leave blank for the default format.', 'frmapi' ) ?></span>
</p>