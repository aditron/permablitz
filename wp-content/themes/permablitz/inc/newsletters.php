<?php
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array (
	'key' => 'group_56ac36f481288',
	'title' => 'Newsletter Setup',
	'fields' => array (
		array (
			'key' => 'field_57c5659c61d01',
			'label' => 'Select the month for the events',
			'name' => 'month',
			'type' => 'date_picker',
			'instructions' => 'Used',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'display_format' => 'd/m/Y',
			'return_format' => 'd/m/Y',
			'first_day' => 1,
		),
		array (
			'key' => 'field_57c6f3957eaa5',
			'label' => 'Super Script',
			'name' => 'super_script',
			'type' => 'text',
			'instructions' => 'This is for email clients that allow content preview. Pretty handy! Try to summarise the intro in 100 characters - make it snappy!',
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
			'maxlength' => 100,
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56ac663502802',
			'label' => 'Intro',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_56ac664002803',
			'label' => 'Introduction',
			'name' => 'introduction',
			'type' => 'wysiwyg',
			'instructions' => 'Should include a YouTube Link. To add to your page, use [newsletter_intro]',
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
		),
		array (
			'key' => 'field_56ac385987272',
			'label' => 'Permablitz News',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_56ac36fd8726c',
			'label' => 'Permablitz News',
			'name' => 'permablitz_news',
			'type' => 'repeater',
			'instructions' => 'This may be a Blitz recap, promoting a Guild session, etc. When you\'re done, drop the [permablitz_news] shortcode into the content.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add News Item',
			'sub_fields' => array (
				array (
					'key' => 'field_56ac37298726d',
					'label' => 'Heading',
					'name' => 'heading',
					'type' => 'text',
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
					'maxlength' => '',
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56ac37ae8726f',
					'label' => 'Intro',
					'name' => 'intro',
					'type' => 'wysiwyg',
					'instructions' => 'No images. No formatting. Keep it simple. Just copy and links',
					'required' => 1,
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
				),
				array (
					'key' => 'field_56d2afd621e45',
					'label' => 'Existing Content?',
					'name' => 'existing_content',
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
						'Yes' => 'Yes',
						'No' => 'No',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'horizontal',
				),
				array (
					'key' => 'field_56ac37438726e',
					'label' => 'Page Link',
					'name' => 'page_link',
					'type' => 'post_object',
					'instructions' => 'This will pull through the hero image and the page link.',
					'required' => 1,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56d2afd621e45',
								'operator' => '==',
								'value' => 'Yes',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'post',
						1 => 'event',
						2 => 'page',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
				array (
					'key' => 'field_56ac37f187270',
					'label' => 'Link Text',
					'name' => 'link_text',
					'type' => 'text',
					'instructions' => 'This will be at the end of the content - it will say something super-clever like "Check out all the photos and full recap here!"',
					'required' => 1,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56d2afd621e45',
								'operator' => '==',
								'value' => 'Yes',
							),
						),
					),
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
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56d2b05a21e46',
					'label' => 'News Image',
					'name' => 'news_image',
					'type' => 'image',
					'instructions' => 'For best results, please ensure your image is at least 640x640px',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56d2afd621e45',
								'operator' => '==',
								'value' => 'No',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'email-thumb',
					'library' => 'all',
					'min_width' => 640,
					'min_height' => 640,
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
		),
		array (
			'key' => 'field_56d1fb5226afb',
			'label' => 'Hero of the Month',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_57c568039f5e2',
			'label' => 'Hero of the Month',
			'name' => 'hero_of_the_month',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
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
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array (
			'key' => 'field_56d1fb8226afd',
			'label' => 'Hero Image',
			'name' => 'hero_image',
			'type' => 'image',
			'instructions' => 'If this is not selected, the Featured Image will be used',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'email-thumb',
			'library' => 'all',
			'min_width' => 640,
			'min_height' => 640,
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_56d1fbdc26afe',
			'label' => 'Hero blurb',
			'name' => 'hero_blurb',
			'type' => 'wysiwyg',
			'instructions' => 'If this is not used, the_excerpt() will be used instead.',
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
		),
		array (
			'key' => 'field_56d200198626d',
			'label' => 'Call to action',
			'name' => 'hero_call_to_action',
			'type' => 'wysiwyg',
			'instructions' => 'To link to the newsletter post, add the shortcode [current-page] as the link.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'To read more about this amazing plant, <a href="[current-page]">click here</a>!',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_57c2a587f4e2a',
			'label' => 'Show A Herb For Thought Too?',
			'name' => 'show_a_herb_for_thought_too',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'This will show both Hero of the Month and A Herb for Thought together',
			'default_value' => 0,
		),
		array (
			'key' => 'field_57c56772c1470',
			'label' => 'A Herb for Thought',
			'name' => 'a_herb_for_thought',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_57c2a587f4e2a',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array (
				0 => 'post',
			),
			'taxonomy' => array (
			),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array (
			'key' => 'field_57c2acddf4e2c',
			'label' => 'Herb For Thought blurb',
			'name' => 'herb_for_thought_blurb',
			'type' => 'wysiwyg',
			'instructions' => 'If you leave this blank, the_excerpt() will be used.',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_57c2a587f4e2a',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_57c2ac47f4e2b',
			'label' => 'This month\'s Herb For Thought Image',
			'name' => 'this_months_herb_for_thought_image',
			'type' => 'image',
			'instructions' => 'Leave empty if you\'d prefer to use the existing Featured Image',
			'required' => 0,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_57c2a587f4e2a',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'id',
			'preview_size' => 'thumbnail',
			'library' => 'all',
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_56d218b87e1a1',
			'label' => 'In the Garden',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_56d219407e1a5',
			'label' => 'Gardening Image',
			'name' => 'gardening_image',
			'type' => 'image',
			'instructions' => '',
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
			'min_width' => '',
			'min_height' => '',
			'min_size' => '',
			'max_width' => '',
			'max_height' => '',
			'max_size' => '',
			'mime_types' => '',
		),
		array (
			'key' => 'field_56d218cf7e1a2',
			'label' => 'Above the list',
			'name' => 'above_the_list',
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
			'toolbar' => 'basic',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_56d218fb7e1a3',
			'label' => 'Planting list',
			'name' => 'planting_list',
			'type' => 'textarea',
			'instructions' => 'List for the month - comma separated',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
		array (
			'key' => 'field_56d2192e7e1a4',
			'label' => 'Below the list',
			'name' => 'below_the_list',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Remember: some seeds do better starting off in punnets, some in pots and some in the ground. To get the best from your seedlings be sure to check the best methods first!',
			'tabs' => 'all',
			'toolbar' => 'basic',
			'media_upload' => 0,
		),
		array (
			'key' => 'field_56adc22fbb7e9',
			'label' => 'Bits And Pieces',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_56adc240bb7ea',
			'label' => 'Bits and Pieces',
			'name' => 'bits_and_pieces',
			'type' => 'repeater',
			'instructions' => 'To add to your page, just add the shortcode [bits_and_pieces]',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'collapsed' => '',
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add News Item',
			'sub_fields' => array (
				array (
					'key' => 'field_56adc298bb7ee',
					'label' => 'Existing Content?',
					'name' => 'existing_content',
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
						'Yes' => 'Yes',
						'No' => 'No',
					),
					'other_choice' => 0,
					'save_other_choice' => 0,
					'default_value' => '',
					'layout' => 'horizontal',
				),
				array (
					'key' => 'field_56adc2b1bb7ef',
					'label' => 'Post',
					'name' => 'post',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56adc298bb7ee',
								'operator' => '==',
								'value' => 'Yes',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array (
						0 => 'post',
					),
					'taxonomy' => array (
					),
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'id',
					'ui' => 1,
				),
				array (
					'key' => 'field_56adc251bb7eb',
					'label' => 'Title',
					'name' => 'title',
					'type' => 'text',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56adc298bb7ee',
								'operator' => '==',
								'value' => 'No',
							),
						),
					),
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
					'readonly' => 0,
					'disabled' => 0,
				),
				array (
					'key' => 'field_56adc260bb7ec',
					'label' => 'Content',
					'name' => 'content',
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
					'toolbar' => 'basic',
					'media_upload' => 0,
				),
				array (
					'key' => 'field_56adc280bb7ed',
					'label' => 'Hero Image',
					'name' => 'hero_image',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => array (
						array (
							array (
								'field' => 'field_56adc298bb7ee',
								'operator' => '==',
								'value' => 'No',
							),
						),
					),
					'wrapper' => array (
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'return_format' => 'id',
					'preview_size' => 'email-thumb',
					'library' => 'all',
					'min_width' => '',
					'min_height' => '',
					'min_size' => '',
					'max_width' => '',
					'max_height' => '',
					'max_size' => '',
					'mime_types' => '',
				),
			),
		),
		array (
			'key' => 'field_56d2af6d21e43',
			'label' => 'Sign-off',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array (
			'key' => 'field_56d2af7821e44',
			'label' => 'Sign-off',
			'name' => 'sign-off',
			'type' => 'text',
			'instructions' => 'Keep it simple - just a single line will do.',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'From all at Permablitz Melbourne decentral - may the beet roll on!',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
			array (
				'param' => 'post_taxonomy',
				'operator' => '==',
				'value' => 'category:newsletters',
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
	'description' => '',
));

acf_add_local_field_group(array (
	'key' => 'group_56ad3d539e49b',
	'title' => 'Newsletter Campaign',
	'fields' => array (
		array (
			'key' => 'field_56ad3d53af46b',
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
			'key' => 'field_56ad3d53af843',
			'label' => 'Send Type',
			'name' => 'nl_send_type',
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
				'Send test to Biz' => 'Send test to Biz',
				'Send Newsletter' => 'Send Newsletter',
			),
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => 'Test email',
			'layout' => 'vertical',
		),
		array (
			'key' => 'field_56adaf5017511',
			'label' => 'Recipients',
			'name' => 'nl_recipients',
			'type' => 'repeater',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => array (
				array (
					array (
						'field' => 'field_56ad3d53af843',
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
			'min' => '',
			'max' => '',
			'layout' => 'row',
			'button_label' => 'Add Recipient',
			'sub_fields' => array (
				array (
					'key' => 'field_56adaf7417512',
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
		array (
			'key' => 'field_56ad3d53b001d',
			'label' => 'Notes',
			'name' => 'nl_notes',
			'type' => 'textarea',
			'instructions' => 'No need to fill this in - this will provide feedback on the send success.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 12,
			'new_lines' => 'br',
			'readonly' => 0,
			'disabled' => 0,
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-send-newsletter',
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
	'key' => 'group_58edc2687466b',
	'title' => 'Newsletter Management',
	'fields' => array (
		array (
			'key' => 'field_58edc43075de8',
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
				'Send to Biz' => 'Send to Biz',
				'Send Final' => 'Send Final',
			),
			'allow_null' => 0,
			'other_choice' => 0,
			'save_other_choice' => 0,
			'default_value' => '',
			'layout' => 'vertical',
			'return_format' => 'value',
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
				'param' => 'post_status',
				'operator' => '!=',
				'value' => 'publish',
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
	'description' => '',
));


endif;

if( function_exists('acf_add_options_sub_page') ) {
  // add parent
  $parent = acf_add_options_sub_page(array(
    'page_title'  => 'Send Newsletter',
    'menu_title'  => 'Send Newsletter',
    'parent_slug'    => 'intant-blitz-notification'
  ));
}

/**

	SEND COMPONENT

*/

function sendNewsletter($post_id) {

  // bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;   
    }



    if (isset($_POST['acf']['field_56ad3d53af46b'])) {

      $fields = $_POST['acf'];
      
      if (!get_post_meta( $post_id, 'notification_sent' ) ) {

          $newsletter_id = $fields['field_56ad3d53af46b'];

           $msg = get_post_meta($newsletter_id, 'newsletter', true);
          if(!$msg) {
			$msg = saveNewsletter( $newsletter_id );          	
          }

          $hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $newsletter_id) , 'email-hero' );
          
          //$msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
          
          $subject = cleanMarkupForEDM( get_the_title($newsletter_id) );
          $subject = str_replace('&#8211;', '-', $subject);
          $subject = str_replace('&#8217;', "'", $subject);

          $send_type = $_POST['acf']['field_56ad3d53af843'];

        $send_notes = 'field_56ad3d53b001d';
  
        $prev_sends = $_POST['acf'][$send_notes];
        
          $headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
          $headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

          switch ($send_type) {
            default:
            case 'Test email':
                $recipients = $_POST['acf']['field_56adaf5017511'];
                foreach ($recipients as $rec) {
                    $to = $rec['field_56adaf7417512'];
                	$subject .= ' | TEST #' . mt_rand(1000, 10000);
                    $sent = wp_mail($to, $subject, $msg, $headers);
                  $_POST['acf'][$send_notes] = sendRecord($subject, $sent, $to) . $prev_sends;  
                }
            break;
            case 'Send test to Biz':
                $to = 'team@lists.permablitz.net';
                $subject .= ' | TEST #' . mt_rand(1000, 10000);
                $sent = wp_mail($to, $subject, $msg, $headers);
              $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Biz List ') . $prev_sends;  
            break;
            case 'Send Newsletter':
              $to = 'melb_blitzes@lists.permablitz.net';
              $sent = wp_mail($to, $subject, $msg, $headers);
              $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Melb Newsletter List ') . $prev_sends;  
              $to = 'permablitz@gmail.com';
              wp_mail($to, $subject, $msg, $headers);
              if ($sent) {
                add_post_meta($newsletter_id, 'notification_sent', time() );
              }
            break;
          }


        }
    
    }

}
add_action('acf/save_post', 'sendNewsletter', 1);

function newsletter_Pbz_news($atts) {

	extract( shortcode_atts( array(
			'edm'		=> false,
			'post_id'	=> 0

		), $atts) );

	if (!$post_id) {
		global $post;
		$post_id = $post->ID;
	}

	$news_items = get_field( 'permablitz_news', $post_id);

	if($edm) {
		$output = cleanMarkupForEDM( pbz_edm_news($news_items), true, 'News and Updates' );
	} else {
		$output = '<h2>Permablitz News</h2>';

		foreach ($news_items as $news) {
			if ($news['existing_content'] == 'Yes') {
				$img = get_post_thumbnail_id( $news['page_link'] );				
			} else {
				$img = $news['news_image'];
				$news['link_text'] = '';
			}
			
			$thumb = wp_get_attachment_image( $img, 'large', false, array( 'class' => 'aligncenter' ) );
			
			$img_meta = wp_get_attachment($img);
			if ($img_meta['caption']){
				$thumb = '[caption id="attachment_'.$img.'" align="aligncenter" width="720"]' . $thumb . $img_meta['caption'] . '[/caption]';
			}
			$output .= '<h3>' . $news['heading'] . '</h3>';
			$output .= do_shortcode($thumb);
			$output .= $news['intro'];
			if ($news['link_text']) {
						$output .= '<p><a href="' . get_permalink( $news['page_link'] ) . '">' . $news['link_text'] . '</a></p>';
	}
			$output .= do_shortcode('[hr]');
		}
	}

	return $output;
}

add_shortcode( 'permablitz_news', 'newsletter_Pbz_news' );

function newsletter_bits_and_pieces($atts) {

	extract( shortcode_atts( array(
			'edm'		=> false,
			'post_id'	=> 0

		), $atts) );

	if (!$post_id) {
		global $post;
		$post_id = $post->ID;
	}

	$news_items = get_field( 'bits_and_pieces', $post_id);

	$bits = array();

	foreach ($news_items as $item ) {
		if ($item['existing_content'] == 'No') {
			$bits[] = array(
					'heading' => $item['title'],
					'page_link' => get_permalink($post_id),
					'intro' => cleanMarkupForEDM( $item['content'] ),
					'existing_content' => $item['existing_content'],
					'link_text' => isset($item['link_text']) ? $item['link_text'] : '',
					'image' => isset($item['hero_image']) ? $item['hero_image'] : ''
					);
		} else {
			$bits[] = array(
					'heading' => get_the_title(  $item['post']),
					'page_link' => $item['post'],
					'intro' => cleanMarkupForEDM( $item['content'] ),
					'existing_content' => $item['existing_content'],
					'link_text' => isset($item['link_text']) ? $item['link_text'] : '',
					'image' => isset($item['news_image']) ? $item['news_image'] : ''
					);
		}
	}


	if($edm) {
		$output = pbz_edm_news($bits, false, 'Beets and Pieces');
	} else {

	}

	return $output;
}

add_shortcode( 'bits_and_pieces', 'newsletter_bits_and_pieces');

function pbz_edm_news($news_items, $pbz_news=true, $title='News and Updates') {

	if ($pbz_news) {
		$color1 = '#3b8dbd';
	} else {
		$color1 = '#82b965';
	}
	$color2 = '#3c3c3c';

	$output = '<tr>
                        <td bgcolor="#ffffff" style="padding:20px 50px 20px 50px">
                            <table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; font-weight:normal; color:#3c3c3c; background-color:#ffffff;" width="100%">
                            <tr>
                                    <td style="font-size:20px; line-height:22px; color:'.$color1.'; font-weight:bold; ">'.$title.'
                                     </td>
                                </tr>';
	
	$output_orig = '<tr>
                	<td width="650" height="25" class="emailWidthAuto">
                    	<table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#626262; background-color:#ffffff;">
                        	<tbody>' . pbz_emptyRow();
		if (!$pbz_news) {
				$output_orig .= '<tr>
                                <td width="30">&nbsp;</td>
                                <td style="font-size:28px; line-height:28px; font-weight:bold; color:#506125;">Bits and Pieces</td>
                                <td width="30">&nbsp;</td>
                            </tr>' . pbz_emptyRow();
			}
	if( is_array($news_items) && count($news_items) >=1 ) {
		$i = 0;
		foreach ($news_items as $news) {

				if ($i % 2 == 1) { $color = $color2; }
				if ($i % 2 == 0) { $color = $color1; }
			
				$i++;
			$intro = $news['intro'];

			if ($news['existing_content'] == 'Yes') {
				$img = get_post_thumbnail_id( $news['page_link'] );
				if (trim($news['link_text']) != "" && trim($news['page_link'])!="") {
		$intro .= '<a style="font-weight:bold; color: #000000" href="' . get_permalink( $news['page_link'] ) . '">' . $news['link_text'] . '</a>';
	}
			} else {
				$img = isset($news['image']) ? $news['image'] : $news['news_image'];
			}
			
			$thumb = wp_get_attachment_image_src( $img, 'email-thumb' );
			$output_orig .= '<tr><td width="30">&nbsp;</td>
                                <td>
                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#626262; background-color:#ffffff;"><tbody><tr><td width="175" valign="top" class="emailFloatLeft">
                                                <table width="175" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#333333; background-color:#ffffff;" class="emailWidthAuto"><tbody><tr><td width="169" style="border:3px solid #4d4032; padding: 0px;" class="emailWidthAuto"><a href="'. get_permalink( $news['page_link'] ).'" style="color: #000000; font-weight:bold"><img width="169" height="125" border="0" class="emailWidthAuto" style="display:block; margin: 0px;" alt="" src="' . $thumb[0] . '"></a></td>
                                                    </tr></tbody></table></td>
                                            <td width="25" height="10" class="emailFloatLeft">&nbsp;</td>
                                            <td valign="top" class="emailFloatLeft">
                                                <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff" align="center" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:'.$color.'; background-color:#ffffff;"><tbody><tr><td style="font-size:22px; line-height:24px; font-weight:bold; color:'.$color.';">' . cleanMarkupForEDM( $news['heading'] ) . '</td>
                                                    </tr><tr><td style="font-size:10px; line-height:10px;">&nbsp;</td>
                                                    </tr><tr><td class="emailFloatLeft" style="font-size:12px; line-height:16px;">' . $intro . '<br><br>
</td>
                                                    </tr></tbody></table></td>
                                        </tr></tbody></table></td>
                                <td width="30">&nbsp;</td>
                            </tr>';
			$output .= '<tr>
                                    <td style="padding:20px 0px 0px 0px;">
                                    	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:'.$color.'" width="100%">
                                			<tbody><tr>
                                                <td width="170" bgcolor="#ffffff" class="emailFloatLeft" valign="top">';
                                                if ($news['existing_content'] == 'Yes') {
                                                    $output .= '<a href="'. get_permalink( $news['page_link'] ).'">';
                                                }
                                                    $output.= '<img width="167" border="0" src="' . $thumb[0] . '" alt="" style="display:block; margin: 0px;" class="emailWidthAuto">';
                                                    if ($news['existing_content'] == 'Yes') {
                                                    $output .= '</a>';
                                                }
                                                $output .= '</td>
                                                <td class="emailFloatLeft" width="25">&nbsp;</td>
                                                <td width="355" bgcolor="#ffffff" class="emailFloatLeft" valign="top">
                                                	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#3c3c3c">
                                                    
                                                    	<tbody><tr>
                                                        	<td style="font-size:16px; line-height:18px; color:'.$color.'; font-weight:bold;">'.cleanMarkupForEDM( $news['heading'] ).'</td>
                                                        </tr>
                                                    	<tr>
                                                        	<td>' . $intro . '</td>
                                                        </tr>
                                                    </tbody></table>
                                                    
                                                </td>
                                			</tr>
										</tbody></table>
                                    </td>
                                </tr>';
	
	}

	// $output .= pbz_emptyRow() . '
 //                            <tr>
 //                                <td width="30" bgcolor="#ededed" style="background-color:#ededed;"></td>
 //                                <td height="6" bgcolor="#ededed" style="background-color:#ededed;"></td>
 //                                <td width="30" bgcolor="#ededed" style="background-color:#ededed;"></td>
 //                            </tr>
                           
 //                        </tbody></table>
 //                    </td>
 //                </tr>';

	$output .= '</table></td></tr>';

	return $output;

	}
	
}

function pbz_emptyRow() {
	return '<tr>
                                <td width="30">&nbsp;</td>
                                <td height="25">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                            </tr>' . "\n";
}

function pbz_greyline() {
	return '<tr>
                    <td height="6" bgcolor="#ededed" style="background-color:#ededed;"></td>
                </tr>' . "\n";
}

function pbz_upcomingBlitzes_parts_top() {
	$output = '<tr>
                	<td bgcolor="#82b965" style="padding:0px 25px 0px 25px">
                    	<table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; font-weight:normal; color:#3c3c3c; background-color#82b965;" width="100%">
                    	<tr>
                                    <td style="font-size:20px; line-height:22px; color:#ffffff; border-top:#a9a9a9 1px solid; padding-top:20px; font-weight:bold; text-align: center;">This month\'s blitzes</td>
                                </tr>
				<tr>
                                    <td style="padding-top:20px;">
                                    	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:14px; font-weight:normal; color:#ffffff; background-color:#82b965;" width="100%">';
	return $output;
}


function pbz_upcomingBlitzes_parts_firstHero($event) {
	$hero = wp_get_attachment_image_src( get_post_thumbnail_id( $event['id']) , 'email-hero' );
	$output = '<tr><td><a href="'.$event['url'].'"><img src="'.$hero[0].'" alt="" style="display:block;" class="emailWidthAuto" width="600" border="0"></a></td></tr><tr>
	<td style="padding: 5px 15px 0 5px; text-align: center;" valign="top">
		<a href="'.$event['url'].'" style="color: #ffffff; font-weight: bold; font-size:13px;text-decoration:none">'.$event['title'].'</a>
		<br>';
		$output .= '<em>'.$event['date'].'</em><br><br>';
		$output .= '</td>
	</tr>';
	if (get_field('booked_out', $event['id'])) {
		//$output .=  '<tr><td>&nbsp;</td></tr>';
		$blurb_for_email = get_field( 'blurb_for_email',$event['id']);
		$blurb_for_email = replacePwithBR( styleForEDM( cleanMarkupForEDM( $blurb_for_email ), "#ffffff" ) );

		$output .= '<tr><td>'.$blurb_for_email.'</td></tr>';
		
	} else {
		$blurb_for_email = get_field( 'blurb_for_email',$event['id']);
		$blurb_for_email = replacePwithBR( styleForEDM( cleanMarkupForEDM( $blurb_for_email ), "#ffffff" ) );

		$output .= '<tr><td>'.$blurb_for_email.'</td></tr>';
		$output .= '<tr><td style="padding:0px 20px 20px 20px; text-align: center" align="center">
		<table width="220" cellspacing="0" cellpadding="0" border="0" style="color:#46629e; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:8px; margin: 0px auto 0px auto">
			<tr>
				<td width="220" align="center" style="font-size:14px; line-height:16px; background-color:#45562f; color:#ffffff;"><a style="display:block; color:#ffffff; text-decoration:none; padding:8px 0;" href="'.$event['url'].'">Book now</a></td>
			</tr>
		</table>
	</td></tr>';
}
$output .= '</table>';

$output .= '</td></tr><tr><td style="padding-top:20px;">
<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:14px; font-weight:normal; color:#ffffff; background-color:#82b965;" width="100%">';

	return $output;
}

function pbz_upcomingBlitzes_parts_bottom() {
	$output .= '<tr>
									<td style="padding:20px 0px 20px 0px; border-top: 1px solid #ffffff; font-size:16px; line-height:18px; text-align: center;color: #ffffff">Do you want to host your own Permablitz? <a href="http://www.permablitz.net/get-blitzed/" style="color: #ffffff; font-weight:bold">Find out how here!</a><br><br>
Or maybe you\'ve just completed a PDC and are itching to use your brand new skills to design the next wave of blitzes? <a href="http://www.permablitz.net/permablitz-designers-wanted/" style="color: #ffffff; font-weight:bold">Join the Designers Guild!</a> 
									</td>
								</tr>';
}

function pbz_upcomingBlitzes() {

	$events = array();

    $i = 0;

    $args = array('category' => 57);

    $EM_Events = EM_Events::get($args);

    foreach ( $EM_Events as $EM_Event ) {
     $event_id = $EM_Event->event_id;
     $post_id = $EM_Event->post_id;

        $date_and_time = $EM_Event->output('#_{l, jS M} at #_EVENTTIMES');

          if ($i == 0) {
                  $img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id) , 'email-thumb' );
                }
                $i++;

                 $events[] = array(
                            'title' => get_the_title($post_id),
                            'id' => $post_id,
                            'url' => get_permalink($post_id),
                            'date' => $date_and_time
                            );
    }

    $event_count = count($events);

    $show_odd = 0;
    $odd_or_even = 1;
    if ($event_count%2 == 1) {
    	$show_odd = 1;
    	$odd_or_even = 0;
    }

   if (count($events) >= 1) {

        $output = pbz_upcomingBlitzes_parts_top();			  
		$i = 0;
		
		foreach($events as $event) {
			$i++;
			if ($show_odd && $i==1) {
				$output .= pbz_upcomingBlitzes_parts_firstHero($event);
			} else {
				
				if ($i%2==$odd_or_even) {
					$output .= '<tr><td width="290" class="emailFloatLeft" valign="top">';
					}
					
				$hero = wp_get_attachment_image_src( get_post_thumbnail_id( $event['id']) , 'thumb-medium' );
                
                $output .= '
                      <table align="left" cellpadding="0" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#ffffff; ">
                          <tr>
                              <td>
                                  <a href="'.$event['url'].'"><img src="'.$hero[0].'" alt="" class="emailWidthAuto" width="290" /></a>
                              </td>
                          </tr>
                          <tr>
                              <td style="padding: 5px 15px 0 5px" valign="top">
                                  <a href="'.$event['url'].'" style="color: #ffffff; font-weight: bold; font-size:13px;text-decoration:none">'.$event['title'].'</a>
                                  <br>';
                $output .= '<em>'.$event['date'].'</em><br><br>';
                $output .= '</td>
                                                    </tr>
                                                    <tr>';
                if (get_field('booked_out', $event['id'])) {
					$output .=  '<td>&nbsp;</td>';
				} else {
					$output .= '<td style="padding:0px 20px 20px 20px;">
                                <table width="220" cellspacing="0" cellpadding="0" border="0" style="color:#46629e; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:8px;">
                                    <tr>
                                        <td width="220" align="center" style="font-size:14px; line-height:16px; background-color:#45562f; color:#ffffff;"><a style="display:block; color:#ffffff; text-decoration:none; padding:8px 0;" href="'.$event['url'].'">Book now</a></td>
                                    </tr>
                                </table>
                            </td>';
				}
              	$output .= '</tr>
              		</table>
                        ';
							
		      	if ($i%2==$odd_or_even) {
					$output .= '</td><td width="26" class="emailFloatLeft">&nbsp;</td><td width="290" class="emailFloatLeft" valign="top">';
					}
				if (count($events) == $i && $i%2==$odd_or_even) {
					$output .= '</td><td width="26" class="emailFloatLeft">&nbsp;</td><td width="290" class="emailFloatLeft" valign="top">';
					}
				if ($i%2==$show_odd) {
					$output .= '</td></tr>';
					}
				}
	
            }
				      
                                      $output .= '                                            
                                    </table>
                        </td>
                      </tr>';
				      
				      $output .= pbz_upcomingBlitzes_parts_bottom();

                    $output .= '
                    </table>
                	</td>
                </tr>';
		return $output;
    } /*else {
      if (count($events) == 1) {

      	foreach($events as $event) {

        $output = pbz_upcomingBlitzes_parts_top();
      	$output .= pbz_upcomingBlitzes_parts_firstHero($event);
      	$output .= pbz_upcomingBlitzes_parts_bottom();
        $output .= '
                    </table>
                	</td>
                </tr>';
            }
      return $output;

      }
    }*/
}

function heroAndHerb($post_id) {

	$data = get_fields($post_id);

	if (!$data['show_a_herb_for_thought_too']) {
		return heroOfTheMonth($data, $post_id);
	} else {

		$hero_id = $data['hero_of_the_month'];
		$hero_img_id = isset($data['hero_image']) && $data['hero_image'] != '' ? $data['hero_image'] : get_post_thumbnail_id($hero_id);
		$hero_image = wp_get_attachment_image_src($hero_img_id, 'email-thumb');
		$hero_title = cleanMarkupForEDM( get_the_title($hero_id) );
		
		$hero_blurb = isset($data['hero_blurb']) ? $data['hero_blurb'] : pbz_get_the_excerpt($hero_id);
		$hero_blurb = styleForEDM( cleanMarkupForEDM( $hero_blurb ), "#ffffff" );
		$hero_blurb = str_replace(array('<p>', '</p>'), '', $hero_blurb);

		$herb_id = $data['a_herb_for_thought'];
		$herb_img_id = isset($data['this_months_herb_for_thought_image']) ? $data['this_months_herb_for_thought_image'] : get_post_thumbnail_id($herb_id);
		$herb_image = wp_get_attachment_image_src($herb_img_id, 'email-thumb');
		$herb_title = cleanMarkupForEDM( get_the_title($herb_id) );
		$herb_blurb = isset($data['herb_for_thought_blurb']) ? $data['herb_for_thought_blurb'] : pbz_get_the_excerpt($herb_id);
		$herb_blurb = styleForEDM( cleanMarkupForEDM( $herb_blurb ) );
		$herb_blurb = str_replace(array('<p>', '</p>'), '', $herb_blurb);
		$output = '<tr>
                		<td style="padding:0 25px;">
                    	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#404040; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:13px;">
                        	
                            <tbody><tr>
                            	<td>
                                	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#404040; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:13px;">
                                    	<tbody><tr>
                                        	<td width="273" valign="top" bgcolor="#82b965" class="emailFloatLeft">
                                            	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#404040; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:16px;">
                                                	<tbody><tr>
                                                    	<td><a href="'.get_the_permalink($hero_id).'"><img src="' . $hero_image[0] . '" class="emailWidthAuto" alt="" width="350" style="display:block;"></a></td>
                                                    </tr>
                                                    <tr>
                                                    	<td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                    	<td style="padding:0px 20px;">
                                                        	<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:16px;">
                                                            	
                                                    			<tbody><tr>
														<td style="font-size:20px; line-height:22px; padding-bottom:10px; font-weight:bold;">
                                            	Hero of the Month: <br>'. $hero_title .'
														</td>
													</tr>
																<tr>
														<td style="padding-bottom:12px;">' . $hero_blurb . '</td>
													</tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
														<td height="20">&nbsp;</td>
													</tr>
                                                </tbody></table>
                                            </td>
                                            <td width="15" valign="top" class="emailFloatLeft">&nbsp;</td>
                                            <td valign="top" class="emailFloatLeft" bgcolor="#ecece1">
                                           		<table width="100%" border="0" cellpadding="0" cellspacing="0" style="color:#404040; font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:15px;">
                                                    <tbody><tr>
                                                    	<td><a href="'.get_the_permalink($herb_id).'"><img src="'.$herb_image[0].'" class="emailWidthAuto" alt="" width="234" style="display:block;"></a></td>
                                                    </tr>
                                                    <tr>
														<td>&nbsp;</td>
													</tr>
                                                    <tr>
														<td style="font-size:20px; line-height:22px; font-weight:bold; padding:0px 15px 10px 20px; color:#3b8dbd;">A Herb for Thought:<br>
                                                        ' . $herb_title . '
                                                        </td>
													</tr>
													<tr>
														<td style="padding-bottom:15px; padding:0px 15px 10px 20px;">'.$herb_blurb.'
														</td>
													</tr>
												</tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>
                        </tbody></table>
                    </td>
                	</tr>';
    	return $output;

	}
}

function heroOfTheMonth($data, $post_id) {

	$hero_id = $data['hero_of_the_month'];
    $hero_title = get_the_title( $hero_id );
    $hero_link = get_permalink( $hero_id );
    $hero_image = $data['hero_image'];
    $hero_blurb = $data['hero_blurb'];
    $image = wp_get_attachment_image_src( $hero_image, 'email-thumb' );
    $hero_blurb = styleForEDM( cleanMarkupForEDM( $hero_blurb ), '#e6f1e0' );
    
    $hero_call_to_action = str_replace( '[current-page]', $hero_link, $data['hero_call_to_action'] );
    $blurb = $hero_blurb . styleForEDM( cleanMarkupForEDM( $hero_call_to_action ), '#e6f1e0' );

	$output = '<tr>
                    <td width="650" class="emailWidthAuto" bgcolor="#82b965" valign="top">
                        <table width="100%" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#b088bc" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#82b965; background-color:#82b965;">
                            <tr>
                                <td width="30">&nbsp;</td>
                                <td height="25">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="30">&nbsp;</td>
                                <td>
                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#82b965" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#ffffff; background-color:#82b965;">
                                        <tr>
                                            <td width="175" valign="top" class="emailFloatLeft">                                            
                                                <table width="175" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#ffffff; background-color:#ffffff;">
                                                    <tr>
                                                        <td width="175" class="emailWidthAuto"><a href="'.$hero_link.'" style="border: none"><img src="'. $image[0] .'" width="175"  alt="" border="0" style="display:block; border: none; margin: 0px" class="emailWidthAuto"></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="25" height="10" class="emailFloatLeft">&nbsp;</td>
                                            <td valign="top" class="emailFloatLeft">
                                                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px;">
                                                    <tr>
                                                        <td style="font-size:18px; line-height:18px; font-weight:bold;color:#ffffff">Hero of the Month: ' . $hero_title. '</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:10px; line-height:10px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:12px; line-height:16px;color:#ffffff" class="emailFloatLeft heroMonth">' . $blurb . '
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="30">&nbsp;</td>
                            </tr>
                            <tr>
                                <td width="30"></td>
                                <td height="25">&nbsp;</td>
                                <td width="30">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>';
    return $output;
}

function inTheGarden($data, $post_id) {

	$image = wp_get_attachment_image_src( $data['gardening_image'], 'email-hero' );

	$before = $data['above_the_list'];
	$before = styleForEDM( cleanMarkupForEDM( $before ), '#ffffff' );
    	$before = replacePwithBR($before);
   	$before = rtrim($before, '<br><br>');
   	$before = rtrim($before, '<br/><br/>');

	$below_the_list = $data['below_the_list'];
	$below_the_list = styleForEDM( cleanMarkupForEDM( $below_the_list ) );
	$below_the_list = replacePwithBR($below_the_list);

    $planting_guide = do_shortcode('[plantingguide target="email" post_id='.$post_id.']');
    

	$date = $data['month'];
	$date_parts = explode('/', $date);
	$month = date('F', mktime(0,0,0,$date_parts[1],1,2000) );

    $output = '<tr>
                        <td bgcolor="#3b8dbd" style="padding:20px 25px 0px 25px">
                            <table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:14px; font-weight:normal; color:#ffffff; background-color:#3b8dbd;" width="100%">
                                <tr>
                                    <td style="font-size:18px; line-height:2px; color:#0066a1; font-weight:bold;">
                                    	<img src="'.$image[0].'" width="600" alt="" style="display:block;" class="emailWidthAuto">
                                     </td>
                                </tr>
								<tr>
									<td align="center" style="padding:10px 0px 10px 0px; font-size:20px; line-height:22px; font-weight:bold; color:#ffffff">Back in the Garden</td>
								</tr>
                                
                            	<tr>
									<td style="padding:0px 0px 20px 0px; font-size:12px; line-height:16px; color:#ffffff;" align="center">'.$before.'
                                     <span style="font-weight:bold; font-size:16px; line-height:18px;">Things you can plant in '.$month . ' include:</span><br />
                                     
                                    </td>
								</tr>';
	$output .= $planting_guide;	

	if ($below_the_list != '') {					

	$output .= '<tr>
									<td style="padding:0px 0px 20px 0px; font-size:12px; line-height:14px; color:#ffffff;" align="center">'.$below_the_list.'                                    
                                    </td>
								</tr></table>
                        </td>
                    </tr>';

                }

	/*$output = '<tr>
                                <td width="30">&nbsp;</td>
                                <td>
                                    <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#626262; background-color:#ffffff;" class="contentBlockGreyOnWhite">
                                        <tr>
                                            <td width="175" valign="top" class="emailFloatLeft">
                                                <table width="175" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#333333; background-color:#ffffff;">
                                                    <tr>
                                                        <td width="169" class="emailWidthAuto" style="border:3px solid #4d4032; padding: 0px;"><img src="'.$image[0].'" width="169" height="125" alt="" border="0" style="display:block; margin: 0px;" class="emailWidthAuto"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td width="25" height="10" class="emailFloatLeft">&nbsp;</td>
                                            <td valign="top" class="emailFloatLeft">
                                                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#626262; background-color:#ffffff;">
                                                    <tr>
                                                        <td style="font-size:10px; line-height:10px;">&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-size:12px; line-height:16px;" class="emailFloatLeft">
                                                        ' . $before . '
<table width="100%" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#ffffff" class="contentBlockGreyOnWhite">
                                                    <tr style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#626262; background-color:#ffffff;">
                                                        '.$planting_guide.'
                                                    </tr>
                                                </table>
                                                ' . $below_the_list . '

                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="30">&nbsp;</td>
                            </tr>';*/

	return $output;
}

function edm_superscript($string) {
	$output = '';
	if ($string) {	
	$output.= '<tr>
	<td bgcolor="#45562f" style="padding:0px 30px 0px 30px;" align="center">
		<table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:10px; line-height:14px; font-weight:normal; color:#ffffff; background-color:#ffffff;">
	    	<tr>
	        	<td bgcolor="#45562f" style="padding:0px 30px 0px 30px; color: #45562f" align="center">'.$string.'</td>
	        </tr>
	    </table>
	</td>
	</tr>';
	}
return $output;
}


function saveNewsletter($post_id) {
	$hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id) , 'email-hero' );
	$newsletter_title = cleanMarkupForEDM( get_the_title( $post_id ) );
    $post_url = get_permalink( $post_id );

    $permablitz_news = do_shortcode('[permablitz_news edm="true" post_id='.$post_id.']');
    $permablitz_news = styleForEDM($permablitz_news);

	// $fb = do_shortcode('[facebook_posts edm="true"]');
	$fb = do_shortcode('[facebook_posts edm="true" post_id='.$post_id.']');

	$data = get_fields($post_id);
	$date = $data['month'];
	$date_parts = explode('/', $date);

	$start_month = date('Y-m-01', mktime(0,0,0,$date_parts[1],1,$date_parts[2]) );
	$end_month = date('Y-m-t', mktime(0,0,0,$date_parts[1],1,$date_parts[2]) );

	$blitz_blurb = $data[ 'introduction' ];
	$blitz_blurb = replacePwithBR( styleForEDM( cleanMarkupForEDM( $blitz_blurb ) ) );

	$hero_of_the_month = heroAndHerb( $post_id);

	$bits_and_pieces = do_shortcode('[bits_and_pieces edm="true" post_id='.$post_id.']' );
	$bits_and_pieces = styleForEDM($bits_and_pieces);

	$in_the_garden = inTheGarden($data, $post_id);

	$superscript = $data['super_script'];

	$signoff = $data['sign-off'];

	$other_events = otherEventNotifications($newsletter_id, array('limit'=>20,'category'=>58, 'scope' => $start_month .','.$end_month), true );

	$msg = file_get_contents( get_stylesheet_directory_uri() . '/email/newsletter.html' );
    $msg = str_replace( '{{SUPER_SCRIPT}}', $superscript, $msg );
    $msg = str_replace( '{{NEWSLETTER_TITLE}}', $newsletter_title, $msg );
    $msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
	$msg = str_replace( '{{UPCOMING_BLITZES}}', pbz_upcomingBlitzes(), $msg );
	$msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
	$msg = str_replace( '{{BLITZ_BLURB}}', $blitz_blurb, $msg );
	$msg = str_replace( '{{NEWSLETTER_URL}}', $post_url, $msg );
	$msg = str_replace( '{{PERMABLITZ_NEWS}}', $permablitz_news, $msg);
	$msg = str_replace( '{{FACEBOOK_POSTS}}', $fb, $msg);
	$msg = str_replace( '{{HERO_OF_THE_MONTH}}', $hero_of_the_month, $msg);
	$msg = str_replace( '{{BITS_AND_PIECES}}', $bits_and_pieces, $msg);
	$msg = str_replace( '{{BACK_IN_THE_GARDEN}}', $in_the_garden, $msg );
	$msg = str_replace( '{{OTHER_EVENTS}}', $other_events, $msg );
	// $msg = str_replace( '{{SIGNOFF}}', $signoff, $msg );

    update_post_meta($post_id, 'newsletter', $msg); 
	    
	return $msg;
}