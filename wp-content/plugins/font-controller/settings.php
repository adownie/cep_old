<div class="wrap">
<h2>Font Controller</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table class="form-table">

<tr valign="top">
<th scope="row">Place in Sidebar</th>
<td>
  <select name="fontcontroller_sidebar" id="select">
    <option value="yes" <?php if (get_option('fontcontroller_sidebar') == 'yes') echo 'selected="selected"'; ?>>Yes</option>
    <option value="no" <?php if (get_option('fontcontroller_sidebar') == 'no') echo 'selected="selected"'; ?>>No</option>
  </select>
</td>
</tr>
 
<tr valign="top">
<th scope="row">Place in Footer</th>
<td>
  <select name="fontcontroller_footer" id="select">
    <option value="yes" <?php if (get_option('fontcontroller_footer') == 'yes') echo 'selected="selected"'; ?>>Yes</option>
    <option value="no" <?php if (get_option('fontcontroller_footer') == 'no') echo 'selected="selected"'; ?>>No</option>
  </select>
</td>
</tr>

<tr valign="top">
<th scope="row">Icon type</th>
<td>
 <select name="fontcontroller_style" id="select">
    <option value="smooth" <?php if (get_option('fontcontroller_style') == 'smooth') echo 'selected="selected"'; ?>>Smooth</option>
  </select>
</td>
</tr>

</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="fontcontroller_sidebar,fontcontroller_footer,fontcontroller_style" />

<p class="submit">
<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>