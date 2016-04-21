<?php
headway_register_block('HeadwayWidgetAreaBlock', headway_url() . '/library/blocks/widget-area');

class HeadwayWidgetAreaBlock extends HeadwayBlockAPI {


	public $id = 'widget-area';
	
	public $name = 'Widget Area';
	
	public $options_class = 'HeadwayWidgetAreaBlockOptions';

	public $html_tag = 'aside';

	public $description = 'Used typically as a sidebar or to aid the footer.  The widget area will display WordPress widgets which are managed in the WordPress Appearance &raquo; Widgets panel.';
		
	
	public static function init_action($block_id, $block) {
														
		$widget_area_name = HeadwayBlocksData::get_block_name($block) . ' &mdash; ' . 'Layout: ' . HeadwayLayout::get_name($block['layout']);
				
		$widget_area = array(
			'name'			 =>   $widget_area_name,
			'id' 			 =>   'widget-area-' . $block['id'],
			'before_widget'  =>   '<li id="%1$s" class="widget %2$s">' . "\n",
			'after_widget'   =>   '</li><!-- .widget -->' . "\n",
			'before_title'   =>   '<h3 class="widget-title"><span class="widget-inner">',
			'after_title'    =>   '</span></h3>' . "\n",
		);

		register_sidebar($widget_area);
		
	}


	function setup_elements() {
		
		$this->register_block_element(array(
			'id' => 'widget',
			'name' => 'Widget',
			'selector' => 'li.widget'
		));

		$this->register_block_element(array(
			'id' => 'widget-title',
			'name' => 'Widget Title',
			'selector' => 'li.widget .widget-title',
			'inherit-location' => 'default-heading'
		));

		$this->register_block_element(array(
			'id' => 'widget-title-inner',
			'name' => 'Widget Title Inner',
			'selector' => 'li.widget .widget-title span',
			'inherit-location' => 'default-heading'
		));
		
		$this->register_block_element(array(
			'id' => 'widget-links',
			'name' => 'Widget Links',
			'selector' => 'li.widget a',
			'states' => array(
				'Selected' => 'ul li.current_page_item a', 
				'Hover' => 'ul li a:hover', 
				'Clicked' => 'ul li a:active'
			),
			'inherit-location' => 'default-hyperlink'
		));

		$this->register_block_element(array(
			'id' => 'widget-lists',
			'name' => 'Widget Lists',
			'description' => '&lt;UL&gt;',
			'selector' => 'li.widget ul',
			'properties' => array('fonts', 'lists', 'background', 'borders', 'padding', 'corners', 'box-shadow'),
		));

			$this->register_block_element(array(
				'id' => 'widget-list-items',
				'name' => 'Widget List Items',
				'description' => '&lt;LI&gt;',
				'selector' => 'li.widget ul li'
			));
		
	}


	function content($block) {
				
		echo ( parent::get_setting( $block, 'horizontal-widgets' ) == true ) ? '<ul class="widget-area horizontal-sidebar">' : '<ul class="widget-area">';

			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('widget-area-' . $block['id']) ) {

				echo '<li class="widget widget-no-widgets">';
					echo '<h3 class="widget-title"><span class="widget-inner">No widgets!</span></h3>';
					echo '<p>Add widgets to this sidebar in the <a href="' . admin_url('widgets.php') . '">Widgets panel</a> under Appearance in the WordPress Admin.</p>';
				echo '</li>';

			} 

		echo '</ul>';
				
	}

	
}


class HeadwayWidgetAreaBlockOptions extends HeadwayBlockOptionsAPI {
	
	
	public $tabs = array(
		'widget-area-content' => 'Content',
		'widget-layout' => 'Widget Layout'
	);
	

	public $inputs = array(
		'widget-layout' => array(
			'horizontal-widgets' => array(
				'type' => 'checkbox',
				'name' => 'horizontal-widgets',
				'label' => 'Horizontal Widgets',
				'default' => false,
				'tooltip' => 'Instead of showing widgets vertically, you can make them span horizontally.  This is especially useful for widgetized footers.'
			)
		)
	);
	
	
	function modify_arguments($args = false) {
		
		$this->tab_notices['widget-area-content'] = 'To add widgets to this widget area, go to <a href="' . admin_url('widgets.php') . '" target="_blank">WordPress Admin &raquo; Appearance &raquo; Widgets</a> and add the widgets to <em>' . HeadwayBlocksData::get_block_name($args['block_id']) . ' &mdash; ' . 'ID: ' . $args['blockID'] . '</em>.';
		
	}
	
	
}