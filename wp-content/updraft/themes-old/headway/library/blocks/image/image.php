<?php
headway_register_block('HeadwayImageBlock', headway_url() . '/library/blocks/image');

class HeadwayImageBlock extends HeadwayBlockAPI {
	
	public $id = 'image';
	
	public $name = 'Image';
		
	public $options_class = 'HeadwayImageBlockOptions';
	
	public $fixed_height = true;
	
	public $html_tag = 'figure';

	public $description = 'Display an image';
	
	protected $show_content_in_grid = true;
	
	function setup_elements() {
		
		$this->register_block_element(array(
			'id' => 'image',
			'name' => 'Image',
			'selector' => 'img'
		));

		$this->register_block_element(array(
			'id' => 'image-link',
			'name' => 'Image Link',
			'selector' => 'img a',
			'states' => array(
				'Hover' => 'img a:hover',
				'Clicked' => 'img a:active'
			)
		));
		
	}

	public static function dynamic_css($block_id, $block = false) {

		if ( !$block )
			$block = HeadwayBlocksData::get_block($block_id);

		if ( !$position = parent::get_setting($block, 'image-position') )
			return;

		$position_properties = array(
			'top_left' => 'left: 0; top: 0;',
			'top_center' => 'left: 0; top: 0; right: 0;',
			'top_right' => 'top: 0; right: 0;',

			'center_center' => 'bottom: 0; left: 0; top: 0; right: 0;',
			'center_left' => 'bottom: 0; left: 0; top: 0;',
			'center_right' => 'bottom: 0; top: 0; right: 0;',
			
			'bottom_left' => 'bottom: 0; left: 0;',
			'bottom_center' => 'bottom: 0; left: 0; right: 0;',
			'bottom_right' => 'bottom: 0;right: 0;'
		);
		
		$css = '
			#block-' . $block['id'] . ' .block-content { position: relative; }
			#block-' . $block['id'] . ' img {
				margin: auto;
			    position: absolute;  
			    ' . headway_get($position, $position_properties) . '
			}
		';

		return $css;
		
	}
	
	function content($block) {
		
		//Display image if there is one
		if ( $image_src = parent::get_setting($block, 'image') ) {
		
			$url = parent::get_setting($block, 'link-url');
			$alt = parent::get_setting($block, 'link-alt');

			$target = parent::get_setting($block, 'link-target', false) ? $target = 'target="_blank"' : '';

			if ( parent::get_setting($block, 'resize-image', true) ) {
				
				$block_width = HeadwayBlocksData::get_block_width($block);
				$block_height = HeadwayBlocksData::get_block_height($block);
				
				$image_url = headway_resize_image($image_src, $block_width, $block_height);
				
			} else {
				
				$image_url = $image_src;
				
			}

			if ( $image_src = parent::get_setting($block, 'link-image', false) ) {

				echo '<a href="' . $url . '" class="image" '.$target.'><img src="' . $image_url . '" alt="' . $alt . '" /></a>';

			} else {

				echo '<img src="' . $image_url . '" alt="' . $alt . '" />';

			}
			
		} else {

			echo '<div style="margin: 5px;" class="alert alert-yellow"><p>You have not added an image yet. Please upload and apply an image.</p></div>';
		}
		
		/* Output position styling for Grid mode */
			if ( headway_get('ve-live-content-query', $block) && headway_post('mode') == 'grid' ) {
				echo '<style type="text/css">';
					echo self::dynamic_css(false, $block);
				echo '</style>';
			}


	}
	
}


class HeadwayImageBlockOptions extends HeadwayBlockOptionsAPI {
	
	public $tabs = array(
		'general' => 'General'
	);

	public $inputs = array(
		'general' => array(

			'image-heading' => array(
				'name' => 'image-heading',
				'type' => 'heading',
				'label' => 'Add an Image'
			),

			'image' => array(
				'type' => 'image',
				'name' => 'image',
				'label' => 'Image',
				'default' => null
			),
			
			'resize-image' => array(
				'name' => 'resize-image',
				'label' => 'Automatically Resize Image',
				'type' => 'checkbox',
				'tooltip' => 'If you would like Headway to automatically scale and crop the image to the blocks dimensions, keep this checked.<br /><br /><em><strong>Important:</strong> In order for the image to be resized and cropped it must be uploaded <strong>From Computer</strong>. <strong>NOT</strong> <strong>From URL</strong>.</em>',
				'default' => true
			),

			'link-heading' => array(
				'name' => 'link-heading',
				'type' => 'heading',
				'label' => 'Link Image'
			),

			'link-image' => array(
				'name' => 'link-image',
				'label' => 'Link the image?',
				'type' => 'checkbox',
				'tooltip' => 'If you would like to link the image to a url activate this setting. Must add http:// first',
				'default' => false,
				'toggle' => array(
					'true' => array(
						'show' => array(
							'#input-link-url',
							'#input-link-alt',
							'#input-link-target'
						)
					),
					'false' => array(
						'hide' => array(
							'#input-link-url',
							'#input-link-alt',
							'#input-link-target'
						)
					)
				)
			),

			'link-url' => array(
				'name' => 'link-url',
				'label' => 'Link image URL?',
				'type' => 'text',
				'tooltip' => 'Set the URL for the image to link to'
			),

			'link-alt' => array(
				'name' => 'link-alt',
				'label' => 'Image Link Alternate Text',
				'type' => 'text',
				'tooltip' => 'Set alternative text for the image link'
			),

			'link-target' => array(
				'name' => 'link-target',
				'label' => 'Open in a new window?',
				'type' => 'checkbox',
				'tooltip' => 'If you would like to open the link in a new window check this option',
				'default' => false,
			),

			'position-heading' => array(
				'name' => 'position-heading',
				'type' => 'heading',
				'label' => 'Position Image'
			),

			'image-position' => array(
				'name' => 'image-position',
				'label' => 'Position image inside container',
				'type' => 'select',
				'tooltip' => 'You can position this image in relation to the block using the positions provided',
				'default' => 'none',
				'options' => array(
					'' => 'None',
					'top_left' => 'Top Left',
					'top_center' => 'Top Center',
					'top_right' => 'Top Right',
					'center_left' => 'Center Left',
					'center_center' => 'Center Center',
					'center_right' => 'Center Right',
					'bottom_left' => 'Bottom Left',
					'bottom_center' => 'Bottom Center',
					'bottom_right' => 'Bottom Right'
				)
			)

		)
	);
	
}