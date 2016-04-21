<!DOCTYPE HTML>
<html lang="en" style="background: #1c1c1c;">

	<head>
		
		<meta charset="<?php bloginfo('charset'); ?>" />
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
		
		<title>Visual Editor: Loading</title>
		
		<?php do_action('headway_visual_editor_head'); ?>
	
	</head><!-- /head -->

	<!-- This background color has been inlined to reduce the white flicker during loading. -->
	<body class="visual-editor-open visual-editor-mode-<?php echo HeadwayVisualEditor::get_current_mode() . ' ' . join(' ', get_body_class()); ?>" style="background: #1c1c1c;">
		
		<?php do_action('headway_visual_editor_body_open'); ?>
		
		<div id="ve-loading-overlay">
			<div class="cog-container"><div class="cog-bottom-left"></div><div class="cog-top-right"></div></div>
		</div><!-- #ve-loading-overlay -->
		
		<div id="menu">
			<span id="logo"></span>
		
			<ul id="modes" class="top-menu-nav">
				<?php do_action('headway_visual_editor_modes'); ?>
			</ul>
		
			<?php do_action('headway_visual_editor_menu'); ?>
		
			<div id="menu-right">
		
				<?php do_action('headway_visual_editor_menu_mode_buttons'); ?>

				<ul class="top-menu-nav">
					<li id="skins-button">
						<span>Templates</span>
					</li>
		
					<?php do_action('headway_visual_editor_menu_links'); ?>
				</ul>
		
				<div id="save-button-container" class="save-button-container" style="margin-right:-76px;">
					<span id="save-button" class="save-button">Save</span>
				</div>
		
			</div><!-- #menu-right -->
		</div><!-- #menu -->
		
		
		<!-- Skins Panel -->
		<div id="skins-panel">
		
			<div id="skins">
				
				<div id="skin-side-menu">
					<span id="upload-skin-button"><span class="icon-plus-sharp"></span>Add Template</span>
					<span id="open-export-skin-button"><span class="icon-cloud-download"></span>Export</span>
					<span id="add-blank-skin-button"><span class="icon-insert-template"></span>New Blank</span>
			
					<form id="upload-skin">
						<input type="file" />
					</form>
				</div>
				
				<div id="skin-selector">
					<?php
					$skins = array(
						'base' => array(
							'name' => 'Base',
							'author' => 'Headway Themes',
							'version' => HEADWAY_VERSION,
							'image-url' => headway_url() . '/screenshot.png'
						)
					);
					
					$installed_skins = HeadwayOption::get_group('skins');
					
					if ( !empty($installed_skins) && is_array($installed_skins) )
						$skins += $installed_skins;
						
					$current_skin_id = HeadwayOption::get('current-skin', 'general', HEADWAY_DEFAULT_SKIN);
					?>

					<h1>Available Templates</h2>
					<p>These are the template you currently have installed, your active template is <strong><?php echo headway_get('name', headway_get($current_skin_id, $installed_skins), 'Base') ?></strong>. Looking for more templates?  Visit <a href="http://headwaythemes.com/extend" target="_blank">Headway Extend</a></p>
		
					<div id="skins-scroller">
		
						<?php
						foreach ( $skins as $skin_id => $skin_options ) {
						
							$is_active = $skin_id == $current_skin_id ? true : false;

							$image = headway_resize_image(headway_get('image-url', $skin_options), 220, 190);

							if ( !$image )
								$image = headway_get('image-url', $skin_options);

							echo '
								<div class="skin' . ($is_active ? ' skin-activated' : null) . '" data-skin-id="' . $skin_id . '">
									<div class="skin-thumb">
										<span class="active-badge"></span>
										' . ( $image ? '<img src="" data-src="' . $image . '" alt="" />' : '') . '
										<div class="skin-toolbar">
											<span class="skin-version">' . headway_get('version', $skin_options) . '</span>
											' . ($skin_id != 'base' ? '<span class="skin-delete tooltip icon-remove skin-button" title="Delete Template"></span>' : '') . '
											<span class="skin-activate tooltip icon-checkmark-sharp skin-button" title="Activate Template"></span>
										</div>
									</div>
										<h2 class="skin-name">' . $skin_options['name'] . '</h2>
										' . ( headway_get('author', $skin_options) ? '<span class="skin-author">By ' . headway_get('author', $skin_options) . '</span>' : '') . '
										' . ( !empty($skin_options['description']) ? '<p class="skin-description">' . $skin_options['description'] . '</p>' : '') . '
								</div>
							';
		
						}
						?>
		
					</div><!-- #skins-scroller -->
				</div><!-- #skin-selector -->
		
				<div id="skin-export">
					<h1>Export Template</h1>
					<span id="export-skin-close"></span>
					<p>Fill out the information below to export all design settings, layouts, and blocks as a Headway Template</p>
		
					<form>
						<div>
							<input type="text" placeholder="Template Name" name="skin-export-info[name]" />
							<input type="text" placeholder="Template Author" name="skin-export-info[author]" />
						</div>
		
						<div>
							<input type="text" placeholder="Template Version (i.g. 1.0)" name="skin-export-info[version]" />
							<input type="text" placeholder="Template Image URL" name="skin-export-info[image-url]" />
						</div>
		
						<span class="skin-button" id="export-skin-button">Export</span>
					</form>
				</div>
			</div><!-- #skins -->
		</div>
		<div id="skins-panel-overlay"></div>
		<!-- End Skins Panel -->
		
		<!-- Big Boy iframe -->
		<div id="iframe-container">
			<?php
			$layout_url = HeadwayVisualEditor::get_current_mode() == 'grid' ? home_url() : HeadwayLayout::get_url(HeadwayLayout::get_current());
		
			$iframe_url = add_query_arg(array(
				've-iframe' => 'true',
				've-layout' => HeadwayLayout::get_current(),
				've-iframe-mode' => HeadwayVisualEditor::get_current_mode(),
				'rand' => rand(1, 999999)
			), $layout_url);
		
			echo '<iframe id="content" class="content" src="' . $iframe_url . '"></iframe>';
		
			?>
			
			<div id="iframe-overlay"></div>
			<div id="iframe-loading-overlay"><div class="cog-container"><div class="cog-bottom-left"></div><div class="cog-top-right"></div></div></div>
		</div>
		<!-- #iframe#content -->
		
		<div id="panel">
		
			<div id="panel-top-container">
		
				<ul id="panel-top">
		
					<?php do_action('headway_visual_editor_panel_top_tabs'); ?>
		
				</ul><!-- #ul#panel-top -->
		
				<ul id="panel-top-right">
		
					<?php do_action('headway_visual_editor_panel_top_right'); ?>
		
				</ul><!-- #ul#panel-top -->
		
			</div><!-- #div#panel-top-container -->
		
			<?php do_action('headway_visual_editor_content'); ?>
		
		</div><!-- div#panel -->
		
		
		<?php
		if ( has_action('headway_visual_editor_side_panel') ) {
		
			echo '<div id="side-panel-container">
		
				<div id="side-panel">';
		
					do_action('headway_visual_editor_side_panel');
		
			echo '</div><!-- #side-panel -->
		
			</div><!-- #side-panel-container -->';
		
		}
		?>
		
		
		<div id="boxes">
			<?php do_action('headway_visual_editor_boxes'); ?>
		</div><!-- div#boxes -->
		
		<?php do_action('headway_visual_editor_footer'); ?>
		
		<div id="notification-center"></div>
		
	</body>
</html>