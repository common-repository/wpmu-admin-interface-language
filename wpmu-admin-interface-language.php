<?php 
/*
Plugin Name: WPMU Admin Interface Language
Plugin URI: http://patrick.bloggles.info/plugins/
Description: Lets user to select language in backend administration panel.<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mypatricks@gmail.com&item_name=Donate%20to%20Patrick%20Chia&item_number=1242543308&amount=15.00&no_shipping=0&no_note=1&tax=0&currency_code=USD&bn=PP%2dDonationsBF&charset=UTF%2d8&return=http://patrick.bloggles.info">Get a coffee to Patrick</a>
Version: 1.1
Author: Patrick
Author URI: http://patrickchia.com/
Tags: wpmu, wordpressmu, translation, translations, i18n, admin, english, localization, backend
Donate: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=mypatricks@gmail.com&item_name=Donate%20to%20Patrick%20Chia&item_number=1242543308&amount=15.00&no_shipping=0&no_note=1&tax=0&currency_code=USD&bn=PP%2dDonationsBF&charset=UTF%2d8&return=http://patrick.bloggles.info
*/

/*
 * Get your valueble MU hosting at:
 * http://mu.bloggles.info/wordpress-hosting/
*/

function admin_languages(){
	global $user_ID, $user_login;

	if( is_dir( ABSPATH . LANGDIR ) && $dh = opendir( ABSPATH . LANGDIR ) )
		while( ( $lang_file = readdir( $dh ) ) !== false )
			if( substr( $lang_file, -3 ) == '.mo' )
				$lang_files[] = $lang_file;

	$lang = get_user_option('lang_id', $user_id);

	if( is_array( $lang_files ) && !empty( $lang_files ) ) {
	?>
	<tr valign="top"> 
		<th width="33%" scope="row"><?php _e('Admin Language') ?></th> 
		<td>
			<select name="lang_id" id="lang_id">
				<?php mu_dropdown_languages( $lang_files, $lang ); ?>
			</select>
			<br />You can also <a href="options-general.php">specify the language</a> this blog is written in.
		</td>
	</tr> 
	<?php
	}
}

function admin_languages_update() {
	global $user_ID, $user_login;

	if( isset( $_POST['lang_id'] ) ) {
		$admin_lang = $_POST['lang_id'];

		if ( empty( $admin_lang ) )
			$admin_lang = 'en_US';

		update_user_option( $user_ID, 'lang_id', $admin_lang );
	}
}

add_action( 'personal_options', 'admin_languages' );
add_action( 'profile_update', 'admin_languages_update' );

function admin_in_english_locale( $locale ) {

	$lang = get_user_option('lang_id', $user_id);

	if ( !$lang ) {
		return false;
	}

	if( WP_ADMIN === true ) {
		if ( $lang ) {
			$locale = $lang;
		} else {
			$locale = 'en_US';
		}
	}

	return $locale;
}
add_filter( 'locale', 'admin_in_english_locale' );

?>