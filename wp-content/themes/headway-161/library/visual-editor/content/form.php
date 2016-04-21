<?php

function insert_visual_editor_form(){
	global $user_level;
	get_currentuserinfo();
	if($_GET['visual-editor'] && headway_can_visually_edit())
	{
		add_action('headway_before_everything', 'form_start', 2);
		add_action('headway_after_everything', 'form_end', 2);
	}
}


function form_start(){
	global $close_url;
	
	$close_needle = (strpos(headway_current_url(), '&visual-editor=true')) ? '&visual-editor=true' : '?visual-editor=true';
	$close_url = str_replace(strstr(headway_current_url(), $close_needle), '', headway_current_url());
?>
<div id="headway-visual-editor">
		<input type="submit" value="Save All Changes" class="visual-editor-button headway-visual-editor-input" name="headway-ve-save" id="headway-save-button" />
		<span id="headway-save-load">Saving...</span>
		
		<div id="save-message">
			<h3>Saving complete!</h3>
			<a href="#" id="save-message-close">Close</a>
			
			<p id="save-message-paragraph">Some changes may not be visible, including the leaf options and site configuration, until <a href="<?php echo str_replace('&safe-mode=true', '', headway_current_url()) ?>" class="keep-active">reloading the visual editor</a>.</p>
			
			<p>				
				<a class="save-button" href="#" id="continue-editing">Continue Editing</a>
				<a class="save-button keep-active" href="<?php echo str_replace('&safe-mode=true', '', headway_current_url()) ?>">Reload Visual Editor</a>
				<a class="save-button keep-active" href="<?php echo $close_url ?>">Close Visual Editor</a>
			</p>
		</div>

		<?php 
		do_action('headway_visual_editor_top');
		
		$is_system_page = (headway_current_page(true)) ? 'true' : 'false';
		?>
		<input type="hidden" name="current-page" id="current-page" value="<?php echo headway_current_page() ?>" class="headway-visual-editor-input" />
		<input type="hidden" name="is-system-page" id="is-system-page" value="<?php echo $is_system_page ?>" class="headway-visual-editor-input" />
		<input type="hidden" name="current-real-page" id="current-real-page" value="<?php echo headway_current_page(false, true) ?>" class="headway-visual-editor-input" />
		<input type="hidden" name="layout-order" id="layout-order" value="unserialized" class="headway-visual-editor-input" />
		<input type="hidden" name="header-order" id="header-order" value="unserialized" class="headway-visual-editor-input" />
		<input type="hidden" name="nav_order[main]" id="navigation-order" value="unserialized" class="headway-visual-editor-input" />
		<input type="hidden" name="nav_order[inactive]" id="navigation-order-inactive" value="unserialized" class="headway-visual-editor-input" />
<?php
}

function form_end(){
?>
</div>
			<?php help_box(); ?>
<?php
}