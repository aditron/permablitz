<?php

class FrmAPIAction extends FrmFormAction {

	function __construct() {
		$action_ops = array(
			'classes'   => 'frm_feed_icon frm_icon_font',
			'limit'     => 99,
			'active'    => true,
			'priority'  => 25,
			'event'     => array( 'create', 'update', 'delete' ),
		);

		$this->FrmFormAction( 'api', __( 'Send API data', 'frmapi' ), $action_ops );
	}

	function form( $form_action, $args = array() ) {
		extract( $args );
		$action_control = $this;
	    
		include( FrmAPIAppController::path() . '/views/action-settings/options.php' );
		include_once( FrmAPIAppController::path() . '/views/action-settings/_action_scripts.php' );
	}
	
	function get_defaults() {
		return array(
			'url'         => '',
			'api_key'     => '',
			'data_format' => '',
		);
	}
}
