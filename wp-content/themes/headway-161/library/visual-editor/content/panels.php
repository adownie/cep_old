<?php
function visual_editor_content(){
	foreach(headway_get_elements() as $opt_group => $elements){
		$elements_options .= '<optgroup label="'.$opt_group.'">';
		
			foreach($elements as $element){
				$element[3] = ($element[3]) ? 'true' : 'false';
				
				$elements_options .= '<option value="'.$element[0].'" id="option-'.headway_selector_to_form_name($element[0]).'" fonts="'.$element[3].'">'.$element[1].'</option>';
			}
	
		$elements_options .= '</optgroup>';
	}
	
	echo '<div id="inspector-container" class="sub-box">
					<span class="sub-box-heading">Inspector</span>
					<div class="sub-box-content">
						<div id="inspector">Simply hover an element to get more information about it.  Click it to style it.</div>
					</div>
				</div>

				<div id="dropdown-container" class="sub-box">
					<span class="sub-box-heading">Element Selector</span>
					<div class="sub-box-content">
						<p>If you want to get down to business without using the inspector, choose an element in the dropdown below.</p>
						<select name="element-selector" id="element-selector">
							<option value="" id="element-selector-blank"></option>
							'.$elements_options.'
						</select>
						<p id="callout" style="display:none;"><a href="#" class="button small-button">Call This Element Out</a></p>
					</div>
				</div>

				<div id="colors" style="display: none;" class="sub-box">
					<span class="sub-box-heading">Colors: <span id="colors-heading"></span></span>
					<div class="sub-box-content">
						<div id="colors-inputs">
							'.headway_create_element_inputs('colors', headway_get_elements()).'
						</div>
					</div>
				</div>

				<div id="fonts" style="display: none;" class="sub-box">
					<span class="sub-box-heading">Fonts: <span id="fonts-heading"></span></span>
					<div class="sub-box-content">
						<div id="fonts-inputs">
							'.headway_create_element_inputs('fonts', headway_get_elements()).'
						</div>
					</div>
				</div>';
}

function templates_content(){	
	if(!headway_is_skin_active()) $no_active_skin = ' class="selected"';
		
	echo '
		<div class="tabs">
		    <ul class="clearfix tabs">';
		       if(!headway_get_option('disable-visual-editor') && !headway_get_option('enable-developer-mode') && !headway_is_skin_active()) echo '<li><a href="#styles-tab">Styles</a></li>';
			   echo '<li><a href="#skins-tab">Skins</a></li>
		    </ul>';
		
	if(!headway_get_option('disable-visual-editor') && !headway_get_option('enable-developer-mode') && !headway_is_skin_active())	
		echo '
			<div id="styles-tab">
				<p class="info-box clearfix">Browse to the style you wish to import on your computer.  You\'ll be able to see what the style looks, but the style won\'t be applied until you save the visual editor.</p>

				<div style="margin: 10px 20px;">
					<input type="file" name="" id="import-file" value="" class="upload" />
				</div>
			</div>';
		
		echo '	
			<div id="skins-tab">
				<select id="skins-selector" name="headway-config[active-skin]" class="headway-visual-editor-input">
					<option value="none">&mdash;No Skin&mdash;</option>';

					do_action('headway_skins_selector');

		echo '</select>
		
				<p class="info-box clearfix" style="display: none;" id="skin-notification">To finish switching skins, save your changes by clicking the save button in the bottom right then reload the visual editor.</p>
			
				<ul class="thumbnail-grid clearfix">
				
					<li id="none"'.$no_active_skin.'><a href="#"><img src="'.get_bloginfo('template_directory').'/library/visual-editor/images/headway_default.jpg"/><em>No Skin (Default)<br /><small>Use Design Editor</small></em></a></li>

			';					
					do_action('headway_skins_thumbnails');
		echo '
				</ul>
			</div>
			
			
		</div>
	';
}

function leafs_panel_content(){
	
	if(
		headway_get_option('leaf-template-page-'.headway_current_page(false, true)) || 
		headway_get_option('leaf-template-system-page-'.headway_current_page(false, true)) || 
		(get_post_meta(headway_current_page(false, true), '_leaf_template', true) && get_post_meta(headway_current_page(false, true), '_leaf_template', true) != 'DELETE') || 
		(get_post_meta(headway_current_page(false, true), '_leaf_system_template', true) && get_post_meta(headway_current_page(false, true), '_leaf_system_template', true) != 'DELETE')
	){
		$leaf_utilities_style = 'display: none;';
		$utilities_tab = '<p>If you wish to customize the layout for this page, go to the linking options in the top menu and disable linking (set both select boxes to the blank option then save) to make a unique layout for this page, save, and reload the visual editor.</p>';
	} else {
		$utilities_tab = '<ul class="list-buttons utilities-buttons" style="'.$leaf_utilities_style.'">
			<li class="arrange"><span>Arrange Leafs</span> <a href="" id="toggle-arrange" class="button">Enable</a></li>
			<li class="resize"><span>Resize Leafs</span> <a href="" id="toggle-resize" class="button">Enable</a></li>
		</ul>';
		$add_tab_link = '<li><a href="#add-tab">Add</a></li>';
		
		global $custom_leafs;
		$leaf_count = 0;
		
		foreach($custom_leafs as $leaf_type => $leaf_button_options){
			if($leaf_type == 'content' || $leaf_type == 'sidebar') continue;
			
			if($leaf_count%2) $alt[$leaf_type] = ' alt';
			
			if(!$leaf_button_options['icon']) $leaf_button_options['icon'] = get_bloginfo('template_directory').'/library/leafs/icons/default.png';
			
			$leafs .= '<li class="'.$leaf_type.$alt[$leaf_type].'"><img src="'.$leaf_button_options['icon'].'" width="16px" height="16px" /><span>'.$leaf_button_options['name'].'</span> <a href="" id="add-'.$leaf_type.'" class="button small-button">Add</a></li>';
			
			$leaf_count++;
		}
		
		$add_tab = '<div id="add-tab">
				<ul class="add-leafs list-buttons list-small-buttons">
					<li class="content"><img src="'.get_bloginfo('template_directory').'/library/leafs/icons/content.png'.'" width="16px" height="16px" /><span>Content</span> <a href="" id="add-content" class="button small-button">Add</a></li>
					<li class="sidebar alt"><img src="'.get_bloginfo('template_directory').'/library/leafs/icons/sidebar.png'.'" width="16px" height="16px" /><span>Widget Ready Sidebar</span> <a href="" id="add-sidebar" class="button small-button">Add</a></li>
					'.$leafs.'
				</ul>
		    </div>';
		
		$leafs_miscellaenous_tab_link = '<li><a href="#leafs-miscellaneous-tab">Miscellaneous</a></li>';
		
		$leafs_miscellaneous_tab = '<div id="leafs-miscellaneous-tab">
			<input type="submit" class="visual-editor-button headway-visual-editor-input" value="Set Default Leafs" name="set-default-leafs" id="set-default-leafs" />
			<p style="margin: 8px 11px 15px; font-size: 11px;">Setting the default layout will also save all changes in the visual editor.</p>


			<input type="submit" class="visual-editor-button headway-visual-editor-input" value="Reset Leafs On Page" name="reset-leafs" id="reset-leafs" />
			<p style="margin: 8px 11px; font-size: 11px;">Resetting the leafs will use the default leafs if they exist.</p>
		</div>';
	}
		
	echo '<div class="tabs">
			    <ul class="clearfix tabs">
			        <li><a href="#utilities-tab">Utilities</a></li>
			        '.$add_tab_link.'
					'.$leafs_miscellaenous_tab_link.'
			    </ul>
			    <div id="utilities-tab">
					'.$utilities_tab.'
			    </div>
			   '.$add_tab.'
				'.$leafs_miscellaneous_tab.'
			</div>';
}

function site_configuration_content(){	
	$skin_options = headway_get_option('skin-options');
	
	$header_image_delete_display = (headway_get_option('header-image') && headway_get_option('header-image') != 'DELETE') ? NULL : 'display: none;';
	$header_image = headway_get_option('header-image');
	
	$body_background_image_delete_display = (headway_get_option('body-background-image') && headway_get_option('body-background-image') != 'DELETE') ? NULL : 'display: none;';
	$body_background_image = headway_get_option('body-background-image');
		
	if(!($skin_options['header-order'] && $skin_options['skin'] == headway_active_skin()))
		$header_rearranging = '<p class="radio-container" style="width: auto;margin: 10px 0 0 47px;"><a href="#" id="toggle-header-arrange" class="button tooltip" title="Enable header rearranging to change the order of the header, navigation, and breadcrumbs with drag and drop.  Cool, eh?">Enable Header Rearranging</a></p>';
		
?>
	<div class="tabs">
	    <ul class="clearfix tabs">
	        <li><a href="#header-tab">Header</a></li>
	        <li><a href="#footer-tab">Footer</a></li>
			<?php if(!headway_get_skin_option('disable-body-background-image')){ ?>
			<li><a href="#body-tab">Body</a></li>
			<?php } ?>
	        <li><a href="#site-dimensions-tab">Site Dimensions</a></li>
	    </ul>
	
	    <div id="header-tab">

<?php		
	if(!headway_get_skin_option('disable-header-image')){
?>
		<div class="sub-box minimize" id="header-image-options">
			<span class="sub-box-heading">Header Image</span>
	
			<div class="sub-box-content">
				<table class="tab-options">
			
					<tr>
					  <td class="clearfix"><a href="#" id="upload-header-image" class="button box-button">Upload Header Image</a></td>
						  <input type="hidden" class="headway-visual-editor-input" name="headway-config[header-image]" id="header-image-hidden" value="<?php echo $header_image ?>" />
					  </tr>


					  <tr>					
						  <th scope="row"><label class="tooltip" for="header-image-url" style="cursor: help;">OR Link Directly To Header Image</label></th>					
						  <td><input type="text" value="" id="header-image-url" class="headway-visual-editor-input" name="headway-config[header-image-url]"/></td>				
					  </tr>

					  <tr id="header-image-current-row" style="<?php echo $header_image_delete_display ?>">
						  <td colspan="2"><span id="header-image-current"><?php echo headway_get_option('header-image') ?></span> <a id="header-image-delete" href="#">Delete</a></td>
					  </tr>
				
				
					<tr class="border-top">					
						<th scope="row"><label class="tooltip" title="If your header image is already the size you desire, disable header imager resizing." style="cursor: help;">Header Image Resizing</label></th>					
						<td>
							<p class="radio-container">
								<input type="hidden" value="DELETE" class="headway-visual-editor-input" name="headway-config[enable-header-resizing]"/>
								<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('enable-header-resizing')) ?> class="radio headway-visual-editor-input" value="on" id="enable-header-resizing" name="headway-config[enable-header-resizing]"/><label for="enable-header-resizing">Enable Header Image Resizing</label>						
							</p>
						</td>				
					</tr>
		
					<?php echo headway_build_visual_editor_input('text', 'header', 'header-image-margin', 'Header Image Margin', false, headway_get_skin_option('header-image-margin'), false, false, 'Set the margin or space around the header image.  If you are sure you\'re header image is the correct size, be sure to make sure this is set to 0px.') ?>
		
				</table>
			</div>
		</div>
<?php
	}
?>			
					<div class="sub-box minimize" id="header-options">
						<span class="sub-box-heading">Header Options</span>
						
						<div class="sub-box-content">
							<table class="tab-options">
								<tr>					
									<th scope="row"><label class="tooltip" title="Show or hide elements in the header." style="cursor: help;">Header Elements</label></th>					
									<td class="clearfix">
										
										<?php echo headway_build_visual_editor_input('check-alt', 'header', 'show-tagline', false, 'Show Tagline', headway_get_skin_option('show-tagline'), false, false); ?>
										<?php echo headway_build_visual_editor_input('check-alt', 'header', 'show-navigation', false, 'Show Navigation', headway_get_skin_option('show-navigation'), false, false); ?>
										<?php echo headway_build_visual_editor_input('check-alt', 'header', 'show-breadcrumbs', false, 'Show Breadcrumbs', headway_get_skin_option('show-breadcrumbs'), false, false); ?>

									</td>				
								</tr>


								<?php echo headway_build_visual_editor_input('radio', 'header', 'header-style', 'Header Style', array('Fixed Header' => array('id' => 'header-style-fixed', 'value' => 'fixed'), 'Fluid Header' => array('id' => 'header-style-fluid', 'value' => 'fluid')), headway_get_skin_option('header-style'), false, false, 'Fluid: The header is outside the wrapper and spans the whole width of the page.  Fixed: Header stays inside wrapper.'); ?>
								
								<?php echo headway_build_visual_editor_input('radio', 'header', 'navigation-position', 'Navigation Position', 
									array(
										'Left' => array('id' => 'navigation-position-left', 'value' => 'left'), 
										'Right' => array('id' => 'navigation-position-right', 'value' => 'right')
									),
								 	headway_get_skin_option('navigation-position'), false, false, 'Change the position of your navigation.'); ?>
							</table>
						</div>
					</div>
					
					<?php echo $header_rearranging; ?>
						
			    </div>
			

				<div id="footer-tab">
					<table class="tab-options" id="footer-options">
					
						<?php echo headway_build_visual_editor_input('radio', 'footer', 'footer-style', 'Footer Style', 
							array(
								'Fixed Footer' => array('id' => 'footer-style-fixed', 'value' => 'fixed'), 
								'Fluid Foooter' => array('id' => 'footer-style-fluid', 'value' => 'fluid')), 
							headway_get_skin_option('footer-style'), false, false, 'Much like the header, you can choose if you want to footer to be fluid or fixed.  Fluid is where the footer spans the width of the page and fixed is where the footer stays inside the page wrapper.'); ?>
						
						
							<tr class="no-border">					
								<th scope="row"><label class="tooltip" title="Show or hide elements in the footer." style="cursor: help;">Footer Elements</label></th>					
								<td>
									<p class="radio-container">
										<input type="hidden" value="DELETE" class="headway-visual-editor-input" name="headway-config[show-admin-link]"/>
										<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('show-admin-link')); ?> class="radio headway-visual-editor-input" value="on" id="show-admin-link" name="headway-config[show-admin-link]"/><label for="show-admin-link">Show Admin Link/Login</label>						
									</p>

									<p class="radio-container">
										<input type="hidden" value="DELETE" name="headway-config[show-edit-link]" class="headway-visual-editor-input" />
										<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('show-edit-link')); ?> class="radio headway-visual-editor-input" value="on" id="show-edit-link" name="headway-config[show-edit-link]"/><label for="show-edit-link">Show Edit Link</label>						
									</p>

									<p class="radio-container">
										<input type="hidden" value="DELETE" name="headway-config[show-go-to-top-link]" class="headway-visual-editor-input" />
										<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('show-go-to-top-link')); ?> class="radio headway-visual-editor-input" value="on" id="show-go-to-top-link" name="headway-config[show-go-to-top-link]"/><label for="show-go-to-top-link">Show Go To Top Link</label>						
									</p>
									
									<p class="radio-container">
										<input type="hidden" value="DELETE" name="headway-config[show-copyright]" class="headway-visual-editor-input" />
										<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('show-copyright')); ?> class="radio headway-visual-editor-input" value="on" id="show-copyright" name="headway-config[show-copyright]"/><label for="show-copyright">Show Copyright</label>						
									</p>
									
									<p class="radio-container">
										<input type="hidden" value="DELETE" name="headway-config[hide-headway-attribution]" class="headway-visual-editor-input" />
										<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('hide-headway-attribution')); ?> class="radio headway-visual-editor-input" value="on" id="hide-headway-attribution" name="headway-config[hide-headway-attribution]"/><label for="hide-headway-attribution">Hide Headway Attribution</label>						
									</p>
								</td>				
							</tr>
							
							<?php echo headway_build_visual_editor_input('text', 'footer', 'custom-copyright', 'Custom Copyright', false, headway_get_option('custom-copyright'), false, false, 'If you wish to have something different than the regular copyright, enter it here.'); ?>
							
						
					</table>
				</div>
				
<?php
if(!headway_get_skin_option('disable-body-background-image')){
?>
				<div id="body-tab">
					<div class="sub-box minimize" id="body-background-image-options">
						<span class="sub-box-heading">Body Background Image</span>

						<div class="sub-box-content">
							<table class="tab-options">

								<tr>
								  <td class="clearfix"><a href="#" id="upload-body-background-image" class="button box-button">Upload Background Image</a></td>
									  <input type="hidden" class="headway-visual-editor-input" name="headway-config[body-background-image]" id="body-background-image-hidden" value="<?php echo $body_background_image ?>" />
								  </tr>


								  <tr>					
									  <th scope="row"><label class="tooltip" for="body-background-image-url" style="cursor: help;">OR Link Directly To Background Image</label></th>					
									  <td><input type="text" value="" id="body-background-image-url" class="headway-visual-editor-input" name="headway-config[body-background-image-url]"/></td>				
								  </tr>

								  <tr id="body-background-image-current-row" style="<?php echo $body_background_image_delete_display ?>">
									  <td colspan="2"><span id="body-background-image-current"><?php echo headway_get_option('body-background-image') ?></span> <a id="body-background-image-delete" href="#">Delete</a></td>
								  </tr>

									<?php 
									$repeat_value = headway_get_option('body-background-repeat') ? headway_get_option('body-background-repeat') : 'repeat';

									echo headway_build_visual_editor_input('radio', 'body', 'body-background-repeat', 'Background Tiling', 
										array(
											'Tile' => array('id' => 'background-repeat', 'value' => 'repeat'),
											'Tile Horizontally' => array('id' => 'background-repeat-x', 'value' => 'repeat-x'),
											'Tile Vertically' => array('id' => 'background-repeat-y', 'value' => 'repeat-y'),
											'No Tiling' => array('id' => 'background-no-repeat', 'value' => 'no-repeat')
										), 
										$repeat_value, false, false, 'Choose how you would like the body background image to be tiled.'); 

									?>

							</table>
						</div>
					</div>
				</div>
<?php } ?>
				
			    <div id="site-dimensions-tab">
					<table class="tab-options" id="site-dimensions-options">
						<?php echo headway_build_visual_editor_input('text', 'site-dimensions', 'wrapper-width', 'Wrapper Width', false, str_replace('px', '', headway_get_skin_option('wrapper-width')), false, true, 'The wrapper width is the width of the page.  All the leafs are in the wrapper.'); ?>
						<?php echo headway_build_visual_editor_input('text', 'site-dimensions', 'wrapper-margin', 'Wrapper Margin', false, headway_get_skin_option('wrapper-margin'), true, false, 'The wrapper margin is how far the wrapper is from the page border.  If you want it to be centered horizontally and have a top and bottom margin of 30px, you would type \'30px auto 30px auto\'.'); ?>
					</table>
			    </div>
			
			
			</div>
<?php
}

function navigation_panel_content(){
	$excluded_pages = headway_get_option('excluded_pages');	
		
	$inactive_pages = (is_array($excluded_pages) && $excluded_pages[0] != NULL) ? wp_list_pages(array('echo' => false, 'include' => implode(',', $excluded_pages), 'title_li' => false)) : NULL;

?>
	<div class="tabs">
			    <ul class="clearfix tabs">
					<?php if(!headway_nav_menu_check()){ ?>
			        <li><a href="#nav-utilities-tab">Utilities</a></li>
			    	<li><a href="#nav-options-tab">Options</a></li>
		            <li><a href="#nav-inactive-tab">Inactive Tabs</a></li>
					<?php } else { ?>
					<li><a href="#nav-menus-tab">Menus</a></li>						
				    <li><a href="#nav-options-tab">Options</a></li>						
					<?php } ?>
			    </ul>
			
				<?php if(headway_nav_menu_check()){ ?>
				<div id="nav-menus-tab">
					
					<p class="info-box clearfix">Using WordPress' menus function and Headway, you can choose which menu you would like to show in the navigation bar.  You can also change which menu you would like to use for individual pages in the WordPress page editor.</p>
					
					<p>
					<select name="headway-config[nav-menu]" class="headway-visual-editor-input">
						<?php
						$menus = wp_get_nav_menus();
						foreach ( $menus as $menu ) {							
							if ( wp_get_nav_menu_items($menu->term_id) ) {
								$nav_menu_selected = (headway_get_option('nav-menu') == $menu->slug) ? ' selected' : null;
								
								echo '<option value="'.$menu->slug.'"'.$nav_menu_selected.'>'.$menu->name.'</option>';
							}
						}
						?>
					</select>
					</p>
					
			    </div>
				<?php } else { ?>
				<div id="nav-utilities-tab">
					<ul class="list-buttons navigation-options-buttons">
						<li class="navigation"><span>Modify Navigation</span> <a href="" id="toggle-navigation" class="button">Enable</a></li>						
					</ul>
			    </div>
				<?php } ?>
			
			    <div id="nav-options-tab">
					<div id="navigation-options">
					
						<div class="sub-box minimize" id="sub-navigation-sub-box">
							<span class="sub-box-heading">Sub-Navigation</span>
						
							<div class="sub-box-content">
								<p class="radio-container">
									<input type="hidden" value="DELETE" class="headway-visual-editor-input" name="headway-config<?php echo headway_disabled_input_name('show-navigation-subpages') ?>[show-navigation-subpages]"/>
									<input type="checkbox"<?php echo headway_checkbox_value(headway_get_skin_option('show-navigation-subpages')) ?> class="radio headway-visual-editor-input" value="on" id="show-navigation-subpages" name="headway-config<?php echo headway_disabled_input_name('show-navigation-subpages') ?>[show-navigation-subpages]"<?php echo headway_disabled_input('show-navigation-subpages') ?> /><label for="show-navigation-subpages" class="tooltip" title="Enable or disable subpages from being shown in the navigation bar.">Show Navigation Subpages</label>						
								</p>


								<table class="tab-options full-width-table">

									<?php echo headway_build_visual_editor_input('text', 'navigation-options', 'sub-nav-width', 'Sub-Navigation Width', false, str_replace('px', '', headway_get_skin_option('sub-nav-width')), false, true, 'Change how wide the navigation is when you hover over a parent.') ?>


								</table>
							</div>
						</div>
					
						
						
						<div class="sub-box minimize" id="home-link-sub-box">
							<span class="sub-box-heading">Home Link</span>
						
							<div class="sub-box-content">
								<p class="radio-container">
									<input type="hidden" value="DELETE" class="headway-visual-editor-input" name="headway-config[hide-home-link]"/>
									<input type="checkbox"<?php echo headway_checkbox_value(headway_get_option('hide-home-link')) ?> class="radio headway-visual-editor-input" value="on" id="hide-home-link" name="headway-config[hide-home-link]"/><label for="hide-home-link" class="tooltip" title="Hide or show the home link from being shown.">Hide Navigation Home Link</label>						
								</p>

								<table class="tab-options full-width-table">
									<tr class="no-border">					
											<th scope="row"><label class="tooltip" for="home-link-text" style="cursor: help;">Home Link Text</label></th>					
											<td><input type="text" value="<?php echo headway_get_option('home-link-text') ?>" class="headway-visual-editor-input" id="home-link-text" name="headway-config[home-link-text]"/></td>				
									</tr>
								</table>
							</div>
						</div>
						
					</div>
					
			    </div>
			
				<?php if(!headway_nav_menu_check()){ ?>
			    <div id="nav-inactive-tab">
					<ul class="navigation" id="inactive-navigation">
						<?php echo $inactive_pages ?>
					</ul>
			    </div>
				<?php } ?>

			</div>
<?php
}
