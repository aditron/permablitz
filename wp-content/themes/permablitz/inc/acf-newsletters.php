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
			'instructions' => 'Make sure you do a test send first',
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
	'title' => 'Newsletters: Guild Design Requests',
	'fields' => array (
		array (
			'key' => 'field_58eefdb0b07ba',
			'label' => 'Subject',
			'name' => 'subject',
			'type' => 'text',
			'instructions' => 'eg Design needed in ***',
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
			'maxlength' => '',
		),
		array (
			'key' => 'field_58eefe37394a8',
			'label' => 'Hero Image',
			'name' => 'hero_image',
			'type' => 'image',
			'instructions' => 'This will be placed at the top of the newsletter. You\'ll need to have an image at least 590x300px in size.',
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
				'Send to the Guild' => 'Send to the Guild',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Test email',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array (
			'key' => 'field_58eefdb0b18db',
			'label' => 'Recipients',
			'name' => 'recipients',
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

acf_add_local_field_group(array (
	'key' => 'group_58f82f6b89a36',
	'title' => 'Newsletters: Newsletter Campaign',
	'fields' => array (
		array (
			'key' => 'field_58f82f6bc2334',
			'label' => 'Newsletter',
			'name' => 'newsletter',
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
				0 => 'post',
			),
			'taxonomy' => array (
				0 => 'category:newsletters',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array (
			'key' => 'field_58f82f6bc26fe',
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
				'Send Newsletter' => 'Send Newsletter',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Test email',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array (
			'key' => 'field_58f82f6bc2b56',
			'label' => 'Recipients',
			'name' => 'recipients',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_58f82f6bc26fe',
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
			'collapsed' => 'field_58f82f6c36cb8',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Recipient',
			'sub_fields' => array (
				array (
					'key' => 'field_58f82f6c36cb8',
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
					'default_value' => 'adrian.ohagan@gmail.com',
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
				'value' => 'newsletter_category:newsletter',
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
	'key' => 'group_5906d9a6d438a',
	'title' => 'Newsletters: Blitz Host Info Emails',
	'fields' => array (
		array (
			'key' => 'field_5906da0aa6af3',
			'label' => 'Subject Line',
			'name' => 'subject_line',
			'type' => 'text',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Hooray - your blitz is finally happening!! But there\'s still a few things that you need to know...',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array (
			'key' => 'field_5906d9a73bd1e',
			'label' => 'Blitz to reference',
			'name' => 'blitz_to_reference',
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
			'key' => 'field_5906d9a73c0db',
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
			'default_value' => 'Your blitz is finally happening!! But there\'s still a few things that you need to know...',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => 75,
		),
		array (
			'key' => 'field_5906db46b4f9d',
			'label' => 'Intro Text',
			'name' => 'intro_text',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
		array (
			'key' => 'field_5906dd4de5bed',
			'label' => 'Send Type',
			'name' => 'send_type',
			'type' => 'radio',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'choices' => array (
				'Test email' => 'Test email',
				'Final recipient' => 'Final recipient',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
		),
		array (
			'key' => 'field_5906d9a73c699',
			'label' => 'Recipients',
			'name' => 'recipients',
			'type' => 'repeater',
			'instructions' => 'Remember, it\'s always a good idea to send a test email first!',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => 'field_5906d9a7ac894',
			'min' => 0,
			'max' => 0,
			'layout' => 'row',
			'button_label' => 'Add Email Address',
			'sub_fields' => array (
				array (
					'key' => 'field_5906d9a7ac894',
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
				'value' => 'newsletter_category:blitz-host-info',
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