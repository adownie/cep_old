<?php
function headway_triggers() {
    if(isset($_GET['headway-css'])) {
		headway_gzip();
		header("Content-type: text/css");
	
		$expires = 60*60*24*30;
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
	
		echo headway_generate('headway-css');
		
    	exit;
	} elseif(isset($_GET['headway-leafs-css'])) {
		headway_gzip();
		header("Content-type: text/css");
	
		$expires = 60*60*24*30;
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
				
		echo headway_generate('leafs-css');
		
		exit;

    } elseif(isset($_GET['headway-js'])) {
		headway_gzip();
		header("content-type: application/x-javascript");
		
		$expires = 60*60*24*30;
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');
		
		echo headway_generate('scripts');

    	exit;
    } elseif(isset($_GET['headway-visual-editor-js']) && headway_can_visually_edit()){
		header("content-type: application/x-javascript");
		
		$expires = 60*60*24*30;
		header("Pragma: public");
		header("Cache-Control: maxage=".$expires);
		header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$expires) . ' GMT');

		include HEADWAYROOT.'/media/js/jquery.hoverintent.js';
		include HEADWAYROOT.'/library/admin/js/jquery.ui.js';
		include HEADWAYROOT.'/library/visual-editor/js/visual-editor.js';
		include HEADWAYROOT.'/library/visual-editor/js/jquery.mousewheel.js';
		include HEADWAYROOT.'/library/visual-editor/js/jquery.jscrollpane.js';

		if($_GET['leafs'] == 'true') include HEADWAYROOT.'/library/visual-editor/js/visual-editor-leafs.js';

		if($_GET['visual-editor'] == 'true'){
			include HEADWAYROOT.'/media/js/jquery.highlightFade.js';
			include HEADWAYROOT.'/library/visual-editor/js/colorpicker-include.js';
			include HEADWAYROOT.'/library/visual-editor/js/visual-editor-elements.js';
		}

		include HEADWAYROOT.'/library/visual-editor/js/visual-editor-options.js';
		include HEADWAYROOT.'/library/visual-editor/js/jquery.tooltip.js';
		include HEADWAYROOT.'/library/visual-editor/js/jquery.cookie.js';

		include HEADWAYROOT.'/library/resources/uploadify/swfobject.js';

		include HEADWAYROOT.'/library/visual-editor/js/visual-editor-uploadify.js';

		include HEADWAYROOT.'/library/visual-editor/js/visual-editor-end.js';
		
		exit;
	} elseif(isset($_GET['headway-export-style']) && headway_can_visually_edit()){
		include HEADWAYROOT.'/library/visual-editor/lib/export-style.php';
		
		exit;
	} elseif(isset($_GET['headway-ajax-loader'])){
		include HEADWAYROOT.'/library/visual-editor/lib/ajax-loader.php';

		exit;
	} elseif(isset($_GET['headway-visual-editor-action']) && headway_can_visually_edit()){
		include HEADWAYROOT.'/library/visual-editor/form-action.php';
		
		exit;
	}
}
add_action('template_redirect', 'headway_triggers');