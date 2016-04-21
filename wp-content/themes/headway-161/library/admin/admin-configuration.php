<h2>Headway Configuration</h2>

<?php
global $headway_force_queries;
$headway_force_queries = true;


if($_POST['submit']){
	
	do_action('headway_custom_option_actions');

	foreach($_POST as $key => $value){
	
		if($key == 'js_libraries_unchecked'){
			$libraries = (array)headway_get_option('js-libraries');
			
			foreach($value as $key => $value){
				$remove = array($key);
				
				$libraries = array_diff($libraries, $remove);
			}
			
			headway_update_option('js-libraries', $libraries);
			
			continue;
		}
		
		if($key == 'js_libraries'){
			$libraries = (array)headway_get_option('js-libraries');
			
			foreach($value as $key => $value){
				if(!in_array($key, $libraries)) array_push($libraries, $key);
			}
			
			headway_update_option('js-libraries', $libraries);
			
			continue;
		}
		
		if($key == 'skin-options'){
			foreach($value as $key => $value){
				$key = 'skin-'.headway_get_option('active-skin').'-'.$key;
				
				if(!$value) headway_delete_option($key);
			
				if(strpos($key, '_unchecked')):
					$key = str_replace('_unchecked', '', $key);
					if($_POST[$key] == NULL) headway_delete_option($key);
				endif;
			
				if($value) headway_update_option($key, $value);
			}
			
			continue;
		}
		
		if(!$value) headway_delete_option($key);
	
		if(strpos($key, '_unchecked')):
			$key = str_replace('_unchecked', '', $key);
			if($_POST[$key] == NULL) headway_delete_option($key);
		endif;
				
		if($value) headway_update_option($key, $value);
		
}
	
headway_update_option('css-last-updated', mktime());
	
?>
<div class="success"><span>Configuration Updated!</span> <a href="<?php echo get_bloginfo('wpurl')?>">View Site &raquo;</a></div>
<?php 
} elseif($_POST['reset-headway']){
	global $wpdb;
		
	$headway_elements_table = $wpdb->prefix.'headway_elements';
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';
	$headway_options_table = $wpdb->prefix.'headway_options';
	$headway_misc_table = $wpdb->prefix.'headway_misc';
	
	$wpdb->query("DROP TABLE IF EXISTS $headway_elements_table;");
	$wpdb->query("DROP TABLE IF EXISTS $headway_leafs_table;");
	$wpdb->query("DROP TABLE IF EXISTS $headway_options_table;");
	$wpdb->query("DROP TABLE IF EXISTS $headway_misc_table;");
?>
<div class="success"><span>Headway Reset!</span> <a href="<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=headway">If you're not redirected, click here.</a></div>
<meta http-equiv="refresh" content="2;url=<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=headway" />
<?php
} elseif($_POST['reset-leaf-template']){
	global $wpdb;
	$headway_leafs_table = $wpdb->prefix.'headway_leafs';

	$wpdb->query("DELETE FROM $headway_leafs_table WHERE page='leaf-template'");
	headway_delete_option('leaf-template-exists');
?>
<div class="success"><span>Leaf Template Reset!</span> <a href="<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=headway">If you're not redirected, click here.</a></div>
<meta http-equiv="refresh" content="2;url=<?php bloginfo('wpurl') ?>/wp-admin/admin.php?page=headway" />
<?php
}

if(!isset($_POST['reset-headway']) && !isset($_POST['reset-leaf-template'])){
	
//Memorable hook to be used to define the global in the plugin.
do_action('headway_skin_options');

//Get the skin options.
global $headway_skin_options;
?>


<form method="post">
	<div id="vertical-tab-container">
	<div id="tabs">
		<ul>
			<li><a href="#general-options">General Options</a></li>
			<?php if(isset($headway_skin_options)){ ?>
			<li><a href="#skin-options">Skin Options</a></li>				
			<?php } ?>
			<li><a href="#posts">Posts/Comments</a></li>
			<?php if(headway_user_level() >= 10 || current_user_can('manage_options')){ ?>
			<li><a href="#headway-permissions">Headway Permissions</a></li>
			<?php } ?>
			<li><a href="#headway-registration">Headway Registration</a></li>
			<li><a href="#headway-seo">Search Engine Optimization</a></li>
			<li><a href="#visual-editor-options">Visual Editor Options</a></li>
			<li><a href="#developer-options">Developer Options</a></li>
			<li><a href="#social-networking">Social Networking</a></li>
		</ul>
	
		<div id="general-options" class="tab">
			
			<h2>General Options</h2>
			
			<div class="inside">
				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="feed-url">Feed URL</label></th>
						<td><input type="text" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('feed-url'))) ?>" id="feed-url" name="feed-url"/>
						<span class="description">If you use any service like <a href="http://feedburner.google.com" target="_blank">FeedBurner</a>, type the feed URL here.</span></td>
					</tr>




					<tr valign="top">
						<th scope="row"><label for="header-scripts">Header Scripts</label></th>
						<td><textarea rows="10" class="regular-text" id="" name="header-scripts"><?php echo htmlentities(stripslashes(headway_get_option('header-scripts'))) ?></textarea>
						<span class="description">Anything here will go in the <code>&lt;head&gt;</code> of the website.</span></td>
					</tr>


					<tr valign="top">
						<th scope="row"><label for="footer-scripts">Footer Scripts</label></th>
						<td><textarea rows="10" class="regular-text" id="" name="footer-scripts"><?php echo htmlentities(stripslashes(headway_get_option('footer-scripts'))) ?></textarea>
						<span class="description">Anything here will be inserted before the <code>&lt;/body&gt;</code> tag of the website.  If you have any stats scripts such as <a href="http://www.google.com/analytics" target="_blank">Google Analytics</a>, paste them here. </span></td>
					</tr>




					<tr valign="top">
						<th scope="row"><abbr title="gzip is a software application used for file compression. gzip is short for GNU zip; the program is a free software replacement for the compress program used in early Unix systems, intended for use by the GNU Project.">gzip</abbr> Compression</th>
						<td> 
							<fieldset>
								<legend class="hidden">gzip Compression</legend>
								<label for="gzip">
									<?php headway_build_checkbox('gzip') ?>
									Enable <abbr title="gzip is a software application used for file compression. gzip is short for GNU zip; the program is a free software replacement for the compress program used in early Unix systems, intended for use by the GNU Project.">gzip</abbr> Compression
								</label>
							</fieldset>
						<span class="description"><abbr title="gzip is a software application used for file compression. gzip is short for GNU zip; the program is a free software replacement for the compress program used in early Unix systems, intended for use by the GNU Project.">gzip</abbr> compression allows your pages to load faster and make it easier on your visitors.  Compression is recommended, but some web hosts may not support gzip compression.</span></td>
					</tr>


					<tr valign="top">
						<th scope="row">Printer Stylesheet</th>
						<td> 
							<fieldset>
								<legend class="hidden">Printer Stylesheet</legend>
								<label for="print-css">
									<?php headway_build_checkbox('print-css') ?>
									Enable Printer Stylesheet
								</label>
							</fieldset>
						<span class="description">Printer stylesheets make websites more printer friendly to keep users from wasting paper/ink and to help them print what they want.  However, some prefer the printer stylesheets to be disabled.</span></td>
					</tr>


					<tr valign="top">
						<th scope="row"><label for="favicon">Favicon Location</label></th>
						<td><input type="text" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('favicon'))) ?>" id="favicon" name="favicon"/>
						<span class="description">A favicon is the little image that sits next to your address in the favorites menu and on tabs.  If you do not know how to save an image as an icon you can go to <a href="http://www.favicon.cc/" target="_blank">favicon.cc</a> and draw or import an image.</span></td>
					</tr>


					<tr valign="top">
						<th scope="row"><label for="affiliate-link">Affiliate Link <strong>(DO NOT PUT HTML)</strong></label></th>
						<td><input type="text" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('affiliate-link'))) ?>" id="affiliate-link" name="affiliate-link"/>
						<span class="description">If you're a member of the Headway Affiliate program (if not, you should definitely <a href="http://www.headwaythemes.com/affiliates/" target="_blank">sign up now!</a>), you can paste your affiliate link (found at the top of the affiliate panel) and earn money when someone purchases Headway through your affiliate link.</span></td>
					</tr>



				</tbody>
				</table>
			</div>
			
		</div>
		<!-- End General Options -->
		
		<?php if($headway_skin_options){ ?>
		<!-- Start Skin Options -->
		<div id="skin-options" class="tab">

			<h2>Skin Options</h2>
			
			<div class="inside">
				<table class="form-table">
				<tbody>
					<?php echo $headway_skin_options; ?>
				</tbody>
				</table>
			</div>
				
		</div>
		<!-- End Skin Options -->
		<?php } ?>
		
		<!-- Start Posts/Comments Options -->
		<div id="posts" class="tab">
			<h2>Posts/Comments</h2>
			
				<h3>Posts</h3>
				
				<table class="form-table">
				
					<?php echo headway_build_admin_input('text', 'posts', 'featured-posts', 'Featured Posts', false, headway_get_option('featured-posts'), false, false, 'Choose the number of featured posts.  Featured posts are what contain the full post (unless cut off by read more tag) on the blog.') ?>
					<?php echo headway_build_admin_input('check', 'posts', 'small-excerpts', 'Small Excerpts', 'Enable Small Excerpts', headway_get_option('small-excerpts'), false, false, 'Enable or disable small excerpts.  Small excerpts are the small posts that are in rows of 2.') ?>
					<?php echo headway_build_admin_input('check', 'posts', 'disable-excerpts', 'Disable Excerpts', 'Disable Excerpts', headway_get_option('disable-excerpts'), true, false, 'Disable excerpts if you wish to display full posts on the blog and not rely on featured posts.') ?>
				
				</table>
				
				
				<h2>Post Thumbnails</h2>
				
				<table class="form-table">
					<?php echo headway_build_admin_input('text', 'posts', 'post-thumbnail-width', 'Post Thumbnail - Width', false, headway_get_option('post-thumbnail-width'), true, true) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-thumbnail-height', 'Post Thumbnail - Height', false, headway_get_option('post-thumbnail-height'), true, true) ?>
				</table>
				
				<h3 class="border-top">Post Meta</h3>
				
				<table class="form-table" id="posts-meta-options">
					<tr>
						<td colspan="2">
							<p class="info-box clearfix">You can use the following variables in the inputs below.  Drag the variable(s) to the desired text boxes or simply type the variable(s) in. <strong>Hover over each one more information.</strong>.<br /> 
							
								<a href="%date%" class="variable button-secondary" title="Will return the date of the post and will be displayed in the format you choose above.">%date%</a>
								<a href="%author%" class="variable button-secondary" title="Displays the author of the post.">%author%</a>
								<a href="%author_no_link%" class="variable button-secondary" title="Displays the author of the post, but doesn't surround it in a hyperlink.">%author_no_link%</a>
								<a href="%categories%" class="variable button-secondary" title="Shows the post categories and their links.">%categories%</a>
								<a href="%comments%" class="variable button-secondary" title="Shows the number of comments and the link to the comments in the post. Customize the format in the 'Date/Comments Meta Format Format' tab.">%comments%</a>
								<a href="%comments_link%" class="variable button-secondary" title="Does the same exact thing as %comments%, but surrounds it in a hyperlink linking to the post comments.">%comments_link%</a>
								<a href="%respond%" class="variable button-secondary" title="Shows a link that will take a visitor directly to the comment form to leave a comment.">%respond%</a>
								<a href="%tags%" class="variable button-secondary" title="Shows the posts tags.">%tags%</a>
								<a href="%edit%" class="variable button-secondary" title="If an admin, editor, or author is logged in they will be able to see this link and edit the post.">%edit%</a>
								
							</p>
						</td>
					</tr>

					<?php echo headway_build_admin_input('text', 'posts', 'post-above-title-left', 'Above Title - Left', false, headway_get_option('post-above-title-left')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-above-title-right', 'Above Title - Right', false, headway_get_option('post-above-title-right')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-below-title-left', 'Below Title - Left', false, headway_get_option('post-below-title-left')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-below-title-right', 'Below Title - Right', false, headway_get_option('post-below-title-right')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-below-content-left', 'Below Content - Left', false, headway_get_option('post-below-content-left')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-below-content-right', 'Below Content - Right', false, headway_get_option('post-below-content-right'), true) ?>
				

					<tr>					
						<th scope="row"><label for="post-date-format">Date Format</label></th>					
						<td>
							<select id="post-date-format" name="post-date-format">
									<option value="1"<?php echo headway_option_value(headway_get_option('post-date-format'), '1') ?>>January 1, 2009</option>
									<option value="2"<?php echo headway_option_value(headway_get_option('post-date-format'), '2') ?>>MM/DD/YY</option>
									<option value="3"<?php echo headway_option_value(headway_get_option('post-date-format'), '3') ?>>DD/MM/YY</option>
									<option value="4"<?php echo headway_option_value(headway_get_option('post-date-format'), '4') ?>>Jan 1</option>
									<option value="5"<?php echo headway_option_value(headway_get_option('post-date-format'), '5') ?>>Jan 1, 2009</option>
									<option value="6"<?php echo headway_option_value(headway_get_option('post-date-format'), '6') ?>>January 1</option>
									<option value="7"<?php echo headway_option_value(headway_get_option('post-date-format'), '7') ?>>January 1st</option>
									<option value="8"<?php echo headway_option_value(headway_get_option('post-date-format'), '8') ?>>January 1st, 2009</option>
							</select>
						</td>				
					</tr>
					
					<tr>
						<td colspan="2">
							<p class="info-box clearfix">In the following comment format forms, you are allowed to use the following variable.  Drag the variable to the desired text box or simply type the variable in. <strong>Hover for more information.</strong>.<br /> <a href="%num%" class="variable button-secondary" title="Shows the numbers of comments.">%num%</a></p>
						</td>
					</tr>
					

					<?php echo headway_build_admin_input('text', 'posts', 'post-comment-format-0', 'Comment Format — 0 Comments', false, headway_get_option('post-comment-format-0')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-comment-format-1', 'Comment Format — 1 Comment', false, headway_get_option('post-comment-format-1')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-comment-format', 'Comment Format — More Than 1 Comment', false, headway_get_option('post-comment-format')) ?>
					<?php echo headway_build_admin_input('text', 'posts', 'post-respond-format', 'Respond Format', false, headway_get_option('post-respond-format')) ?>
				</table>
				
				<h3 class="border-top">Comments</h3>
				
				
				<table class="form-table">
					
				<?php echo headway_build_admin_input('check', 'comments', 'show-avatars', 'Commenter Avatars', 'Show Commenter Avatars', headway_get_option('show-avatars'), false, false, 'Show commenter avatars.  Avatars are the small pictures beside the comment.') ?>
				<?php echo headway_build_admin_input('check', 'comments', 'page-comments', 'Page Comments', 'Show Comments On Pages', headway_get_option('page-comments'), false, false, 'Enable or disable page comments.  Comments on pages are generally not recommended.') ?>
				<?php echo headway_build_admin_input('text', 'comments', 'default-avatar', 'Default Avatar URL', false, headway_get_option('default-avatar'), false, false, 'Type the URL to the default URL (could be your logo or anything).  This will replace the traditional grey mystery man.') ?>
				<?php echo headway_build_admin_input('text', 'comments', 'avatar-size', 'Avatar Size', false, headway_get_option('avatar-size'), true, true, 'Enter the square dimension of the avatars.  The default is 48px.  If you want it to be 36 pixels, you\'d simply type 36.') ?>
				
				</table>
				
				<h3 class="border-top">Miscellaneous</h3>
				
				
				<table class="form-table">
				
					<?php echo headway_build_admin_input('text', 'posts', 'read-more-text', 'Read More Text', false, headway_get_option('read-more-text')) ?>
				
				</table>
				
		</div>
		<!-- End Posts/Comments Options -->
		
	
	
		<?php if(headway_user_level() >= 10 || current_user_can('manage_options')){ ?>
		<!-- Start Permissions -->
		<div id="headway-permissions" class="tab">
			<h2>Permissions</h2>
			
				<p>With Headway you can easily limit the access to certain features.  Choose which user role you would like to be required for each feature.</p>

				<h3>Visual Editor</h3>
				<table class="form-table">
				<tbody>
			
					<tr>
						<th scope="row"><label for="permissions-visual-design-editor">Visual Design Editor</th>
						<td>
							<select name="permissions-visual-design-editor" id="permissions-visual-design-editor">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-visual-design-editor')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-visual-design-editor')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-visual-design-editor')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-visual-design-editor')) ?>>Contributor</option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="permissions-site-configuration">Site Configuration</th>
						<td>
							<select name="permissions-site-configuration" id="permissions-site-configuration">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-site-configuration')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-site-configuration')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-site-configuration')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-site-configuration')) ?>>Contributor</option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="permissions-leafs">Leafs</th>
						<td>
							<select name="permissions-leafs" id="permissions-leafs">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-leafs')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-leafs')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-leafs')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-leafs')) ?>>Contributor</option>
							</select>
						</td>
					</tr>


					<tr>
						<th scope="row"><label for="permissions-navigation">Navigation</th>
						<td>
							<select name="permissions-navigation" id="permissions-navigation">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-navigation')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-navigation')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-navigation')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-navigation')) ?>>Contributor</option>
							</select>
						</td>
					</tr>



				</tbody>
				</table>	

				<h3 class="border-top">Admin</h3>
				<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="permissions-headway-configuration">Headway Configuration</th>
						<td>
							<select name="permissions-headway-configuration" id="permissions-headway-configuration">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-headway-configuration')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-headway-configuration')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-headway-configuration')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-headway-configuration')) ?>>Contributor</option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="permissions-advanced-leafs">Advanced Leafs</th>
						<td>
							<select name="permissions-advanced-leafs" id="permissions-advanced-leafs">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-advanced-leafs')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-advanced-leafs')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-advanced-leafs')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-advanced-leafs')) ?>>Contributor</option>
							</select>
						</td>
					</tr>

					<tr>
						<th scope="row"><label for="permissions-easy-hooks">Easy Hooks</th>
						<td>
							<select name="permissions-easy-hooks" id="permissions-easy-hooks">
								<option value="10"<?php echo headway_option_value('10', headway_get_option('permissions-easy-hooks')) ?>>Administrator</option>
								<option value="6"<?php echo headway_option_value('6', headway_get_option('permissions-easy-hooks')) ?>>Editor</option>
								<option value="3"<?php echo headway_option_value('3', headway_get_option('permissions-easy-hooks')) ?>>Author</option>
								<option value="1"<?php echo headway_option_value('1', headway_get_option('permissions-easy-hooks')) ?>>Contributor</option>
							</select>
						</td>
					</tr>
				</tbody>
				</table>
		</div>
		<!-- End Permissions -->
		
		<?php } ?>
		
		
		<!-- Start Headway Registration -->
		<div id="headway-registration" class="tab">

			<h2>Headway Registration</h2>

				<p>Enter your username and password that you use to get to the Headway members' area to get inline documentation.</p>
				<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="headway-username">Headway Username</th>
						<td><input type="text" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('headway-username'))) ?>" id="headway-username" name="headway-username" />
						</td>
					</tr>


					<tr>
						<th scope="row"><label for="headway-password">Headway Password</th>
						<td><input type="password" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('headway-password'))) ?>" id="headway-password" name="headway-password"/>
						</td>
					</tr>


				</tbody>
				</table>
		</div>
		<!-- End Headway Registration -->
		

		<!-- Start SEO -->
		<div id="headway-seo" class="tab">
			<h2>Search Engine Optimization</h2>
			<?php if(class_exists('All_in_One_SEO_Pack')){ ?>
				<p class="notice">Headway has detected that you're running All in One SEO Pack.  In order to avoid conflict, the Headway SEO settings are disabled.  If you wish to, you can continue using All in One SEO pack or you can deactivate it and use Headway's SEO features.</p>
			<?php } else { ?>
				<p class="notice"><b>Warning:</b> We recommend that if you do not know what a particular option does here, don't mess with it until you have familiarized yourself with this section by reading <a href="http://headwaythemes.com/documentation/search-engine-optimization/configuration/">Headway Search Engine Optimization &rsaquo; Configuration</a>.</p>

							<h3>Title</h3>

							<table class="form-table">
							<tbody>
								<tr>
									<th scope="row"><label for="title-home">Home Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-home'))?>" id="title-home" name="title-home" /> 
									<span class="description"><br /><span class="available-variables">Available Variables:</span>
										<ul>
											<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
											<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
										</ul>
									</span></td>
								</tr>

								<?php if(get_option('page_for_posts') != get_option('page_on_front')): ?>
								<tr>
									<th scope="row"><label for="title-posts-page">Posts Page Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-posts-page'))?>" id="title-posts-page" name="title-posts-page" /> 
									<span class="description"><br /><span class="available-variables">Available Variables:</span>
										<ul>
											<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
											<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
										</ul>
									</span></td>
								</tr>				
								<?php endif; ?>

								<tr>
									<th scope="row"><label for="title-page">Page Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-page'))?>" id="title-page" name="title-page" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%page%</code> - Will return the title of the current page you are on.</li>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>





								<tr>
									<th scope="row"><label for="title-single">Single Post Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-single'))?>" id="title-single" name="title-single" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%postname%</code> - Will return the name of the current post you are viewing.</li>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>



								<tr>
									<th scope="row"><label for="title-404">404 Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-404'))?>" id="title-404" name="title-404" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>

								<tr>
									<th scope="row"><label for="title-category">Category Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-category'))?>" id="title-category" name="title-category" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%category%</code> - Will return the current category archive you are viewing.</li>
												<li><code>%category_description%</code> - Will return the description of the category that is being viewed.  You can define a category's description in the <a href="<?php bloginfo('wpurl') ?>/wp-admin/categories.php" target="_blank">Posts &rsaquo; Categories</a> page.</li>								
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>

								<tr>
									<th scope="row"><label for="title-tag">Tag Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-tag'))?>" id="title-tag" name="title-tag" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%tag%</code> - Will return the current tag you are viewing.</li>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>

								<tr>
									<th scope="row"><label for="title-archives">Archives Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-archives'))?>" id="title-archives" name="title-archives" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%archive%</code> - Will return the current archive you are viewing.  For example, <?php echo date('F Y')?>.</li>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>

								<tr>
									<th scope="row"><label for="title-search">Search Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-search'))?>" id="title-search" name="title-search" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%search%</code> - Will return the search query.  For example, when someone searches for 'WordPress', the <code>%search%</code> variable would be WordPress.</li>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%tagline%</code> - <?php echo get_bloginfo('description')?></li>
											</ul>
										</span></td>
								</tr>






								<tr>
									<th scope="row"><label for="title-author-archives">Author Archives Title</th>
									<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('title-author-archives'))?>" id="title-author-archives" name="title-author-archives" />
										<span class="description"><br /><span class="available-variables">Available Variables:</span>
											<ul>
												<li><code>%blogname%</code> - <?php echo get_bloginfo('name')?></li>
												<li><code>%author_name%</code> - Will return the author's "nicename".  This is set in the users panel of WordPress.</li>
												<li><code>%author_description%</code> - This will return the author's description.  This is changed inthe users panel in WordPress by editing the Bio box.</li>
											</ul>
										</span></td>
								</tr>





							</tbody>
							</table>

							<h3 class="border-top"><code>META</code> Content</h3>

							<table class="form-table">
							<tbody>

								<tr valign="top">
									<th scope="row"><label for="home-description">Home Description</label></th>
									<td><textarea rows="5" cols="45" class="regular-text" id="" name="home-description"><?php echo stripslashes(headway_get_option('home-description'))?></textarea>
									<span class="description">This will be the META description for the homepage.  The META description is what shows up underneath your website name in Google.  If this is left blank then it will default to no description.</span></td>
								</tr>

								<tr valign="top">
									<th scope="row"><label for="home-keywords">Home Keywords</label></th>
									<td><textarea rows="5" cols="45" class="regular-text" id="" name="home-keywords"><?php echo stripslashes(headway_get_option('home-keywords'))?></textarea>
									<span class="description">Place relevant words about your website in here separated by commas.  Be sure to not overload this, try to keep it below 10-15 keywords.</span></td>
								</tr>


								<tr valign="top">
									<th scope="row">Treat Categories as META Keywords</th>
									<td> 
										<fieldset>
											<legend class="hidden">Treat Categories as META Keywords</legend>
											<label for="categories-meta">
												<?php headway_build_checkbox('categories-meta') ?>
												Treat Categories as META Keywords
											</label>
										</fieldset>
									<span class="description">If this is enabled the categories of a specific post will be appended to the <code>META</code> keywords of a post.  You can add keywords to a post in the write panel under the Search Engine Optimization box.</span></td>
								</tr>



								<tr valign="top">
									<th scope="row">Treat Tags as META Keywords</th>
									<td> 
										<fieldset>
											<legend class="hidden">Treat Tags as META Keywords</legend>
											<label for="tags-meta">
												<?php headway_build_checkbox('tags-meta') ?>
												Treat Tags as META Keywords
											</label>
										</fieldset>
									<span class="description">If this is enabled the tags of a specific post will be appended to the <code>META</code> keywords of a post.  You can add keywords to a post in the write panel under the Search Engine Optimization box.</span></td>
								</tr>




								<tr valign="top">
									<th scope="row">Canonical URLs</th>
									<td> 
										<fieldset>
											<legend class="hidden">Canonical URLs</legend>
											<label for="canonical">
												<?php headway_build_checkbox('canonical') ?>
												Enable Canonical URLs
											</label>
										</fieldset>
									<span class="description">Canonical URLs tell search engines how to treat duplicate content, which increases your rating.  When search engines detect duplicate content they will not know which to index therefore hurting you.  Canonical URLs will fix this.</span></td>
								</tr>



							</tbody>
							</table>



							<h3 class="border-top"><code>nofollow</code> Configuration</h3>

							<table class="form-table">
							<tbody>
								<tr valign="top">
									<th scope="row">Comment Authors' URL</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add nofollow To Comment Authors' URLs</legend>
											<label for="nofollow-comment-author">
												<?php headway_build_checkbox('nofollow-comment-author') ?>
												Add nofollow To Comment Authors' URL
											</label>
										</fieldset>
									<span class="description">Adding <code>nofollow</code> to the comment authors' URLs will tell search engines to not visit their website and to stay on yours.  Many bloggers frown upon this, which can sometimes discourage comments.  Only enable this if you are 100% sure you know you want to.</span></td>
								</tr>

								<tr valign="top">
									<th scope="row">Home Page Link</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add nofollow To Home Page Link</legend>
											<label for="nofollow-home">
												<?php headway_build_checkbox('nofollow-home') ?>
												Add nofollow To Home Page Link
											</label>
										</fieldset>
									<span class="description">Setting the Home link to nofollow prevents Google from tracing this link back to your blogs' home page with the word "home" as the link text (the word "home" is useful for people but meaningless for SEO). Your home page link in your blog's header is still followed by Google. If you move your navigation bar above the header, and the home link becomes the first link on the page, Google will follow it anyway, even if you set it as nofollow (this is called "first link priority").</span></td>
								</tr>

								<p>If you need to add <code>nofollow</code> to any other page, there is an option in the Search Engine Optimization box on the write page.</p>
							</tbody>
							</table>


							<h3 class="border-top"><code>noindex</code> Configuration</h3>

							<table class="form-table">
							<tbody>

								<p>We recommend that you add <code>noindex</code> to the following.  Doing so will help avoid duplicate indexing, thus helping your SEO.  This will keep the posts in focus for the search engine instead of indexing all the category archives, chronological archives, and tags archives.</p>

								<tr valign="top">
									<th scope="row">Category Archives</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add noindex To Category Archives</legend>
											<label for="noindex-category-archives">
												<?php headway_build_checkbox('noindex-category-archives') ?>
												Add noindex To Category Archives
											</label>
										</fieldset>
									</td>
								</tr>



								<tr valign="top">
									<th scope="row">Archives</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add noindex To Archives</legend>
											<label for="noindex-archives">
												<?php headway_build_checkbox('noindex-archives') ?>
												Add noindex To Archives
											</label>
										</fieldset>
									</td>
								</tr>





								<tr valign="top">
									<th scope="row">Tag Archives</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add noindex Tag Archives</legend>
											<label for="noindex-tag-archives">
												<?php headway_build_checkbox('noindex-tag-archives') ?>
												Add noindex To Tag Archives
											</label>
										</fieldset>
									</td>
								</tr>




								<tr valign="top">
									<th scope="row">Author Archives</th>
									<td> 
										<fieldset>
											<legend class="hidden">Add noindex To Author Archives</legend>
											<label for="noindex-author-archives">
												<?php headway_build_checkbox('noindex-author-archives') ?>
												Add noindex To Author Archives
											</label>
										</fieldset>
									</td>
								</tr>


								<p>Much like <code>nofollow</code>, you have the option to enable <code>noindex</code> in the Search Engine Optimization box on the write panel for all pages and posts.</p>




							</tbody>
							</table>
							
						
							<h3 class="border-top">SEO Slugs</h3>

							<table class="form-table">
							<tbody>

								<p>SEO Slug Clean-up will scrub your slugs (the end of the URL, such as /about or /post-name) and remove numbers and words such as a, the, new, etc.</p>

								<tr valign="top">
									<th scope="row">SEO Slug Clean-up</th>
									<td> 
										<fieldset>
											<legend class="hidden">SEO Slug Clean-up</legend>
											<label for="seo-slugs">
												<?php headway_build_checkbox('seo-slugs') ?>
												Enable SEO Slug Clean-up
											</label>
										</fieldset>
									</td>									
								</tr>
								
								
								<tr valign="top">
									<th scope="row"><label for="home-keywords">SEO Slug Bad Words</label></th>
									<?php									
									$bad_words = array_map('headway_filter_array_piece', array_filter(explode("\n", headway_get_option('seo-slug-bad-words'))));
									
									sort($bad_words);
																		
									$bad_words = stripslashes(implode("\n", $bad_words));
									?>
									
									<td><textarea rows="15" cols="45" class="regular-text" id="" name="seo-slug-bad-words"><?php echo $bad_words ?></textarea>
									<span class="description">Place words that you would like to be removed from the SEO slugs.  Every line denotes a new word.</span></td>
								</tr>
								

							</tbody>
							</table>
							
						<?php } ?>
				
		</div>
		<!-- End SEO -->
		
		
		<!-- Start Visual Editor Options -->
		<div id="visual-editor-options" class="tab">

			<h2>Visual Editor Options</h2>

				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Visual Design Editor</th>
						<td> 
							<fieldset>
								<legend class="hidden">Disable Design Panel</legend>
								<label for="disable-visual-editor">
									<?php headway_build_checkbox('disable-visual-editor') ?>
									Disable Visual Design Editor
								</label>
							</fieldset>
							<span class="description">Disabling the Visual Design Editor will temporarily disable the Design panel and speed up loading times in the visual editor.  This will keep all of the design changes you've made, but you will not be able to make any design changes when disabled.</span></td>
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Visual Editor Link</th>
						<td> 
							<fieldset>
								<legend class="hidden">Hide Visual Editor Link</legend>
								<label for="categories-meta">
									<?php headway_build_checkbox('hide-visual-editor-link') ?>
									Hide Visual Editor Link
								</label>
							</fieldset>
						<span class="description">Hide the visual editor link on the front-end of your site (this will hide it for you and all who use the visual editor, guests will never be able to see the link).  You'll still be able to access the visual editor via the link in the WordPress admin under Appearance.</span></td>
					</tr>
					

				</tbody>
				</table>
		</div>
		<!-- End Visual Editor Options -->
		
		
		<!-- Start Developer Options -->
		<div id="developer-options" class="tab">

			<h2>Developer Options</h2>

				<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row">Visual Editor Developer Mode</th>
						<td> 
							<fieldset>
								<legend class="hidden">Enable Developer Mode</legend>
								<label for="enable-developer-mode">
									<?php headway_build_checkbox('enable-developer-mode') ?>
									Enable Developer Mode
								</label>
							</fieldset>
							<span class="description">Enabling developer mode will remove the Design panel from the visual editor.  If you're a developer and want to rely only custom CSS, enable developer mode.  Enabling this will ignore all changes in the design panel and revert to the default.</span></td>
							
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row">JavaScript Libraries</th>
						<td> 
							
							<span class="description">In order to speed up development time and less time scrounging to install JS libraries, use the checkboxes below to choose which JS libraries you would like to be loaded on your site.  These will be loaded site-wide.  Click on each library for more information.</span>
							
							<fieldset id="js-libraries">
								
								<legend class="hidden">JS Libraries</legend>
								
								<label>
									<input type="hidden" name="js_libraries_unchecked[unitpngfix]" id="js-unitpngfix" value="0" />
									<input type="checkbox" name="js_libraries[unitpngfix]" id="js-unitpngfix" value="1"<?php if(in_array('unitpngfix', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://labs.unitinteractive.com/unitpngfix.php" class="help" target="_blank">Unit PNG Fix (Internet Explorer .png Image Fix)</a>
								</label>
								
								<label>
									<input type="hidden" name="js_libraries_unchecked[jquery]" id="js-jquery" value="0" />
									<input type="checkbox" name="js_libraries[jquery]" id="js-jquery" value="1"<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									 <a href="http://jquery.com/" class="help" target="_blank">jQuery</a>
								</label>

								<label class="dependency dependency-jquery<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">
									<input type="hidden" name="js_libraries_unchecked[jquery-ui]" id="js-jquery-ui" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui]" id="js-jquery-ui" value="1"<?php if(in_array('jquery-ui', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />                     
									<a href="http://jqueryui.com/" class="help" target="_blank">jQuery UI Core</a>                                                                                                                  
								</label>     								   
							                                                                                                                                    
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-tabs]" id="js-jquery-ui-tabs" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-tabs]" id="js-jquery-ui-tabs" value="1"<?php if(in_array('jquery-ui-tabs', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/tabs/" class="help" target="_blank">jQuery UI Tabs</a>                                                                                                                      
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui dependency-jquery-ui-draggable dependency-jquery-ui-droppable<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-sortable]" id="js-jquery-ui-sortable" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-sortable]" id="js-jquery-ui-sortable" value="1"<?php if(in_array('jquery-ui-sortable', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/sortable/" class="help" target="_blank">jQuery UI Sortable</a>                                                                                                                 
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-draggable]" id="js-jquery-ui-draggable" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-draggable]" id="js-jquery-ui-draggable" value="1"<?php if(in_array('jquery-ui-draggable', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/draggable/" class="help" target="_blank">jQuery UI Draggable</a>                                                                                                            
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-droppable]" id="js-jquery-ui-droppable" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-droppable]" id="js-jquery-ui-droppable" value="1"<?php if(in_array('jquery-ui-droppable', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/droppable/" class="help" target="_blank">jQuery UI Droppable</a>                                                                                                         
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-selectable]" id="js-jquery-ui-selectable" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-selectable]" id="js-jquery-ui-selectable" value="1"<?php if(in_array('jquery-ui-selectable', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/selectable/" class="help" target="_blank">jQuery UI Selectable</a>                                                                                                        
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-resizable]" id="js-jquery-ui-resizable" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-resizable]" id="js-jquery-ui-resizable" value="1"<?php if(in_array('jquery-ui-resizable', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/resizable/" class="help" target="_blank">jQuery UI Resizable</a>                                                                                      
								</label>                                                                                                                                
								                                                                                                                                        
								<label class="dependency dependency-jquery dependency-jquery-ui<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">                                                                                                                                 
									<input type="hidden" name="js_libraries_unchecked[jquery-ui-dialog]" id="js-jquery-ui-dialog" value="0" />                                                
									<input type="checkbox" name="js_libraries[jquery-ui-dialog]" id="js-jquery-ui-dialog" value="1"<?php if(in_array('jquery-ui-dialog', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jqueryui.com/demos/dialog/" class="help" target="_blank">jQuery UI Dialog</a>
								</label>
								
								<label class="dependency dependency-jquery<?php if(in_array('jquery', (array)headway_get_option('js-libraries'))) echo ' dependency-show'; ?>">
									<input type="hidden" name="js_libraries_unchecked[thickbox]" id="js-thickbox" value="0" />
									<input type="checkbox" name="js_libraries[thickbox]" id="js-thickbox" value="1"<?php if(in_array('thickbox', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://jquery.com/demo/thickbox/" class="help" target="_blank">Thickbox</a>
								</label>
								
								<label>
									<input type="hidden" name="js_libraries_unchecked[swfobject]" id="js-swfobject" value="0" />
									<input type="checkbox" name="js_libraries[swfobject]" id="js-swfobject" value="1"<?php if(in_array('swfobject', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://code.google.com/p/swfobject/" class="help" target="_blank">SWFObject</a>
								</label>
								
								<label>
									<input type="hidden" name="js_libraries_unchecked[prototype]" id="js-prototype" value="0" />
									<input type="checkbox" name="js_libraries[prototype]" id="js-prototype" value="1"<?php if(in_array('prototype', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://www.prototypejs.org/" class="help" target="_blank">Prototype</a>
								</label>
								
								<label class="dependency-prototype">
									<input type="hidden" name="js_libraries_unchecked[scriptaculous]" id="js-scriptaculous" value="0" />
									<input type="checkbox" name="js_libraries[scriptaculous]" id="js-scriptaculous" value="1"<?php if(in_array('scriptaculous', (array)headway_get_option('js-libraries'))) echo ' checked'; ?> />
									<a href="http://script.aculo.us/" class="help" target="_blank">Scriptaculous</a>
								</label>

							</fieldset>
							
							</td>
							
						</td>
					</tr>
					
					
					
					<tr>
						<th scope="row">Visual Editor Safe Mode</th>
						
						<td>
							<p style="margin-top: 0;">If you accidentally messed up the layout by inserting code into the layout and are unable to delete the leaf, you can enter the visual editor using safe mode.</p>
							<p><strong>WARNING:</strong> Your layout may appear completely different in safe mode.  Try making the desired changes, save, then re-enter the visual editor to enter the visual editor in normal mode.</p>
							<a href="<?php echo get_bloginfo('wpurl') ?>/?visual-editor=true&amp;safe-mode=true" target="_blank"><strong>Enter Visual Editor &mdash; Safe Mode</strong></a>
						</td>
					</tr>
					
					
					<tr valign="top">
						<th scope="row">Reset Default Leaf Template</th>
						<td> 
							<input type="submit" value="Reset Leaf Template" name="reset-leaf-template" id="reset-leaf-template" class="button-secondary" />
						<span class="description">Resetting the leaf template will remove the template that is used every time a new page is created.  After clicking this button, it will revert to the standard content leaf as the layout.</span></td>
					</tr>
					
					<tr valign="top">
						<th scope="row">Reset Headway</th>
						<td> 
							<input type="submit" value="Completely Reset Headway" name="reset-headway" id="reset-headway" class="button-secondary" />
						<span class="description">Resetting Headway will remove all Headway customization, settings and data.  Or in other words, go back to the "Factory Default".</span></td>
					</tr>
					
				</tbody>
				</table>

		</div>
		<!-- End Headway Registration -->
		
		
		<!-- Start Social Networking -->
		<div id="social-networking" class="tab">

			<h2>Social Networking</h2>

				<p>Headway can automatically publish a Tweet when you write a new post.  Don't worry, your information will not be sent to anyone but Twitter.</p>
				<table class="form-table">
				<tbody>
					<tr>
						<th scope="row"><label for="twitter-username">Twitter Username</th>
						<td><input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('twitter-username')) ?>" id="twitter-username" name="twitter-username" />
						</td>
					</tr>


					<tr>
						<th scope="row"><label for="twitter-password">Twitter Password</th>
						<td><input type="password" class="regular-text" value="<?php echo stripslashes(headway_get_option('twitter-password')) ?>" id="twitter-password" name="twitter-password"/>
						</td>
					</tr>


					<tr>
						<th scope="row"><label for="tweet-format">Tweet Format</label></th>
						<td><input type="text" class="regular-text" value="<?php echo htmlentities(stripslashes(headway_get_option('tweet-format'))) ?>" id="tweet-format" name="tweet-format" /> &nbsp; Available variables: <code>%postname%</code> <code>%category%</code> <code>%blogname%</code> <code>%url%</code><br />
						<span class="description">This is how Headway will send the Tweet to Twitter (gotta love the Twitter terminology).  Use the variables listed to get the desired look.</span></td>
					</tr>




					<tr valign="top">
						<th scope="row">Post to Twitter by Default</th>
						<td> 
							<fieldset>
								<legend class="hidden">Post to Twitter by Default</legend>
								<label for="post-to-twitter">
									<?php headway_build_checkbox('post-to-twitter') ?>
									Post to Twitter by Default
								</label>
							</fieldset>
						</td>
					</tr>


				</tbody>
				</table>

		</div>
		<!-- End Social Networking -->
			
	</div>
	<!-- End Tabs -->


	<p class="submit">
	<input type="submit" value="Save Changes" class="button-primary" name="submit" />
	</p>
	</div>
</form>
<?php
}
?>