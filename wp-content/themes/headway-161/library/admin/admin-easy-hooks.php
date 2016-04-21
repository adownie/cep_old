<h2>Headway Easy Hooks</h2>

<p>Headway Easy Hooks provides you a simple way to add content to your site that would otherwise be impossible (without hacking, of course).  You can use HTML in the following boxes.  If you need to use PHP, please refer to the documentation on how to use actual hooks.</p>

<?php
global $headway_force_queries;
$headway_force_queries = true;

 	if($_POST): 
	
	$do_not_save = array('select-hook');

	foreach($_POST as $key => $value):
		if(!$value || $value == 'DELETE') headway_delete_option($key);
		if(!in_array($key, $do_not_save) && $value) headway_update_option($key, $value);
	endforeach;
?>
<div class="success"><span>Hooks Updated!</span> <a href="<?php echo get_bloginfo('wpurl')?>">View Site &raquo;</a></div>
<?php endif; ?>

<form method="post">

			<table class="form-table">
			<tbody>
				
				<tr>
					<th scope="row"><label for="select-hook">Select a Hook</label></th>
					<td>
						<select name="select-hook" id="select-hook">
							
							<optgroup label="Main Hooks">
								<option value="before-everything">&nbsp;&nbsp;Before Everything</option>
								<option value="after-everything">&nbsp;&nbsp;After Everything</option>
							</optgroup>
							
							<optgroup label="Header">
								<option value="before-header-link">&nbsp;&nbsp;Before Header Link</option>
								<option value="after-header-link">&nbsp;&nbsp;After Header Link</option>
								<option value="after-tagline">&nbsp;&nbsp;After Tagline</option>
							</optgroup>
							
							<optgroup label="Navigation">
								<option value="after-navigation">&nbsp;&nbsp;After Navigation</option>
								<option value="navigation-beginning">&nbsp;&nbsp;Navigation Beginning (FILTER)</option>
								<option value="navigation-end">&nbsp;&nbsp;Navigation End (FILTER)</option>
							</optgroup>
							
							<optgroup label="Breadcrumbs">
								<option value="breadcrumbs-beginning">&nbsp;&nbsp;Breadcrumbs Beginning (FILTER)</option>
								<option value="breadcrumbs-end">&nbsp;&nbsp;Breadcrumbs End (FILTER)</option>
							</optgroup>
							
							<optgroup label="Leafs">
								<option value="leaf-top">&nbsp;&nbsp;Leaf Top</option>
								<option value="leaf-content-top">&nbsp;&nbsp;Leaf Content Top</option>
								<option value="leaf-content-bottom">&nbsp;&nbsp;Leaf Content Bottom</option>
								<option value="leaf-bottom">&nbsp;&nbsp;Leaf Bottom</option>
							</optgroup>
							
							<optgroup label="Posts">
								<option value="above-post">&nbsp;&nbsp;Above Post</option>
								<option value="above-post-title">&nbsp;&nbsp;Above Post Title</option>
								<option value="below-post-title">&nbsp;&nbsp;Below Post Title</option>
								<option value="below-post-content">&nbsp;&nbsp;Below Post Content</option>
								<option value="below-post">&nbsp;&nbsp;Below Post</option>
							</optgroup>
							
							<optgroup label="Pages">
								<option value="above-page">&nbsp;&nbsp;Above Page</option>
								<option value="below-page-title">&nbsp;&nbsp;Below Page Title</option>
								<option value="below-page">&nbsp;&nbsp;Below Page</option>
							</optgroup>
							
							<optgroup label="Sidebars">
								<option value="sidebar-top">&nbsp;&nbsp;Sidebar Top</option>
								<option value="sidebar-bottom">&nbsp;&nbsp;Sidebar Bottom</option>
							</optgroup>
							
							<optgroup label="Footer">
								<option value="footer-opening">&nbsp;&nbsp;Footer Opening</option>
								<option value="before-copyright">&nbsp;&nbsp;Before Copyright</option>
								<option value="footer-close">&nbsp;&nbsp;Footer Close</option>
							</optgroup>

						</select>
					</td>
				</tr>
				
				<tr class="hook" id="before-everything">
					<th scope="row"><label for="before-everything">Before Everything</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="before-everything" name="easy-hooks-before-everything"><?php echo stripslashes(headway_get_option('easy-hooks-before-everything'))?></textarea>
					<span class="setting-description">Will be placed right after the <code>&lt;body&gt;</code> tag is opened.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="after-navigation">
					<th scope="row"><label for="after-navigation">After Navigation</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="after-navigation" name="easy-hooks-after-navigation"><?php echo stripslashes(headway_get_option('easy-hooks-after-navigation'))?></textarea>
					<span class="setting-description">Will be displayed after the navigation in the header.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="navigation-beginning">
					<th scope="row"><label for="navigation-beginning">Navigation Beginning (FILTER)</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="navigation-beginning" name="easy-hooks-navigation-beginning"><?php echo stripslashes(headway_get_option('easy-hooks-navigation-beginning'))?></textarea>
					<span class="setting-description">Inject code right after the navigation container is opened.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="navigation-end">
					<th scope="row"><label for="navigation-end">Navigation End (FILTER)</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="navigation-end" name="easy-hooks-navigation-end"><?php echo stripslashes(headway_get_option('easy-hooks-navigation-end'))?></textarea>
					<span class="setting-description">Inject code right before the navigation container is closed.</span></td>
				</tr>
				
				
				<tr style="display:none;" class="hook" id="breadcrumbs-beginning">
					<th scope="row"><label for="breadcrumbs-beginning">Breadcrumbs Beginning (FILTER)</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="breadcrumbs-beginning" name="easy-hooks-breadcrumbs-beginning"><?php echo stripslashes(headway_get_option('easy-hooks-breadcrumbs-beginning'))?></textarea>
					<span class="setting-description">Inject code right after the breadcrumbs container is opened.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="breadcrumbs-end">
					<th scope="row"><label for="breadcrumbs-end">Breadcrumbs End (FILTER)</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="breadcrumbs-end" name="easy-hooks-breadcrumbs-end"><?php echo stripslashes(headway_get_option('easy-hooks-breadcrumbs-end'))?></textarea>
					<span class="setting-description">Inject code right before the breadcrumbs container is closed.</span></td>
				</tr>	
								
				<tr style="display:none;" class="hook" id="before-header-link">
					<th scope="row"><label for="after-header-link">Before Header Link</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="before-header-link" name="easy-hooks-before-header-link"><?php echo stripslashes(headway_get_option('easy-hooks-before-header-link'))?></textarea>
					<span class="setting-description">Before the header link.</span></td>
				</tr>
									
				<tr style="display:none;" class="hook" id="after-header-link">
					<th scope="row"><label for="after-header-link">After Header Link</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="after-header-link" name="easy-hooks-after-header-link"><?php echo stripslashes(headway_get_option('easy-hooks-after-header-link'))?></textarea>
					<span class="setting-description">After the header link.  This is either the name of the site or the logo you place there.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="after-tagline">
					<th scope="row"><label for="after-tagline">After Tagline</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="after-tagline" name="easy-hooks-after-tagline"><?php echo stripslashes(headway_get_option('easy-hooks-after-tagline'))?></textarea>
					<span class="setting-description">After the tagline.  This is generally the slogan that will show up in your header.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="leaf-top">
					<th scope="row"><label for="leaf-top">Leaf Top</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="leaf-top" name="easy-hooks-leaf-top"><?php echo stripslashes(headway_get_option('easy-hooks-leaf-top'))?></textarea>
					<span class="setting-description">This will be placed at the top of all leafs.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="leaf-content-top">
					<th scope="row"><label for="leaf-content-top">Leaf Content Top</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="leaf-content-top" name="easy-hooks-leaf-content-top"><?php echo stripslashes(headway_get_option('easy-hooks-leaf-content-top'))?></textarea>
					<span class="setting-description">This will be placed at the top of all the leafs, but generally under the title.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="leaf-content-bottom">
					<th scope="row"><label for="leaf-content-bottom">Leaf Content Bottom</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="leaf-content-bottom" name="easy-hooks-leaf-content-bottom"><?php echo stripslashes(headway_get_option('easy-hooks-leaf-content-bottom'))?></textarea>
					<span class="setting-description">Will be placed at the bottom of each leaf inside the leaf-content &lt;div&gt;.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="leaf-bottom">
					<th scope="row"><label for="leaf-bottom">Leaf Bottom</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="leaf-bottom" name="easy-hooks-leaf-bottom"><?php echo stripslashes(headway_get_option('easy-hooks-leaf-bottom'))?></textarea>
					<span class="setting-description">This will be placed at the bottom of all leafs.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="above-post">
					<th scope="row"><label for="above-post">Above Post</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="above-post" name="easy-hooks-above-post"><?php echo stripslashes(headway_get_option('easy-hooks-above-post'))?></textarea>
					<span class="setting-description">Goes before each post.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="above-post-title">
					<th scope="row"><label for="above-post-title">Above Post Title</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="above-post-title" name="easy-hooks-above-post-title"><?php echo stripslashes(headway_get_option('easy-hooks-above-post-title'))?></textarea>
					<span class="setting-description">Goes above the post title, and above the meta if you choose to place any up there.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="below-post-title">
					<th scope="row"><label for="below-post-title">Below Post Title</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="below-post-title" name="easy-hooks-below-post-title"><?php echo stripslashes(headway_get_option('easy-hooks-below-post-title'))?></textarea>
					<span class="setting-description">Goes below the meta below the title and the title.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="below-post-content">
					<th scope="row"><label for="below-post-content">Below Post Content</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="below-post-content" name="easy-hooks-below-post-content"><?php echo stripslashes(headway_get_option('easy-hooks-below-post-content'))?></textarea>
					<span class="setting-description">Goes below the main text of the post.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="below-post">
					<th scope="row"><label for="below-post">Below Post</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="below-post" name="easy-hooks-below-post"><?php echo stripslashes(headway_get_option('easy-hooks-below-post'))?></textarea>
					<span class="setting-description">Goes at the complete bottom of each post.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="above-page">
					<th scope="row"><label for="above-page">Above Page</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="above-page" name="easy-hooks-above-page"><?php echo stripslashes(headway_get_option('easy-hooks-above-page'))?></textarea>
					<span class="setting-description">Goes at the top of each page.</span></td>
				</tr>

				<tr style="display:none;" class="hook" id="below-page-title">
					<th scope="row"><label for="below-page-title">Below Page Title</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="below-page-title" name="easy-hooks-below-page-title"><?php echo stripslashes(headway_get_option('easy-hooks-below-page-title'))?></textarea>
					<span class="setting-description">Goes below the page titles.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="below-page">
					<th scope="row"><label for="below-page">Below Page</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="below-page" name="easy-hooks-below-page"><?php echo stripslashes(headway_get_option('easy-hooks-below-page'))?></textarea>
					<span class="setting-description">Goes at the complete bottom of each page.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="sidebar-top">
					<th scope="row"><label for="sidebar-top">Sidebar Top</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="sidebar-top" name="easy-hooks-sidebar-top"><?php echo stripslashes(headway_get_option('easy-hooks-sidebar-top'))?></textarea>
					<span class="setting-description">Will be placed at the top of all sidebar leafs.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="sidebar-bottom">
					<th scope="row"><label for="sidebar-bottom">Sidebar Bottom</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="sidebar-bottom" name="easy-hooks-sidebar-bottom"><?php echo stripslashes(headway_get_option('easy-hooks-sidebar-bottom'))?></textarea>
					<span class="setting-description">Will be placed at the bottom of all sidebar leafs.</span></td>
				</tr>
			
				<tr style="display:none;" class="hook" id="after-everything">
					<th scope="row"><label for="after-everything">After Everything</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="after-everything" name="easy-hooks-after-everything"><?php echo stripslashes(headway_get_option('easy-hooks-after-everything'))?></textarea>
					<span class="setting-description">Will be placed right before the <code>&lt;body&gt;</code> tag is closed.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="footer-opening">
					<th scope="row"><label for="footer-opening">Footer Opening</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="footer-opening" name="easy-hooks-footer-opening"><?php echo stripslashes(headway_get_option('easy-hooks-footer-opening'))?></textarea>
					<span class="setting-description">Will be placed right after the footer is opened.</span></td>
				</tr>

				<tr style="display:none;" class="hook" id="before-copyright">
					<th scope="row"><label for="before-copyright">Before Copyright</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="before-copyright" name="easy-hooks-before-copyright"><?php echo stripslashes(headway_get_option('easy-hooks-before-copyright'))?></textarea>
					<span class="setting-description">Will be placed right before the copyright is displayed.</span></td>
				</tr>
				
				<tr style="display:none;" class="hook" id="footer-close">
					<th scope="row"><label for="footer-close">Footer Close</label></th>
					<td><textarea rows="15" cols="55" class="regular-text" id="footer-close" name="easy-hooks-footer-close"><?php echo stripslashes(headway_get_option('easy-hooks-footer-close'))?></textarea>
					<span class="setting-description">Will be placed right before the footer is closed.</span></td>
				</tr>
				
			
			</tbody>
			</table>
			
		
					
		
	</div>

	<p class="submit">
	<input type="submit" value="Save Changes" class="button-primary" name="Submit"/>
	</p>
</form>