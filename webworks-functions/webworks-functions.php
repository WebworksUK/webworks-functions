<?php
/**
* Plugin Name: Webworks Functions
* Plugin URI: https://webworks.london
* Description: This plugin contains Webworks custom functionality.
* Version: 1.1
* Author: Webworks UK Ltd
* Author URI: https://webworks.london
*/

//Load custom login CSS
function my_custom_login() {
    echo '<link rel="stylesheet" id="ww-admin-css" type="text/css" href="' . plugin_dir_url( __FILE__ ) . 'login/custom-login-styles.css">';
}
add_action('login_head', 'my_custom_login');

function my_login_logo_url() {
return get_bloginfo( 'url' );
}

add_filter( 'login_headerurl', 'my_login_logo_url' );

//REPLACE LOGIN LOGO TO WEBWORKS.LONDON
    function put_my_url(){
    return ('https://webworks.london/service-and-support/');
    }
    add_filter('login_headerurl', 'put_my_url');

//REPLACE INCORRECT PASSWORD OR INCORRECT USERNAME MESSAGE WITH 'INCORRECT LOGIN DETAILS'
function login_error_override()
{
    return 'Incorrect login details.';
}
add_filter('login_errors', 'login_error_override');

add_filter('lostpassword_url', 'wp_hijack_lostpassword');
function wp_hijack_lostpassword() {
    return home_url('/wwlogin?action=lostpassword');
}

// Add custom admin footer text
function change_footer_admin () { 
 
  echo 'Thank you for working with us. Theme developed by <a style="left:-3px;position:relative" href="http://www.webworks.london/" target="_blank" rel="nofollow"><img src="https://webworks.london/wp-content/uploads/2015/05/logo-header.png" width="100" alt="Webworks UK Ltd" style="margin-bottom:-5px"></a>'; 
 
} 
 
add_filter('admin_footer_text', 'change_footer_admin');

// Replace Wordpress admin logo
function registerCustomAdminCss(){
$src = plugin_dir_url( __FILE__ ) . 'styles.css';
$handle = "customAdminCss";
wp_register_script($handle, $src);
wp_enqueue_style($handle, $src, array(), false, false);
    }
    add_action('admin_head', 'registerCustomAdminCss');
	
	
// Add Webworks contact widget to WordPress dashboard
function ww_add_dashboard_widgets() {
  wp_add_dashboard_widget('wp_dashboard_widget', '#Webworks Tools', 'ww_theme_info');
}
add_action('wp_dashboard_setup', 'ww_add_dashboard_widgets' );
 
function ww_theme_info() {
  echo "<ul>
  <li><a href='https://webworks.london/services/link.php?id=4' target='_blank' rel='nofollow'><img src='/wp-content/plugins/webworks-functions/login/logo-header.png' alt='Webworks UK Ltd' style='margin-bottom:-5px'></a></li>
  <li><strong>Developed By:</strong> Webworks UK Limited</li>
  <li><strong><a href='https://webworks.london/services/link.php?id=2' target='_blank' rel='nofollow'>Raise a support ticket</a></strong></li>
  <li><strong><a href='https://webworks.london/services/clientarea.php' target='_blank' rel='nofollow'>Visit the Client Area</a></strong></li>
  <li><strong><a href='https://webworks.london/services/knowledgebase.php' target='_blank' rel='nofollow'>Search the Knowledgebase</a></strong></li>
  <li><strong><a href='https://webworks.london/services/announcements.php' target='_blank' rel='nofollow'>Latest news and announcements</a></strong></li>
  <li><strong><a href='https://webworks.london/services/serverstatus.php' target='_blank' rel='nofollow'>Network Status</a></strong></li>
  </ul>
  <strong>Log in to the client area</strong><br />
  <form class='wp-dash-login' method='post' target='_blank' action='https://webworks.london/services/dologin.php'>
<input class='fw-input' type='text' name='username' size='50' placeholder='Email address'/>
<input class='fw-input' type='password' name='password' size='20' autocomplete='off' placeholder='Password'/>
<input type='submit' value='Login' />
<a href='https://webworks.london/services/dashbd/login.php?action=reset' target=_'blank'>Forgot your password?</a>
</form>";
}

// Mail header return path
add_action( 'phpmailer_init', 'fix_my_email_return_path' );

function fix_my_email_return_path( $phpmailer ) {
    $phpmailer->Sender = $phpmailer->From;
}

// Add Webworks logo to admin bar and link to site
function ww_service_link() {
    global $wp_admin_bar, $wpdb;

    if ( !is_admin_bar_showing() )
        return;

	$ticket_link = '<a href="https://webworks.london/services/link.php?id=2" target="_blank" rel="nofollow">Raise a ticket</a>';
	$client_area_link = '<a href="https://webworks.london/services/clientarea.php" target="_blank" rel="nofollow">Client Area</a>';
	$knowledgebase_link = '<a href="https://webworks.london/services/knowledgebase.php" target="_blank" rel="nofollow">Knowledgebase</a>';
	$announcements_link = '<a href="https://webworks.london/services/announcements.php" target="_blank" rel="nofollow">Announcements</a>';
	$status_link = '<a href="https://webworks.london/services/serverstatus.php" target="_blank" rel="nofollow">Server status</a>';
		
    $wp_admin_bar->add_menu( array( 'id' => 'webworks_link', 'title' => __( '', 'textdomain' ), 'href' => FALSE ) );
	/* Add the main siteadmin menu item */
    $wp_admin_bar->add_menu( array( 'parent' => 'webworks_link', 'title' => $ticket_link, 'href' => FALSE ) );
	$wp_admin_bar->add_menu( array( 'parent' => 'webworks_link', 'title' => $client_area_link, 'href' => FALSE ) );
	$wp_admin_bar->add_menu( array( 'parent' => 'webworks_link', 'title' => $knowledgebase_link, 'href' => FALSE ) );
	$wp_admin_bar->add_menu( array( 'parent' => 'webworks_link', 'title' => $announcements_link, 'href' => FALSE ) );
	$wp_admin_bar->add_menu( array( 'parent' => 'webworks_link', 'title' => $status_link, 'href' => FALSE ) );
}

add_action( 'admin_bar_menu', 'ww_service_link', 1000 );



 ?>
