<?php
function sidebar_leaf_inner($leaf){	
	if($leaf['new']){
		$leaf['options']['sidebar-name'] = 'Sidebar '.$leaf['id'];
	}
?>	
		<ul class="clearfix tabs">
	        <li><a href="#options-tab-<?php echo $leaf['id'] ?>">Options</a></li>
	        <li><a href="#look-feel-tab-<?php echo $leaf['id'] ?>">Look &amp; Feel</a></li>
	        <li><a href="#miscellaneous-tab-<?php echo $leaf['id'] ?>">Miscellaneous</a></li>
	    </ul>
	
		<div id="options-tab-<?php echo $leaf['id'] ?>">
			<table class="tab-options">
				<tr>					
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_sidebar_name">Sidebar Name (Shows in widgets panel)</label></th>
					<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][sidebar-name]" id="<?php echo $leaf['id'] ?>_sidebar_name" value="<?php echo $leaf['options']['sidebar-name'] ?>" /></td>	
				</tr>

				<tr>
					<td colspan="2">
						<p class="info-box">
							If you want this sidebar to be a duplicate, enter the other sidebar ID here. To get the ID of the other sidebar, hover over it and wait for the sidebar icon and leaf controls to pop up.  The ID is to the right of the icon.
							<img src="<?php bloginfo('template_directory') ?>/library/visual-editor/images/screenshots/sidebar_id.jpg" />
						</p>
					</td>
				</tr>

				<tr class="no-border">					
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_duplicate_id">Other Sidebar ID</label></th>
					<td><input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][duplicate-id]" id="<?php echo $leaf['id'] ?>_duplicate_id" value="<?php echo $leaf['options']['duplicate-id'] ?>" /></td>	
				</tr>
			</table>
		</div>
	
		<div id="look-feel-tab-<?php echo $leaf['id'] ?>">
			<table class="tab-options">
				<tr>	
					<td colspan="2"><p class="radio-container"><input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_horizontal_sidebar" name="leaf-options[<?php echo $leaf['id'] ?>][horizontal-sidebar]"<?php echo headway_checkbox_value($leaf['options']['horizontal-sidebar']) ?> /><label for="<?php echo $leaf['id'] ?>_horizontal_sidebar">Flip this sidebar horizontally.  Check this if you want a "widgetized" footer.</label></p></td>	
				</tr>

				<tr class="no-border">	
					<td colspan="2">
						<p class="radio-container">
							<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_disable_padding" name="leaf-options[<?php echo $leaf['id'] ?>][disable-padding]"<?php echo headway_checkbox_value($leaf['options']['disable-padding']) ?>/>
							<label for="<?php echo $leaf['id'] ?>_disable_padding">Disable padding on this sidebar.</label>
						</p>
					</td>	
				</tr>
			</table>
		</div>
	
		<div id="miscellaneous-tab-<?php echo $leaf['id'] ?>">
			<table class="tab-options">
				<tr>	
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_show_title">Leaf Title</label></th>	
					<td>
						<p class="radio-container">
							<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_show_title" name="config[<?php echo $leaf['id'] ?>][show-title]"<?php echo headway_checkbox_value($leaf['config']['show-title']) ?>/><label for="<?php echo $leaf['id'] ?>_show_title">Show Title</label>
						</p>
					</td>	
				</tr>

				<tr>					
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_leaf_title_link">Leaf Title Link</label></th>
					<td><input type="text" class="headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][leaf-title-link]" id="<?php echo $leaf['id'] ?>_leaf_title_link" value="<?php echo $leaf['config']['title-link'] ?>" /></td>	
				</tr>

				<tr class="no-border">					
					<th scope="row"><label for="<?php echo $leaf['id'] ?>_custom_css_classes">Custom CSS Class(es)</label></th>
					<td><input type="text" class="headway-visual-editor-input" name="config[<?php echo $leaf['id'] ?>][custom-css-classes]" id="<?php echo $leaf['id'] ?>_custom_css_classes" value="<?php echo $leaf['config']['custom-classes'] ?>" /></td>	
				</tr>
			</table>
		</div> 

	</div>
<?php
}

function sidebar_leaf_content($leaf){
?>
	<ul class="sidebar">
	<?php
	if($leaf['options']['duplicate-id']) $leaf['id'] = $leaf['options']['duplicate-id'];
	
	if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-'.$leaf['id'])){
	?>
		<li class="widget">
			<span class="widget-title">No widgets!</span>
			<p>Add widgets to this sidebar in the <a href="<?php bloginfo('wpurl') ?>/wp-admin/widgets.php">Widgets panel</a> under Appearance in the WordPress Admin.</p>
		</li>
	<?php
	} 
	?>
	</ul>
<?php
}
$options = array(
		'id' => 'sidebar',
		'name' => 'Widget Ready Sidebar',
		'options_callback' => 'sidebar_leaf_inner',
		'content_callback' => 'sidebar_leaf_content'
	);

$navigation_leaf = new HeadwayLeaf($options);