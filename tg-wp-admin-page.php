<?php

// Admin Page init
add_action( 'admin_menu', 'tg_wp_admin_page' );

function tg_wp_admin_page()
{
	add_menu_page( 'TG WP Admin', 'TG WP Admin', 'manage_options', 'tg-wp/tg-wp-admin-page.php',
					'render_tg_wp_admin_page', 'dashicons-admin-collapse', 25  );
}

function render_tg_wp_admin_page()
{

	echo '<div class="wrap">';
	echo '<h1>TG WP Bot Stub Admin</h1>';

	echo '<p>Here you can configure your Bot Details</p>';
	
	if ( 
		 isset( $_POST['tg_wp_nonce_field'] ) 
		&& ! wp_verify_nonce( $_POST['tg_wp_nonce_field'], 'tg_wp_save_options' ) 
	) {
	
	   print 'Sorry, your nonce did not verify.';
	   exit;
	
	}
	else if (isset($_POST['wp_tg_bottoken']))
	{
		echo '<pre>';
		var_dump($_POST);
		echo '</pre>';
		
		update_option('tg_wp_bottoken', sanitize_text_field($_POST['wp_tg_bottoken']), true);
		
	}
	
	$bot_token = get_option('tg_wp_bottoken', true);
	
	echo '<table class="widefat striped">';
		
	echo '<form method="POST">';
	echo '<tbody>';
		
		
	// Bot token Line
	echo '<tr>';
	echo '<td>';
		
	
	echo '<span class="importer-title">Bot Token</span>';
	echo '<span class="importer-action">Insert here the bot token retrieved by @botfather</span>';	
	echo '</td>';
	
	echo '<td class="desc">';
	echo '<span class="importer-desc"><input type="text"  value="'.$bot_token.'" name="wp_tg_bottoken" /></span>';
	echo '</td>';
	echo '</tr>';
	
	// Webhook  Line
	
	echo '<tr>';
	echo '<td>';
		
	
	echo '<span class="importer-title">Webhook</span>';
	echo '<span class="importer-action">Insert here the bot token retrieved by @botfather</span>';	
	echo '</td>';
	
	echo '<td class="desc">';
	echo '<span class="importer-desc"><pre>';
	
	//should ulitize 
	//https://API.telegram.org/botTOKEN/getWebhookInfo
	
	echo '</pre></span>';
	echo '</td>';
	echo '</tr>';
	
	// User  Lines
	
	echo '<tr>';
	echo '<td>';
		
	
	echo '<span class="importer-title">Users</span>';
	echo '<span class="importer-action">Insert here the bot token retrieved by @botfather</span>';	
	echo '</td>';
	
	echo '<td class="desc">';
	echo '<span class="importer-desc">little ipsum</span>';
	echo '</td>';
	echo '</tr>';
	
	echo '</tbody>';
	echo '</table>';
	wp_nonce_field( 'tg_wp_save_options', 'tg_wp_nonce_field' );
	
	echo '<input type="submit" value="Send Data" class="button button-primary" />';
	echo '</form>';
	
	
	echo '</div>'; // end wrap
}



?>