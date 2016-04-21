<?php
class HeadwaySkinLayoutOption {


	private static function pass_method($method, array $args) {

		/* Set skins option flag */
		HeadwayLayoutOption::$is_skin_option = true;

		$result = call_user_func_array(array('HeadwayLayoutOption', $method), $args);

		/* Remove skin option flag */
		HeadwayLayoutOption::$is_skin_option = false;

		return $result;

	}


	public static function get() {

		$args = func_get_args();
		return self::pass_method(__FUNCTION__, $args);

	}
	

	public static function set() {

		$args = func_get_args();
		return self::pass_method(__FUNCTION__, $args);

	}


	public static function delete() {

		$args = func_get_args();
		return self::pass_method(__FUNCTION__, $args);
		
	}


	public static function delete_all_from_layout($layout) {

		return delete_option(HeadwayLayoutOption::format_wp_option('headway_layout_options_' . HeadwayLayoutOption::format_layout_id($layout)));

	}


}