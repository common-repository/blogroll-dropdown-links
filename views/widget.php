<?php
	$output = '';

	if ( $link_cat == 0 ) {
		$bookmarks = get_bookmarks();
	} else {
		$bookmarks = get_bookmarks(array('category' => $link_cat));
	}

	foreach ($bookmarks as $bookmark) { $output .= '<option value="'.$bookmark->link_url.'">'.$bookmark->link_name.'</option>'; }

	$target = $open_same_window == 1 ? '_self' : '_blank';
?>

<select id="blogroll-dropdown-widget" name="blogroll-dropdown">
	<option value="<?php echo $default_optionhrf ?>"><?php echo $default_option ?></option>
	<?php echo $output ?>
</select>

<script type="text/javascript">
	var selectLink = document.getElementById( 'blogroll-dropdown-widget' );
	selectLink.onchange = function() {
		window.open( this.options[ this.selectedIndex ].value , '<?php echo $target ?>');
	};
</script>