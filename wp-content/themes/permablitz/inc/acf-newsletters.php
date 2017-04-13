<?php

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_58eeb29f37bb5',
	'title' => 'Newsletters: Blitz Notifications',
	'fields' => array (
		array (
			'key' => 'field_58eeb29fb2018',
			'label' => 'Blitz to promote',
			'name' => 'blitz_to_promote',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'event',
			),
			'taxonomy' => array (
				0 => 'event-categories:upcoming-blitzes',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array (
			'key' => 'field_58eeb29fb2425',
			'label' => 'Preview Text',
			'name' => 'preview_text',
			'type' => 'text',
			'instructions' => 'This will not be shown in the email body, but is used by a lot of email clients to provide a preview of the email\'s content. Limited to 75 characters - try to cover the meat of the email\'s content here for better open rates.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => 75,
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_58eeb29fb261d',
			'label' => 'Send Type',
			'name' => 'send_type',
			'type' => 'radio',
			'instructions' => 'Make sure you do a test send first!!',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Test email' => 'Test email',
				'Send to Biz' => 'Send to Biz',
				'Send to AutoBlitz list' => 'Send to AutoBlitz list',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Test email',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array (
			'key' => 'field_58eeb29fb2bf9',
			'label' => 'Recipients',
			'name' => 'recipients',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_58eeb29fb261d',
						'operator' => '==',
						'value' => 'Test email',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Email Address',
			'collapsed' => '',
			'sub_fields' => array (
				array (
					'key' => 'field_58eeb2a079634',
					'label' => 'Email',
					'name' => 'email',
					'type' => 'email',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'newsletter',
			),
			array (
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'newsletter_category:instant-blitz-notification',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => 'Please note that this will not allow you to send info on the same Blitz twice.',
));

acf_add_local_field_group(array (
	'key' => 'group_58eefdb046dba',
	'title' => 'Newsletter: Guild Design Requests',
	'fields' => array (
		array (
			'key' => 'field_58eefdb0b07ba',
			'label' => 'Subject',
			'name' => 'subject',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Design needed in ***',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_58eefe37394a8',
			'label' => 'Hero Image',
			'name' => 'hero_image',
			'type' => 'image',
			'instructions' => 'This will be placed at the top of the newsletter',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => 590,
			'min_height' => 300,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_58eefdb0b0b5f',
			'label' => 'Intro Text',
			'name' => 'intro_text',
			'type' => 'wysiwyg',
			'instructions' => 'If used, this will go beneath the hero image. But you really should use it.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
			'delay' => 0,
		),
		array (
			'key' => 'field_58eefdb0b14fb',
			'label' => 'Send Type',
			'name' => 'guild_send_type',
			'type' => 'radio',
			'instructions' => 'Make sure you do a test send first!!',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Test email' => 'Test email',
				'Send to Signups' => 'Send to Signups',
				'Send to Biz' => 'Send to Biz',
				'Send to the Guild' => 'Send to the Guild',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Test email',
			'layout' => 'vertical',
			'allow_null' => 0,
			'return_format' => 'value',
		),
		array (
			'key' => 'field_58eefdb0b18db',
			'label' => 'Recipients',
			'name' => 'guild_recipients',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_58eefdb0b14fb',
						'operator' => '==',
						'value' => 'Test email',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Email Address',
			'sub_fields' => array (
				array (
					'key' => 'field_58eefdb18586a',
					'label' => 'Email',
					'name' => 'email',
					'type' => 'email',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
					'prepend' => '',
					'append' => '',
				),
			),
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'newsletter',
			),
			array (
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'newsletter_category:guild-design-requests',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => 1,
	'description' => 'Please note that this will not allow you to send info on the same Blitz twice.',
));

endif;