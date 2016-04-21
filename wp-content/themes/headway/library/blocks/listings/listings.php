<?php

headway_register_block('HeadwayListingsBlock', headway_url() . '/library/blocks/listings');

class HeadwayListingsBlock extends HeadwayBlockAPI {
	
	
	public $id = 'listings';
	
	public $name = 'Listings';
	
	public $options_class = 'HeadwayListingsBlockOptions';

	public $description = 'List out your categories, authors, pages, comments and comments.';

	static $block = null;

	function __construct() {
		
		$blocks = HeadwayBlocksData::get_blocks_by_type('listings');

		/* return if there are not blocks for this type.. else do the foreach */
		if ( !isset($blocks) || !is_array($blocks) )
			return;
		
		foreach ($blocks as $block_id => $layout_id) {
			self::$block = HeadwayBlocksData::get_block($block_id);
		}

	}

	function init() {
		
		require_once 'block-options.php';

		require_once HEADWAY_LIBRARY_DIR . '/blocks/listings/content-display.php';

		
	}

	function setup_elements() {

		$this->register_block_element(array(
			'id' => 'list-items',
			'name' => 'List Container',
			'selector' => 'ul.list-items'
		));

		$this->register_block_element(array(
			'id' => 'list-item',
			'name' => 'List Item',
			'selector' => 'ul.list-items li'
		));

		$this->register_block_element(array(
			'id' => 'list-item-link',
			'name' => 'List Item Link',
			'selector' => 'ul.list-items li a'
		));
		
	}

	function content($block) {

		$listing_block_display = new HeadwayListingBlockDisplay($block);
		$listing_block_display->display();

	}


	
	
}