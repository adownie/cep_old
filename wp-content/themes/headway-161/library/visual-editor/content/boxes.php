<?php
function mass_font_change_box(){
	global $headway_custom_fonts;
	
	if($headway_custom_fonts){
		$custom_fonts = '<optgroup label="Custom Fonts">';
		foreach($headway_custom_fonts as $label => $stack){
			$stack = addslashes(str_replace('"', '\'', $stack));
			$custom_fonts .= '<option value="'.$stack.'">'.$label.'</option>'."\n"; 
		}
		$custom_fonts .= '</optgroup>';
		
		$custom_fonts_separator = '<option value=""></option>';
	}
	
	echo '<div id="mass-font-change-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Mass Font Change</h4>
		
			<p>Use the select box below to change every element\'s font.</p>		
				
				<tr>
					<td>
						<select id="mass-font-family" class="font-family mass-font-select">
							<optgroup label="Serif Fonts">
								<option value="georgia, serif">Georgia</option>
								<option value="times, serif">Times</option>
								<option value="times new roman, serif">Times New Roman</option>
								<option value=""></option>
							</optgroup>
							<optgroup label="Sans-Serif Fonts">
								<option value="arial, sans-serif">Arial</option>
								<option value="\'arial black\', sans-serif">Arial Black</option>
								<option value="\'arial narrow\', sans-serif">Arial Narrow</option>
								<option value="courier, monospace">Courier</option>
								<option value="courier new, monospace">Courier New</option>
								<option value="gill sans, sans-serif">Gill Sans</option>
								<option value="helvetica, sans-serif">Helvetica</option>
								<option value="lucida grande, sans-serif">Lucida Grande</option>
								<option value="tahoma, sans-serif">Tahoma</option>
								<option value="trebuchet ms, sans-serif">Trebuchet MS</option>
								<option value="verdana, sans-serif">Verdana</option>
								'.$custom_fonts_separator.'
							</optgroup>
							'.$custom_fonts.'
						</select>
					</td>
				</tr>
	
	      </div>';
}

function export_box(){
	echo '<div id="export-window-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Export Style</h4>
		
			<p><strong>NOTE:</strong> If you have recently made changes, you must save before they will appear in the export file.</p>
			
			<a href="'.get_bloginfo('url').'/?headway-export-style=go" class="button keep-active">Export Current Style</a>
	
	      </div>';
}


function live_css_box(){
	echo '<div id="live-css-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Live CSS</h4>
		
			<textarea id="live-css" name="headway-config[live-css]" class="headway-visual-editor-input">'.headway_get_option('live-css').'</textarea>
		
			<style id="live-css-holder">
			</style>
			
	      </div>';
}

function linking_options_box(){
	if(headway_current_page(true)){
		$current_page_link = headway_get_option('leaf-template-page-'.headway_current_page(false, true));
		$current_system_page_link[headway_get_option('leaf-template-system-page-'.headway_current_page(false, true))] = ' selected';
	} else {
		$current_page_link = get_post_meta(headway_current_page(false, true), '_leaf_template', true);
		$current_system_page_link[get_post_meta(headway_current_page(false, true), '_leaf_system_template', true)] = ' selected';
	}
	
	$pages_select = '<option value="DELETE"></option>';
	$page_select_query = get_pages();
	foreach($page_select_query as $page){ 
		if($page->ID == $current_page_link) $selected[$page->ID] = ' selected';
		$pages_select .= '<option value="'.$page->ID.'"'.$selected[$page->ID].'>'.$page->post_title.'</option>';
	}
	
	echo '<div id="linking-options-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Linking Options</h4>
		
			<table class="tab-options">
			
				<p class="info-box clearfix">To speed of the process of creating layouts, you can tell a page to link to the leafs of another page.  You can use this system similarly to templates.</p>
				
				
				<tr>
					<th scope="row"><label for="leafs-link-page">Pages</label></th>
					<td>
						<select name="leafs-link-page" id="leafs-link-page" class="headway-visual-editor-input">
							'.$pages_select.'
						</select>
					</td>
				</tr>
				
				<tr class="no-border">
					<th scope="row"><label for="leafs-link-system-page">System Pages</label></th>
					<td>
						<select name="leafs-link-system-page" id="leafs-link-system-page" class="headway-visual-editor-input">
							<option value="DELETE"></option>
							<option value="index"'.$current_system_page_link['index'].'>Blog Index</option>
							<option value="single"'.$current_system_page_link['single'].'>Single Post</option>
							<option value="category"'.$current_system_page_link['category'].'>Category Archive</option>
							<option value="archives"'.$current_system_page_link['archives'].'>Archives</option>
							<option value="tag"'.$current_system_page_link['tag'].'>Tag Archive</option>
							<option value="author"'.$current_system_page_link['author'].'>Author Archive</option>
							<option value="search"'.$current_system_page_link['search'].'>Search</option>
							<option value="four04"'.$current_system_page_link['four04'].'>404 Page</option>
						</select>
					</td>
				</tr>
				
			</table>
			
	      </div>';
}

function header_uploader_box(){	
	echo '<div id="header-uploader-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Header Upload</h4>
		
			<p style="margin-bottom: 5px;"><small class="grey">Recommended Size: '.str_replace('px', '', headway_get_skin_option('wrapper-width')).'px by 150px</small></p>
		
			<div style="width: 100%; margin: 0 0 15px;">
				<input type="file" name="" id="header-image" value="" class="upload headway-visual-editor-input" />
			</div>
			
	
	      </div>';
}

function body_background_uploader_box(){	
	echo '<div id="body-background-uploader-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Body Background Upload</h4>
				
			<div style="width: 100%; margin: 0 0 15px;">
				<input type="file" name="" id="body-background-uploader" value="" class="upload headway-visual-editor-input" />
			</div>
			
	
	      </div>';
}

function switch_layout_overlay(){
?>
	<div id="visual-editor-menu-right">
		<form id="layout-chooser" method="POST">
			<?php wp_dropdown_pages(array('exclude_tree' => array($post->ID, get_option('page_for_posts')), 'selected' => headway_current_page(false, true), 'name' => 'layout-page', 'show_option_none' => __('-Pages-'), 'sort_column'=> 'menu_order, post_title', 'echo' => true)) ?>
			<select id="show-system-page" name="layout-system-page">
				<option value="">-System Pages-</option>
				<option value="index"<?php echo headway_option_value(headway_current_page(false, true), 'index') ?>>Blog Index</option>
				<option value="single"<?php echo headway_option_value(headway_current_page(false, true), 'single') ?>>Single Post</option>
				<option value="category"<?php echo headway_option_value(headway_current_page(false, true), 'category') ?>>Category Archive</option>
				<option value="archives"<?php echo headway_option_value(headway_current_page(false, true), 'archives') ?>>Archives</option>
				<option value="tag"<?php echo headway_option_value(headway_current_page(false, true), 'tag') ?>>Tag Archive</option>
				<option value="author"<?php echo headway_option_value(headway_current_page(false, true), 'author') ?>>Author Archive</option>
				<option value="search"<?php echo headway_option_value(headway_current_page(false, true), 'search') ?>>Search</option>
				<option value="four04"<?php echo headway_option_value(headway_current_page(false, true), 'four04') ?>>404 Page</option>
			</select>

			<input type="submit" class="button-wordpress button-right" name="switch-layout" value="Switch To Layout"/>
		</form>
	</div>
<?php
}

function save_and_link_box(){
	echo '<div id="save-and-link-box" class="floaty-box floaty-box-close floaty-box-center">
			<h4 class="floaty-box-header">Save &amp; Link</h4>
		
			<div style="width: 160px;float:left;margin: 0 10px 15px 0;padding-right:10px;border-right: 1px solid #ccc;">
				<strong>Link to Pages:</strong>
				<select name="link-pages[pages][]" id="link-pages" size="10" style="width: 160px;" class="headway-visual-editor-input" multiple>';
				
	  if(function_exists('get_pages')):
		$link_pages = '';
		$link_pages_query = get_pages();
		foreach($link_pages_query as $link_page){ 
			$link_pages .= ($link_page->ID != $_POST['layout-page']) ? '<option value="'.$link_page->ID.'">'.$link_page->post_title.'</option>' : '';
		}
		echo $link_pages;
	endif;
	
	echo '</select>
			</div>

			<div style="width: 160px;float:left;margin: 0 0 15px;">
				<strong>Link to System Pages:</strong>

				<select name="link-pages[system-pages][]" id="link-system-pages" size="10" class="headway-visual-editor-input" style="width: 160px;" multiple>
					<option value="index">Blog Index</option>
					<option value="single">Single Post</option>
					<option value="category">Category Archive</option>
					<option value="archives">Archives</option>
					<option value="tag">Tag Archive</option>
					<option value="author">Author Archive</option>
					<option value="search">Search</option>
					<option value="four04">404 Page</option>
				</select>
			</div>
			
			<p><input type="submit" value="Save and Link" class="button" name="headway-ve-save-and-link" id="save-and-link-button" /></p>
			
	      </div>';

}

function help_box(){
	echo '<div id="help-box" class="floaty-box floaty-box-close" style="display: none;">
		<h4 class="floaty-box-header">Help!</h4>

		<div class="floaty-box-bar" id="help-box-bar">
			<div id="help-box-bar-left">
				<p>Loading...</p>
			</div>
		</div>
		
		<div class="floaty-box-content" id="help-box-content">
			<p>Welcome to the Headway help panel!  Select a topic above to get started.</p>
		</div>
		
	</div>';
}


function ie_box(){
	echo '<div id="ie-box" class="floaty-box">
			<h4 class="floaty-box-header">Warning!</h4>
			
			<div class="floaty-box-content">
				<p>
					The Headway Visual Editor is not optimized for Internet Explorer.  Please upgrade to a better browser such as <a href="http://getfirefox.com">Mozilla Firefox</a> or <a href="http://www.google.com/chrome">Google Chrome</a>.
				</p>
				<p>Feeling risky?  <a href="'.get_bloginfo('url').'/?visual-editor=true" onclick="jQuery.cookie(\'headway-visual-editor-ie\', 1); window.location=\''.get_bloginfo('url').'/?visual-editor=true\'; return false;">Continue on your on parole.</a></p>
			</div>
		</div>';
}


function loading_overlay(){
	echo '<div id="overlay" class="overlay" style="opacity:1;z-index: 12500;"></div><div id="visual-editor-loader">

				<p class="loading loading-image-big"><img src="'.get_bloginfo('template_directory').'/media/images/loading-big.gif" class="loading-image loading-image-big" /></p>
				
				<p id="visual-editor-loader-text">If the visual editor takes longer than 20 seconds to load, please contact Headway Support at <a href="mailto:support@headwaythemes.com">support@headwaythemes.com</a> or visit the Headway forums.</p>
			</div>';
}


function intro_video(){
	echo '
		<div id="intro-overlay" class="overlay" style="opacity:1;z-index: 11500;"></div>
		<div id="intro-box" class="floaty-box floaty-box-close no-drag">
				<h4 class="floaty-box-header">Welcome!</h4>

				<div class="floaty-box-content">
					<p>Hey!  Welcome to the Headway Visual Editor.  Headway can sometimes be overwhelming at first, but thankfully we have you covered.  Watch the video below for a comprehensive overview.  In the future, you can always access the <a href="http://headwaythemes.com/documentation" target="_blank">Headway documentation</a> on our website or using the inline documentation.</p>
				
					<object width="712" height="400"><param name="movie" value="http://www.youtube.com/v/pf5n14zBL0U&hl=en_US&fs=1&rel=0&hd=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/pf5n14zBL0U&hl=en_US&fs=1&rel=0&hd=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="712" height="400"></embed></object>

				</div>
			</div>
	';
}