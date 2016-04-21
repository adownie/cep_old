<?php
function content_leaf_inner($leaf){
	if($leaf['new']){
		$leaf['options']['mode'] = 'page';
		$leaf['options']['categories-mode'] = 'include';
		$leaf['options']['post-limit'] = get_option('posts_per_page');		
		$leaf['options']['featured-posts'] = '1';	
		$leaf['options']['paginate'] = 'on';	

		$leaf['options']['order'] = 'date';	
		$leaf['options']['orderby'] = 'DESC';	
	}	
	
		if($categories_select): //Fixes select for multiple featured boxes.  Without this it will compound the categories.
			$categories_select = '';
			$categories = '';
			$select_selected = array();
		endif;

		$categories = $leaf['options']['categories'];
		$categories_select_query = get_categories();
		$categories_select = '';
		foreach($categories_select_query as $category){ 
			if(is_array($categories)){
				if(in_array($category->term_id, $categories)) $select_selected[$category->term_id] = ' selected';
			}

			$categories_select .= '<option value="'.$category->term_id.'"'.$select_selected[$category->term_id].'>'.$category->name.'</option>';

		}


		$pages_select = '<option value=""></option>';
		$page_select_query = get_pages();
		foreach($page_select_query as $page){ 
			if($page->ID == $leaf['options']['other-page']) $selected[$page->ID] = ' selected';
			$pages_select .= '<option value="'.$page->ID.'"'.$selected[$page->ID].'>'.$page->post_title.'</option>';
		}
	
	if($leaf['options']['mode'] != 'posts'){
		$display['posts-options'] = 'display: none;';	
	} else {
		$display['page-options'] = 'display: none;';
	}
	
?>
	<ul class="clearfix tabs">
        <li><a href="#options-tab-<?php echo $leaf['id'] ?>">Options</a></li>
        <li><a href="#miscellaneous-tab-<?php echo $leaf['id'] ?>">Miscellaneous</a></li>
    </ul>

	<div id="options-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>">
			<tr>
				<th scope="row"><label>Mode</label></th>
				<td>
						<script type="text/javascript">
							var posts_options_<?php echo $leaf['id'] ?> = ".<?php echo $leaf['id'] ?>_posts_options";
							var page_options_<?php echo $leaf['id'] ?> = ".<?php echo $leaf['id'] ?>_page_options";
						</script>
						<p class="radio-container">
							<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][mode]" id="<?php echo $leaf['id'] ?>_mode_page" class="radio headway-visual-editor-input" value="page" onclick="jQuery(posts_options_<?php echo $leaf['id'] ?>).hide();jQuery(page_options_<?php echo $leaf['id'] ?>).show();"<?php echo headway_radio_value($leaf['options']['mode'], 'page') ?> /><label for="<?php echo $leaf['id'] ?>_mode_page" class="no-clear">Page/Single Post/Default Behavior</label>
						</p>

						<p class="radio-container">
							<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][mode]" id="<?php echo $leaf['id'] ?>_mode_posts" class="radio headway-visual-editor-input" value="posts" onclick="jQuery(posts_options_<?php echo $leaf['id'] ?>).show();jQuery(page_options_<?php echo $leaf['id'] ?>).hide();"<?php echo headway_radio_value($leaf['options']['mode'], 'posts') ?> /><label for="<?php echo $leaf['id'] ?>_mode_posts" class="no-clear">Custom Posts Query</label>
						</p>
				</td>
			</tr>
		
			<tr style="<?php echo $display['page-options'] ?>" class="<?php echo $leaf['id'] ?>_page_options">
				<td colspan="2">
					<p class="info-box">The content leaf is extremely versatile.  By default it will do what you expect it to do.  For example, if you add this on a page, it will display that pages content.  If you add it on the index system page, it will list the posts like a normal blog template and if you add this box on a category page, it will list posts of that category.  You can also add a content box and display the content from a completely separate page.  Choose the page below, otherwise leave the select box empty.</p>
				</td>
			</tr>
		
		
			<tr style="<?php echo $display['page-options'] ?>" class="<?php echo $leaf['id'] ?>_page_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_other_page">Fetch Content From Other Page</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][other-page]" id="<?php echo $leaf['id'] ?>_other_page">
						<?php echo $pages_select ?>
					</select>
				</td>
			</tr>
		
		
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label>Categories Mode</label></th>
				<td>
					<p class="radio-container">
						<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][categories-mode]" id="<?php echo $leaf['id'] ?>_mode_include" class="radio headway-visual-editor-input" value="include"<?php echo headway_radio_value($leaf['options']['categories-mode'], 'include') ?>  />
						<label for="<?php echo $leaf['id'] ?>_mode_include" class="no-clear">Include</label>
					</p>
				
					<p class="radio-container">
						<input type="radio" name="leaf-options[<?php echo $leaf['id'] ?>][categories-mode]" id="<?php echo $leaf['id'] ?>_mode_exclude" class="radio headway-visual-editor-input" value="exclude"<?php echo headway_radio_value($leaf['options']['categories-mode'], 'exclude') ?>  />
						<label for="<?php echo $leaf['id'] ?>_mode_exclude" class="no-clear">Exclude</label>
					</p>
				</td>
			</tr>
		
		
			
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<td colspan="2">
					<p class="info-box">The categories select box has two modes. You can set it to include specific categories or you can exclude specific categories.  Leave it blank to include all categories.</p>
				</td>
			</tr>
		
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_categories">Categories</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][categories][]" id="<?php echo $leaf['id'] ?>_categories" multiple size="5">
						<?php echo $categories_select; ?>
					</select>
				</td>
			</tr>
			
			
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_author">Limit By Author</label></th>
				<td>
					<?php wp_dropdown_users( array('show_option_all' => '   ', 'multi' => true, 'name' => 'leaf-options['.$leaf['id'].'][author]', 'selected' => $leaf['options']['author'], 'class' => 'headway-visual-editor-input') ); ?> 
				</td>
			</tr>
		
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_post_limit">Post Limit</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][post-limit]" id="<?php echo $leaf['id'] ?>_post_limit" value="<?php echo $leaf['options']['post-limit'] ?>" />
				</td>
			</tr>
		
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_featured_posts">Featured Posts</label></th>
				<td>
					<input type="text" class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][featured-posts]" id="<?php echo $leaf['id'] ?>_featured_posts" value="<?php echo $leaf['options']['featured-posts'] ?>" />
				</td>
			</tr>
		
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label>Pagination</label></th>
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_paginate" name="leaf-options[<?php echo $leaf['id'] ?>][paginate]"<?php echo headway_checkbox_value($leaf['options']['paginate']) ?> />
						<label for="<?php echo $leaf['id'] ?>_paginate">Paginate Posts</label>
					</p>
				</td>	
			</tr>
		
			<tr style="<?php echo $display['posts-options'] ?>" class="<?php echo $leaf['id'] ?>_posts_options">
				<th scope="row"><label for="<?php echo $leaf['id'] ?>_orderby">Order By</label></th>
				<td>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][orderby]" id="<?php echo $leaf['id'] ?>_orderby">
						<option value="date"<?php echo headway_option_value($leaf['options']['orderby'], 'date') ?>>Date</option>
						<option value="title"<?php echo headway_option_value($leaf['options']['orderby'], 'title') ?>>Title</option>
						<option value="rand"<?php echo headway_option_value($leaf['options']['orderby'], 'rand') ?>>Random</option>
						<option value="ID"<?php echo headway_option_value($leaf['options']['orderby'], 'ID') ?>>ID</option>
					</select>
					<select class="headway-visual-editor-input" name="leaf-options[<?php echo $leaf['id'] ?>][order]" id="<?php echo $leaf['id'] ?>_order">
						<option value="desc"<?php echo headway_option_value($leaf['options']['order'], 'desc') ?>>Descending</option>
						<option value="asc"<?php echo headway_option_value($leaf['options']['order'], 'asc') ?>>Ascending</option>
					</select>
				</td>
			</tr>
			
			<tr class="no-border">
				<th scope="row"><label>Disable Excerpts</label></th>
				<td>
					<p class="radio-container">
						<input type="checkbox" class="radio headway-visual-editor-input" id="<?php echo $leaf['id'] ?>_disable_excerpts" name="leaf-options[<?php echo $leaf['id'] ?>][disable-excerpts]"<?php echo headway_checkbox_value($leaf['options']['disable-excerpts']) ?> />
						<label for="<?php echo $leaf['id'] ?>_disable_excerpts">Disable Excerpts</label>
					</p>
				</td>	
			</tr>
		</table>
	</div>
	
	<div id="miscellaneous-tab-<?php echo $leaf['id'] ?>">
		<table class="tab-options" id="leaf-options-<?php echo $leaf['id'] ?>-miscellaneous">
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
<?php
}

function content_leaf_content($leaf){
?>
	<?php 
	
	if(function_exists('wp_greet_box') && !$wp_greet_box_check){
		wp_greet_box(); 
		$wp_greet_box_check = true;
	} 

		$count = 0;
		$limit = ($leaf['options']['post-limit']) ? $leaf['options']['post-limit'] : get_option('posts_per_page');
		$small_excerpts = headway_get_option('small-excerpts'); 
		$small_excerpts_class = ($small_excerpts) ? 'small-excerpts-post' : NULL;
		$post_count = ($leaf['options']['featured-posts']%2) ? $leaf['options']['featured-posts']+1 : $leaf['options']['featured-posts'];
		$small_excerpts_amount = $limit-$leaf['options']['featured-posts'];
		$small_excerpts_amount = (get_query_var('paged') || is_archive()) ? $limit : $small_excerpts_amount;
		$smaller_excepts_container_count = 0;
		$single = false;


				if($leaf['options']['other-page']) query_posts('page_id='.$leaf['options']['other-page']);
				if($leaf['options']['mode'] == 'page'):

				rewind_posts();

				if(is_home()):


					while ( have_posts() ) : 
					the_post();

					$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$count++;
					if(($count <= headway_get_option('featured-posts') && $paged == 1) || ($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts'))): 

						if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
							$position_meta = headway_get_write_box_value('image-alignment');
							$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';
							
							$image_output[$count] = '<div class="post-image'.$position.'">';
							$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
							$image_output[$count] .= '</div>';
						}

					?>
								<?php do_action('headway_above_post', $count, $single) ?>
								<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">
									<?php headway_above_title($count, $single); ?>
									<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
									<?php headway_below_title($count, $single) ?>

									<div class="entry-content">
										
										<?php echo $image_output[$count]; ?>
										
										<?php the_content(false); ?>

										<?php if(strpos($post->post_content, '<!--more-->')){ ?>
											<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
										<?php } ?>


									</div>
									<?php headway_below_content($count, $single) ?>
								</div><!-- .post -->
								<?php do_action('headway_below_post', $count, $single) ?>

					<?php else: ?>





						<?php 
						if($small_excerpts && !($post_count%2)){
							echo '<div class="small-excerpts-row clearfix">'; 
							$smaller_excepts_container_count++;
						}

							if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
								$position_meta = headway_get_write_box_value('image-alignment');
								$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

								$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

								$image_output[$count] = '<div class="post-image'.$position.'">';
								$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
								$image_output[$count] .= '</div>';
							}
						?>




								<?php do_action('headway_above_small_excerpt', $count) ?>
								<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">


										<?php headway_above_title($count, $single, $small_excerpts) ?>
										<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
										<?php headway_below_title($count, $single, $small_excerpts) ?>	
										<div class="entry-content">
											<?php echo $image_output[$count] ?>
											
											<?php the_excerpt(); ?>

											<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
										</div>
										<?php headway_below_content($count, $single, $small_excerpts) ?>
									</div><!-- .post -->
								<?php do_action('headway_below_small_excerpt', $count) ?>

						<?php 
						if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
							echo '</div>';  
							$smaller_excepts_container_count++;
						}
						$post_count++;
						?>

					<?php endif; ?>


			<?php 
			endwhile; 
			if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>';
			?>




				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>


			<?php elseif(is_page()): ?>
				<?php the_post() ?>

				<?php do_action('headway_above_page') ?>
				<div id="post-<?php the_id()?>" class="<?php headway_post_class() ?> clearfix">

				<?php if(!get_post_meta(get_the_id(), '_hide_title', true)): ?>
				<h1 class="page-title"><?php if(headway_get_write_box_value('custom-title')){ echo headway_get_write_box_value('custom-title'); } else { the_title(); } ?></h1>
				<?php endif; ?>
				<?php do_action('headway_below_page_title') ?>
				<div class="entry-content">
					<?php the_content() ?>
					
					<?php wp_link_pages(array('before' => '<div id="page-links"><strong>Pages: </strong>', 'after' => '</div>')); ?>
				</div>
								
				</div>
				<?php do_action('headway_below_page') ?>

				<?php if(headway_get_option('page-comments')) comments_template('', true); ?>



			<?php elseif(is_single()): ?>
				<?php the_post() ?>
				<?php $single = true; ?>
				<?php do_action('headway_above_post_single', $count) ?>
				<?php 

				do_action('headway_above_post', $count, $single);

					if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
						$position_meta = headway_get_write_box_value('image-alignment');
						$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

						

						$image_output[$count] = '<div class="post-image'.$position.'">';
						$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
						$image_output[$count] .= '</div>';
					}
				?>


					<div id="post-<?php the_ID() ?>" class="<?php headway_post_class(); echo $image_class[$count]; ?> clearfix">


					<?php headway_above_title($count, $single) ?>
					<h1 class="entry-title"><?php the_title() ?></h1>
					<?php headway_below_title($count, $single) ?>


					<div class="entry-content">
						
						<?php echo $image_output[$count] ?>

						<?php the_content(headway_get_option('read-more-text')); ?>


						<?php wp_link_pages(array('before' => '<div id="page-links"><strong>Pages: </strong>', 'after' => '</div>')); ?>
						
					</div>

					<?php headway_below_content($count, $single) ?>

				</div><!-- .post -->
				<?php do_action('headway_below_post', $count, $single) ?>
				<?php do_action('headway_below_post_single', $count) ?>

				<div id="nav-below-single" class="nav-below navigation clearfix">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">&laquo;</span> Previous Post') ?></div>
					<div class="nav-next"><?php next_post_link('%link', 'Next Post <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>


			<?php comments_template('', true); ?>

			<?php do_action('headway_below_comments', $count) ?>





			<?php elseif(is_category()): ?>

				<?php echo apply_filters('headway_category_archives_title', '<h2 class="page-title archives-title">Category Archives: '.single_cat_title(false, false).'</span></h2>'); ?>
				
				<?php if(category_description()) echo apply_filters('headway_category_archives_description', '<div class="archive-meta">'.category_description().'</div>'); ?>
					
				<?php 
					while ( have_posts() ) : 
					the_post();
					$count++;
				?>

						<?php 
						if($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts')){
								if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
									$position_meta = headway_get_write_box_value('image-alignment');
									$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

									

									$image_output[$count] = '<div class="post-image'.$position.'">';
									$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
									$image_output[$count] .= '</div>';
								}
						?>
										<?php do_action('headway_above_post', $count, $single) ?>
										<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">
											<?php 
												headway_above_title($count, $single);
											?>
											<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
											<?php headway_below_title($count, $single) ?>

											<div class="entry-content">
												
												<?php echo $image_output[$count] ?>

												<?php the_content(false); ?>

												<?php if(strpos($post->post_content, '<!--more-->')){ ?>
													<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
												<?php } ?>



											</div>
											<?php headway_below_content($count, $single) ?>
										</div><!-- .post -->
										<?php do_action('headway_below_post', $count, $single) ?>
						<?php 
						} else {
							if($small_excerpts && !($post_count%2)){
								echo '<div class="small-excerpts-row clearfix">'; 
								$smaller_excepts_container_count++;
							}

							if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
								$position_meta = headway_get_write_box_value('image-alignment');
								$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

								$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

								$image_output[$count] = '<div class="post-image'.$position.'">';
								$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
								$image_output[$count] .= '</div>';
							}
							?>

									<?php do_action('headway_above_small_excerpt', $count) ?>
									<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">

											<?php headway_above_title($count, $single, $small_excerpts) ?>
											<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
											<?php headway_below_title($count, $single, $small_excerpts) ?>	
											<div class="entry-content">
												<?php echo $image_output[$count] ?>
												
												<?php the_excerpt(); ?>

												<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
											</div>
											<?php headway_below_content($count, $single, $small_excerpts) ?>
										</div><!-- .post -->
									<?php do_action('headway_below_small_excerpt', $count) ?>

						<?php 
							if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
								echo '</div>';  
								$smaller_excepts_container_count++;
							}
							$post_count++;
						}
						?>


				<?php 
				endwhile;
				if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>'; 
				?>

				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>




			<?php elseif(is_date()): ?>
				<?php if ( is_day() ) : ?>
							<?php echo apply_filters('headway_archives_title', '<h2 class="page-title archives-title">Daily Archives: '.get_the_time(headway_get_option('date_format')).'</h2>'); ?>
				<?php elseif ( is_month() ) : ?>
							<?php echo apply_filters('headway_archives_title', '<h2 class="page-title archives-title">Monthly Archives: '.get_the_time('F Y').'</h2>'); ?>
				<?php elseif ( is_year() ) : ?>
							<?php echo apply_filters('headway_archives_title', '<h2 class="page-title archives-title">Yearly Archives: '.get_the_time('Y').'</h2>'); ?>
				<?php endif; ?>


				<?php 
					while ( have_posts() ) : 
					the_post();
					$count++;
				?>


					<?php 
									if($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts')){
											if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
												$position_meta = headway_get_write_box_value('image-alignment');
												$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

												

												$image_output[$count] = '<div class="post-image'.$position.'">';
												$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
												$image_output[$count] .= '</div>';
											}
									?>
													<?php do_action('headway_above_post', $count, $single) ?>
													<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">
														<?php 
															headway_above_title($count, $single);
														?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single) ?>

														<div class="entry-content">
															
															<?php echo $image_output[$count] ?>

															<?php the_content(false); ?>

															<?php if(strpos($post->post_content, '<!--more-->')){ ?>
																<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
															<?php } ?>



														</div>
														<?php headway_below_content($count, $single) ?>
													</div><!-- .post -->
													<?php do_action('headway_below_post', $count, $single) ?>
									<?php 
									} else {
										if($small_excerpts && !($post_count%2)){
											echo '<div class="small-excerpts-row clearfix">'; 
											$smaller_excepts_container_count++;
										}

										if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
											$position_meta = headway_get_write_box_value('image-alignment');
											$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

											$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

											$image_output[$count] = '<div class="post-image'.$position.'">';
											$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
											$image_output[$count] .= '</div>';
										}
										?>

												<?php do_action('headway_above_small_excerpt', $count) ?>
												<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">

														<?php headway_above_title($count, $single, $small_excerpts) ?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single, $small_excerpts) ?>	
														<div class="entry-content">
															<?php echo $image_output[$count] ?>
															
															<?php the_excerpt(); ?>

															<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
														</div>
														<?php headway_below_content($count, $single, $small_excerpts) ?>
													</div><!-- .post -->
												<?php do_action('headway_below_small_excerpt', $count) ?>

									<?php 
										if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
											echo '</div>';  
											$smaller_excepts_container_count++;
										}
										$post_count++;
									}
									?>


				<?php 
				endwhile;
				if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>'; 
				?>


				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>



			<?php elseif(is_tag()): ?>
				<?php echo apply_filters('headway_tag_archives_title', '<h2 class="page-title archives-title">Tag Archive: '.single_tag_title(false, false).'</h2>'); ?>

				<?php 
					while ( have_posts() ) : 
					the_post();
					$count++;
				?>


					<?php 
									if($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts')){
											if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
												$position_meta = headway_get_write_box_value('image-alignment');
												$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

												

												$image_output[$count] = '<div class="post-image'.$position.'">';
												$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
												$image_output[$count] .= '</div>';
											}
									?>
													<?php do_action('headway_above_post', $count, $single) ?>
													<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">
														<?php 
															headway_above_title($count, $single);
														?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single) ?>

														<div class="entry-content">
															
															<?php echo $image_output[$count] ?>

															<?php the_content(false); ?>

															<?php if(strpos($post->post_content, '<!--more-->')){ ?>
																<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
															<?php } ?>



														</div>
														<?php headway_below_content($count, $single) ?>
													</div><!-- .post -->
													<?php do_action('headway_below_post', $count, $single) ?>
									<?php 
									} else {
										if($small_excerpts && !($post_count%2)){
											echo '<div class="small-excerpts-row clearfix">'; 
											$smaller_excepts_container_count++;
										}

										if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
											$position_meta = headway_get_write_box_value('image-alignment');
											$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

											$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

											$image_output[$count] = '<div class="post-image'.$position.'">';
											$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
											$image_output[$count] .= '</div>';
										}
										?>

												<?php do_action('headway_above_small_excerpt', $count) ?>
												<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">

														<?php headway_above_title($count, $single, $small_excerpts) ?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single, $small_excerpts) ?>	
														<div class="entry-content">
															<?php echo $image_output[$count] ?>
															
															<?php the_excerpt(); ?>

															<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
														</div>
														<?php headway_below_content($count, $single, $small_excerpts) ?>
													</div><!-- .post -->
												<?php do_action('headway_below_small_excerpt', $count) ?>

				<?php 
										if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
											echo '</div>';  
											$smaller_excepts_container_count++;
										}
										$post_count++;
									}


				endwhile;
				if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>'; 
				?>

				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>



			<?php elseif(is_author()): ?>
				<?php
				if(get_query_var('author_name')) :
					$authordata = get_userdatabylogin(get_query_var('author_name'));
				else :
					$authordata = get_userdata(get_query_var('author'));
				endif;
				
				echo apply_filters('headway_author_archives_title', '<h2 class="page-title author archives-title">Author Archives: '.$authordata->display_name.'</h2>');
				if($authordata->user_description)
					echo apply_filter('headway_author_bio', '<div class="archive-meta">'.$authordata->user_description.'</div>');

					while ( have_posts() ) : 
					the_post();
					$count++;

									if($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts')){
											if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
												$position_meta = headway_get_write_box_value('image-alignment');
												$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

												

												$image_output[$count] = '<div class="post-image'.$position.'">';
												$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
												$image_output[$count] .= '</div>';
											}
									?>
													<?php do_action('headway_above_post', $count, $single) ?>
													<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">
														<?php 
															headway_above_title($count, $single);
														?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single) ?>

														<div class="entry-content">
															
															<?php echo $image_output[$count] ?>
															
															<?php the_content(false); ?>

															<?php if(strpos($post->post_content, '<!--more-->')){ ?>
																<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
															<?php } ?>



														</div>
														<?php headway_below_content($count, $single) ?>
													</div><!-- .post -->
													<?php do_action('headway_below_post', $count, $single) ?>
									<?php 
									} else {
										if($small_excerpts && !($post_count%2)){
											echo '<div class="small-excerpts-row clearfix">'; 
											$smaller_excepts_container_count++;
										}

										if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
											$position_meta = headway_get_write_box_value('image-alignment');
											$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

											$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

											$image_output[$count] = '<div class="post-image'.$position.'">';
											$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
											$image_output[$count] .= '</div>';
										}
										?>

												<?php do_action('headway_above_small_excerpt', $count) ?>
												<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">

														<?php headway_above_title($count, $single, $small_excerpts) ?>
														<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
														<?php headway_below_title($count, $single, $small_excerpts) ?>	
														<div class="entry-content">
															<?php echo $image_output[$count] ?>
															
															<?php the_excerpt(); ?>

															<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
														</div>
														<?php headway_below_content($count, $single, $small_excerpts) ?>
													</div><!-- .post -->
												<?php do_action('headway_below_small_excerpt', $count) ?>

									<?php 
										if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
											echo '</div>';  
											$smaller_excepts_container_count++;
										}
										$post_count++;
									}
									?>

				<?php 
				endwhile;
				if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>'; 
				?>

				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>



			<?php 
			elseif(is_search()):
				
				echo apply_filters('headway_search_archives_title', '<h2 class="page-title archives-title">Search Results for: <span id="search-terms">'.get_search_query().'</span></h2>');


					while ( have_posts() ) : 
					the_post();
					$count++;
					global $post;
			
					if($post->post_type == 'post'):


						if($small_excerpts && !($post_count%2)){
							echo '<div class="small-excerpts-row clearfix">'; 
							$smaller_excepts_container_count++;
						}

						if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
							$position_meta = headway_get_write_box_value('image-alignment');
							$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

							$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

							$image_output[$count] = '<div class="post-image'.$position.'">';
							$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
							$image_output[$count] .= '</div>';
						}
						?>


								<?php do_action('headway_above_small_excerpt', $count) ?>
								<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">
										<?php headway_above_title($count, $single, $small_excerpts) ?>
										<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
										<?php headway_below_title($count, $single, $small_excerpts) ?>	
										<div class="entry-content">
											<?php echo $image_output[$count] ?>
											
											<?php the_excerpt(); ?>

											<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
										</div>
										<?php headway_below_content($count, $single, $small_excerpts) ?>
									</div><!-- .post -->
								<?php do_action('headway_below_small_excerpt', $count) ?>

						<?php 
						if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
							echo '</div>';  
							$smaller_excepts_container_count++;
						}
						$post_count++;
						?>

				<?php else: ?>


						<?php 
						if($small_excerpts && !($post_count%2)){
							echo '<div class="small-excerpts-row clearfix">'; 
							$smaller_excepts_container_count++;
						}
						?>

								<?php do_action('headway_above_small_excerpt', $count) ?>
								<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">
										<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
										<div class="entry-content">
											<?php the_excerpt(); ?>

											<p><a href="<?php the_permalink() ?>" class="more-link">Read the full page &raquo;</a></p>
										</div>
									</div><!-- .post -->
								<?php do_action('headway_below_small_excerpt', $count) ?>

						<?php 
						if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
							echo '</div>';  
							$smaller_excepts_container_count++;
						}
						$post_count++;
						?>


				<?php endif;?>


				<?php 
				endwhile;
				if($smaller_excepts_container_count%2) echo '</div>';
				?>


				<div class="nav-below navigation">
					<?php if(!function_exists('wp_pagenavi')) { ?>
					<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts') ?></div>
					<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
					<?php } else { 
						wp_pagenavi(); 
					}
					?>
				</div>


			<?php endif; ?>










			<?php elseif($leaf['options']['mode'] == 'posts'): ?>


				<?php 
				global $more;
				$more = 0;

				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$categories = $leaf['options']['categories'];

				$query_options = array(
					'post-type'  =>  'post'
				);

				if($leaf['options']['paginate']) $query_options['paged'] = $paged;

				if($leaf['options']['post-limit'] && $leaf['options']['paginate']) $query_options['posts_per_page'] = $leaf['options']['post-limit'];
				if($leaf['options']['post-limit'] && !$leaf['options']['paginate']) $query_options['showposts'] = $leaf['options']['post-limit'];

				if($leaf['options']['categories'] && $leaf['options']['categories'][0] != NULL){
					if($leaf['options']['categories-mode'] == 'include') $query_options['category__in'] = $categories;
					if($leaf['options']['categories-mode'] == 'exclude') $query_options['category__not_in'] = $categories;	
				} 

				if($leaf['options']['author']){
					$query_options['author'] = $leaf['options']['author'];
				}

				$query_options['orderby'] = $leaf['options']['orderby'];
				$query_options['order'] = $leaf['options']['order'];


				$query[$leaf['id']] = new WP_Query($query_options);

				while ( $query[$leaf['id']]->have_posts() ) : 

				$query[$leaf['id']]->the_post();

				$count++;
				if(($count <= $leaf['options']['featured-posts'] && $paged == 1) || ($leaf['options']['disable-excerpts'] || headway_get_option('disable-excerpts'))): 
					if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
						$position_meta = headway_get_write_box_value('image-alignment');
						$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

						

						$image_output[$count] = '<div class="post-image'.$position.'">';
						$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
						$image_output[$count] .= '</div>';
					}
				?>

							<?php do_action('headway_above_post', $count, $single) ?>
								<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> clearfix">

								<?php headway_above_title($count, $single) ?>
								<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
								<?php headway_below_title($count, $single) ?>

								<div class="entry-content">

									<?php echo $image_output[$count] ?>
									
									<?php the_content(false); ?>
									
									<?php 
									global $post; 
									if(strpos($post->post_content, '<!--more-->')){ 
									?>
										<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
									<?php } ?>

								</div>
								<?php headway_below_content($count, $single) ?>
							</div><!-- .post -->
								<?php do_action('headway_below_post', $count, $single) ?>

				<?php else: ?>

								<?php 
								if($small_excerpts && !($post_count%2)){
									echo '<div class="small-excerpts-row clearfix">'; 
									$smaller_excepts_container_count++;
								}

								if(function_exists('the_post_thumbnail') && has_post_thumbnail()){
									$position_meta = headway_get_write_box_value('image-alignment');
									$position = ($position_meta) ? ' '.$position_meta : ' post-image-right';

									$size = ($small_excerpts) ? array(48, 48) : array(str_replace('px', '', headway_get_option('post-thumbnail-width')), str_replace('px', '', headway_get_option('post-thumbnail-height')));

									$image_output[$count] = '<div class="post-image'.$position.'">';
									$image_output[$count] .= get_the_post_thumbnail(get_the_id(), $size);
									$image_output[$count] .= '</div>';
								}
								?>


										<?php do_action('headway_above_small_excerpt', $count) ?>
										<div id="post-<?php the_ID() ?>" class="<?php headway_post_class() ?> small-post clearfix <?php echo $small_excerpts_class ?>">


												<?php headway_above_title($count, $single, $small_excerpts) ?>
												<h2 class="entry-title"><a href="<?php the_permalink() ?>" title="<?php printf(__('Permalink to %s', 'blog'), wp_specialchars(get_the_title(), 1)) ?>" rel="bookmark"><?php the_title() ?></a></h2>
												<?php headway_below_title($count, $single, $small_excerpts) ?>	
												<div class="entry-content">
													
													<?php echo $image_output[$count] ?>
													
													<?php the_excerpt(); ?>

													<p><a href="<?php the_permalink() ?>" class="more-link"><?php echo headway_get_option('read-more-text') ?></a></p>
												</div>
												<?php headway_below_content($count, $single, $small_excerpts) ?>
											</div><!-- .post -->
										<?php do_action('headway_below_small_excerpt', $count) ?>

								<?php 
								if(($small_excerpts && $post_count%2) || ($count == get_option('posts_per_page') && $small_excerpts_amount%2 && $small_excerpts)){
									echo '</div>';  
									$smaller_excepts_container_count++;
								}
								$post_count++;
								?>

				<?php endif; ?>


				<?php 
				endwhile; 
				if($smaller_excepts_container_count%2 && !$leaf['options']['disable-excerpts'] && !headway_get_option('disable-excerpts')) echo '</div>';
				?>

				<?php if($leaf['options']['paginate']): ?>

							<div class="nav-below navigation">	
								<div class="nav-previous"><?php next_posts_link('<span class="meta-nav">&laquo;</span> Older Posts', $query[$leaf['id']]->max_num_pages) ?></div>
								<div class="nav-next"><?php previous_posts_link('Newer posts <span class="meta-nav">&raquo;</span>') ?></div>
							</div>

				<?php endif; ?>


				<?php endif; ?>
<?php
}
$options = array(
		'id' => 'content',
		'name' => 'Content',
		'options_callback' => 'content_leaf_inner',
		'content_callback' => 'content_leaf_content',
		'icon' => false,
		'show_hooks' => false
	);

$content_leaf = new HeadwayLeaf($options);