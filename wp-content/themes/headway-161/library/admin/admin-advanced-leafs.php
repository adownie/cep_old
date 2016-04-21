<h2>Headway Advanced Leafs</h2>

<?php
if($_POST['add-gallery']): 
	headway_taxonomies(array('type' => 'gallery', 'id' => 'NEW', 'content' => array('name' => $_POST['add-gallery-name'])));
	
		
	echo '<div class="success"><span>Gallery added!</span></div>';
endif; 


if($_POST['add-photo'] && $_FILES['add-photo-file']){
	
	if ($_FILES['add-photo-file']['error'] == UPLOAD_ERR_OK) {
		if ($_FILES['add-photo-file']['type'] == 'image/gif' || $_FILES['add-photo-file']['type'] == 'image/jpeg' || $_FILES['add-photo-file']['type'] == 'image/pjpeg' || $_FILES['add-photo-file']['type'] == 'image/png'){
			
			$_FILES['add-photo-file']["name"] = str_replace(' ', '_', $_FILES['add-photo-file']["name"]);

			headway_make_uploads_folders();

			if (!file_exists(headway_gallery_dir(false).$_FILES['add-photo-file']["name"])){				
				$upload_task = @move_uploaded_file($_FILES['add-photo-file']["tmp_name"], headway_gallery_dir(false).$_FILES['add-photo-file']["name"]);
			} else {
				$extensions = split("[/\\.]", $_FILES['add-photo-file']["name"]);
				$extension = count($extensions)-1;
				$extension = $extensions[$extension];
				
				$random_num = rand (0, 20);	
				
				$_FILES['add-photo-file']["name"] = str_replace('.'.$extension, '_'.$random_num.'.'.$extension, $_FILES['add-photo-file']["name"]);
						
				$upload_task = move_uploaded_file($_FILES['add-photo-file']["tmp_name"], headway_gallery_dir(false).$_FILES['add-photo-file']["name"]);
			}
			
			if($upload_task){
				headway_taxonomies(array('id' => 'NEW', 'type' => 'gallery-image', 'parent' => $_POST['gallery'], 'content' => array('filename' => $_FILES['add-photo-file']["name"], 'title' => $_POST['photo-title'], 'caption' => $_POST['photo-caption'])));
			
				echo '<div class="success"><span>Woot!</span> <p>Image successfully uploaded.</p></div>';
			} else {
				echo '<div class="error">
						<ul>
							<li><strong>Error</strong>: We were unable to upload the specified image.  Please check the permissions of the gallery uploads folders (wp-content/uploads/headway/gallery) and make sure that they are writable.</li>	
						</ul>
					  </div>';
			}
						
		} else {
			echo '<div class="error">
					<ul>
						<li><strong>Error</strong>: Sorry, but you can only upload .jpg, .jpeg, .gif, or .png images.</li>	
					</ul>
				  </div>';
		}
	}
}

if($_REQUEST['delete']){
	$photo = headway_taxonomies(array('id' => $_REQUEST['delete']));
	
	if($photo){	
		unlink(headway_gallery_dir(false).$photo['content']['filename']);
		headway_taxonomies(array('id' => $_REQUEST['delete'], 'delete' => true));
		
		echo '<div class="success"><span>Success!</span> <p>Image successfully deleted.</p></div>';
	} else {
		echo '<div class="error">
				<ul>
					<li><strong>Error</strong>: The photo you are trying to delete does not exist.</li>	
				</ul>
			  </div>';
	}
}



if($_GET['delete-gallery']){
	$gallery = headway_taxonomies(array('id' => $_GET['delete-gallery']));
	
	if($gallery){	
		headway_taxonomies(array('id' => $_GET['delete-gallery'], 'parent' => $_GET['delete-gallery'], 'delete' => true));
		
		echo '<div class="success"><span>Success!</span> <p>Gallery successfully deleted.</p></div>';
	} else {
		echo '<div class="error">
				<ul>
					<li><strong>Error</strong>: The gallery you are trying to delete does not exist.</li>	
				</ul>
			  </div>';
	}
}

if($_POST['rename-gallery']){
	$gallery = headway_taxonomies(array('id' => $_REQUEST['gallery']));
	
	
	if($gallery){
		headway_taxonomies(array('id' => $_REQUEST['gallery'], 'content' => array('name' => $_POST['gallery-name'])));
		
		echo '<div class="success"><span>Success!</span> <p>Gallery successfully renamed.</p></div>';
	} else {
		echo '<div class="error">
				<ul>
					<li><strong>Error</strong>: The gallery you are trying to rename does not exist.</li>	
				</ul>
			  </div>';
	}
}

if($_POST['edit-photo-submit'] && $_REQUEST['edit-photo']){
	$photo = headway_taxonomies(array('id' => $_REQUEST['edit-photo']));
	
	if($photo){
		headway_taxonomies(array('id' => $_REQUEST['edit-photo'], 'content' => array('filename' => $photo['content']['filename'], 'title' => $_POST['photo-title-edit'], 'caption' => $_POST['photo-caption-edit'])));
		
		echo '<div class="success"><span>Success!</span> <p>Photo successfully edit.</p></div>';
	} else {
		echo '<div class="error">
				<ul>
					<li><strong>Error</strong>: The photo you are trying to edit does not exist.</li>	
				</ul>
			  </div>';
	}
}

?>
<div id="vertical-tab-container">

	<div id="tabs">
		<ul>
			<li><a href="#photo-gallery">Photo Gallery</a></li>
		</ul>
		
		
		<div id="photo-gallery" class="tab">
					
			<?php 
			if($_REQUEST['gallery']){ 
				$gallery = headway_taxonomies(array('id' => $_REQUEST['gallery']));
			?>
				<form method="post" enctype="multipart/form-data">
				
				<input type="hidden" name="gallery" value="<?php echo $_POST['gallery'] ?>" />
				
				<p style="font-size: 0.9em;margin-bottom:0;"><a href="<?php echo get_bloginfo('wpurl') ?>/wp-admin/admin.php?page=headway-advanced-leafs">&laquo; Go Back To Galleries</a></p>
				<h3 class="border-bottom">Editing Gallery: <strong><?php echo $gallery['content']['name'] ?></strong></h3>
				
				<div class="gallery-admin-photos-container clearfix">
				<?php
				$photos = headway_taxonomies(array('parent' => $_REQUEST['gallery']));
				
								
				if(count($photos) > 0){
					foreach($photos as $photo){						
						
						$photo['content'] = array_map('stripslashes', unserialize($photo['content']));

						if($_REQUEST['edit-photo'] == $photo['id']){
							$edit_class[$photo['id']] = ' gallery-admin-photo-small-edit';
						} else {
							$edit_link[$photo['id']] = '<a href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=headway-advanced-leafs&amp;gallery='.$_REQUEST['gallery'].'&amp;edit-photo='.$photo['id'].'">Edit</a> | ';
						}
										
						echo '<div class="gallery-admin-photo-small'.$edit_class[$photo['id']].'">
								<img src="'.get_bloginfo('template_directory').'/library/resources/timthumb/thumbnail.php?src='.headway_upload_path().'/gallery/'.$photo['content']['filename'].'&amp;w=90&amp;h=90&amp;&zc=1" alt="'.$photo['content']['name'].'" />
								<div class="gallery-photo-options">
									<p>'.$edit_link[$photo['id']].'<a onclick="if(confirm(\'Are you sure you want to delete this photo?\')){ return true; } else { return false; }" href="'.get_bloginfo('wpurl').'/wp-admin/admin.php?page=headway-advanced-leafs&amp;gallery='.$_REQUEST['gallery'].'&amp;delete='.$photo['id'].'">Delete</a></p>
								</div>
							  </div>';
					}
				}
				else {
					echo '<p>There aren\'t any photos in this gallery.  Add some!</p>';
				}
				?>
				</div>
				
				<table class="form-table">
				<tbody>	

					<?php
					if($_REQUEST['edit-photo']){
						$photo = headway_taxonomies(array('id' => $_REQUEST['edit-photo']));
					?>
							<input type="hidden" name="gallery" value="<?php echo $_REQUEST['gallery'] ?>" />
							<input type="hidden" name="edit-photo" value="<?php echo $_REQUEST['edit-photo'] ?>" />
							
							<tr valign="top">
								<td><h3 style="font-size: 1.2em;margin: 5px 0 0;">Edit Photo</h3></td>
							</tr>
							
							
							<tr valign="top">
								<th scope="row"><label for="photo-title-edit">Photo Title</label></th>
								<td>
									<input type="text" class="regular-text" id="photo-title-edit" name="photo-title-edit" value="<?php echo $photo['content']['title'] ?>" />
									<span class="description">Name the photo for better organization.  You can also display the titles in the gallery.</span>
								</td>
							</tr>

							<tr valign="top">
								<th scope="row"><label for="photo-caption-edit">Photo Caption</label></th>
								<td>
									<input type="text" class="regular-text" id="photo-caption-edit" name="photo-caption-edit" value="<?php echo htmlentities($photo['content']['caption']) ?>" />
									<span class="description">Explain what's in the photo.  I probably shouldn't have to tell you what a caption is if you're using a gallery.  You can display the captions in the gallery if you wish.</span>
								</td>
							</tr>
							
								<tr>
									<th></th>
									<td><input type="submit" class="button-secondary" name="edit-photo-submit" value="Edit Photo" /></td>
								</tr>
							
					<?php
					}
					?>

					<tr valign="top" class="row-border-top">
						<td><h3 style="font-size: 1.2em;margin: 5px 0 0;">Add Photo</h3></td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><label for="add-photo-file">Photo</label></th>
						<td>
							<input type="file" class="regular-text" id="add-photo-file" name="add-photo-file"/>
							<span class="description">Browse to the desired photo/image on your computer you wish to upload.</span>
						</td>
					</tr>

					<tr valign="top">
						<th scope="row"><label for="photo-title">Photo Title (Optional)</label></th>
						<td>
							<input type="text" class="regular-text" id="photo-title" name="photo-title"/>
							<span class="description">Name the photo for better organization.  You can also display the titles in the gallery.</span>
						</td>
					</tr>
					
					<tr valign="top">
						<th scope="row"><label for="photo-caption">Photo Caption (Optional)</label></th>
						<td>
							<input type="text" class="regular-text" id="photo-caption" name="photo-caption"/>
							<span class="description">Explain what's in the photo.  I probably shouldn't have to tell you what a caption is if you're using a gallery.  You can display the captions in the gallery if you wish.</span>
						</td>
					</tr>

					<tr>
						<th></th>
						<td><input type="submit" class="button-secondary" name="add-photo" value="Add Photo" /></td>
					</tr>
					
					

					<tr valign="top" class="row-border-top">
						<th scope="row"><label for="gallery-name">Gallery Name</label></th>
						<td>
							<input type="text" class="regular-text" id="gallery-name" name="gallery-name"/>
							<span class="description"></span>
						</td>
					</tr>

					<tr>
						<th></th>
						<td>
							<input type="submit" class="button-secondary" name="rename-gallery" value="Rename Gallery" style="margin-right: 10px;" />
							<a onclick="if(confirm('Are you sure you want to delete this gallery?')){ return true; } else { return false; }" href="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=headway-advanced-leafs&amp;delete-gallery=<?php echo $_REQUEST['gallery']; ?>" class="delete">Delete Gallery</a>
						</td>
					</tr>
					
					
					

				</form>
			<?php } else { ?>
			
				<h3>Photo Gallery Leaf</h3>
				<table class="form-table">
				<tbody>
		
					<form method="post">
					
					<tr valign="top">
						<th scope="row"><label for="feed-url">Select a Gallery</label></th>
						<td>
							<select name="gallery" id="gallery">
								<?php
								$galleries = headway_taxonomies(array('type' => 'gallery'));
								if(count($galleries) > 0){
									foreach($galleries as $options){
										$options = array_map('maybe_unserialize', $options);
										$selected[$options['id']] = ($_POST['gallery'] == $options['id']) ? ' selected' : NULL;
										echo '<option value="'.$options['id'].'"'.$selected[$options['id']].'>'.$options['content']['name'].'</option>';
									}
								}
								else {
									echo '<option value="">No galleries exist.&nbsp;Create one!</option>';
								}
								?>
							</select>
							<span class="description">Choose a gallery to either add or edit photos.</span>
						</td>
					</tr>


					<tr>
						<th scope="row"></th>
						<td><input type="submit" class="button-secondary" name="switch-to-gallery" value="Switch To Gallery"/></td>
					</tr>
				
					</form>
					
			
					<form method="post">
						
					<tr valign="top">
						<th scope="row"><label for="add-gallery-name">Add a new gallery</label></th>
						<td>
							<input type="text" class="regular-text" value="<?php echo stripslashes(headway_get_option('add-gallery-name')) ?>" id="add-gallery-name" name="add-gallery-name"/>
							<span class="description">Enter the name for a new gallery.</span>
						</td>
					</tr>
				
					<tr>
						<th></th>
						<td><input type="submit" class="button-secondary" name="add-gallery" value="Add Gallery"/></td>
					</tr>
					
					</form>

				<?php } ?>
		
		
			</tbody>
			</table>
		</div>
		
					
		</div>
	</div>

</form>