<?php
/*
Plugin Name: Stop CISPA Ribbon
Plugin URI: http://wordpress.org/extend/plugins/stop-cispa-ribbon
Description: When activated, this plugin will put a Stop CISPA ribbon on the top right corner of your website. This is a modified work of the  derived work by Daniel van Dorp which was released under the GPLv2 license.
Author: Al Lamb
Version: 1.4.1
License: GPLv2
Author URI: http://bowierocks.com
*/

function stop_cispa_ribbon_admin() {
	add_submenu_page( 'tools.php', 'Stop Cispa Ribbon Settings', 'Stop Cispa Ribbon', 10, __FILE__, 'stop_cispa_ribbon_admin_menu' );
}

function stop_cispa_ribbon_first() {
	if ( get_option( 'stop_cispa_ribbon_offset' ) == false ) {
		add_option( 'stop_cispa_ribbon_user_offset', '0' );
		add_option( 'stop_cispa_ribbon_admin_offset', '0' );
    }

}

function stop_cispa_ribbon_admin_menu() {
	if ( ( get_option( 'stop_cispa_ribbon_offset' ) ) == false ) {
		stop_cispa_ribbon_first();
	}

	echo('
		<div class="wrap">
		<h2>Donate Ribbon Options</h2><address style="font-size: 8pt; font-weight: 700;">Version 1.1 (<a href="http://www.bowierocks.com/stop-cispa-ribbon" target="_blank">Stop Cispa Ribbon</a>)</address>
	');
	if ( isset( $_POST['submit'] ) ) {
		$str = strtr( $_POST['stop_cispa_ribbon_admin_offset'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$stop_cispa_ribbon = update_option( 'stop_cispa_ribbon_admin_offset', $str );
		$str = strtr( $_POST['stop_cispa_ribbon_user_offset'], array( '"' => '&#34;', '\\' => '', '\'' => '&#39;' ) );
		$stop_cispa_ribbon .= update_option( 'stop_cispa_ribbon_user_offset', $str );
		if ( $stop_cispa_ribbon )
			echo('<div class="updated"><p><strong>Your settings have been saved.</strong></p></div>');
		else
			echo('<div class="error"><p><strong>Your settings have not been saved.</strong></p></div>');
	}

	echo('
		<form action="" method="post">
		<table class="form-table">
		<tr><td>Admin Vertical Offset<br/><span class="stop_cispa_ribbon_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the ADMIN bar.</span></td>
<td><input type="text" name="stop_cispa_ribbon_admin_offset" size="5" maxlength=5 value="'.get_option( 'stop_cispa_ribbon_admin_offset' ).'"></td>
</tr>
		<tr><td>User Vertical Offset<br/><span class="stop_cispa_ribbon_hint">Enter a positive number to push the ribbon down, negative for up. Suggest 28 to offset the USER bar.</span></td>
<td><input type="text" name="stop_cispa_ribbon_user_offset" size="5" maxlength=5 value="'.get_option( 'stop_cispa_ribbon_user_offset' ).'"></td>
</tr>
		<hr />
		<tr><td colspan="2"><hr /></td></tr>
		<tr><td><input class="button-primary" type="submit" name="submit" value="Save Changes" /></td><td>&nbsp;</td></tr>
		</table>
		</form>
		</div>
	' );
}

function stop_cispa_ribbon_admin_css() {
	echo( '
		<style type="text/css">
		.stop_cispa_ribbon_hint {
		font-size: 7pt;
		font-style: italic;
		color: #080;
		}
		</style>
	' );
}
add_action( 'admin_menu', 'stop_cispa_ribbon_admin' );
add_action( 'admin_head', 'stop_cispa_ribbon_admin_css' );

function render_stop_cispa_ribbon() {
	$ribbon_url = plugins_url( 'stop-cispa-ribbon.png', __FILE__ );
	$offset = get_option("stop_cispa_ribbon_offset");
	if(is_admin_bar_showing()) {
	  $offset = get_option("stop_cispa_ribbon_admin_offset");
	  echo "<a target='_blank' class='stop-cispa-ribbon' href='http://www.avaaz.org/en/stop_cispa/'><img src='{$ribbon_url}' alt='Stop CISPA' style='position: fixed; top: {$offset}px; right: 0; z-index: 100000; cursor: pointer;' /></a>";
	} else {
	  $offset = get_option("stop_cispa_ribbon_user_offset");
	  echo "<a target='_blank' class='stop-cispa-ribbon' href='http://www.avaaz.org/en/stop_cispa/'><img src='{$ribbon_url}' alt='Stop CISPA' style='position: fixed; top: {$offset}px; right: 0; z-index: 100000; cursor: pointer;' /></a>";
	}
}

add_action( 'wp_footer', 'render_stop_cispa_ribbon' );
?>