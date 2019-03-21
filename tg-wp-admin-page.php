<?php

// Admin Page init

add_action('admin_menu', 'tg_wp_admin_page');

function tg_wp_admin_page()
{
	add_menu_page('TG WP Admin', 'TG WP Admin', 'manage_options', 'tg-wp/tg-wp-admin-page.php', 'render_tg_wp_admin_page', 'dashicons-admin-collapse', 25);
}

function render_tg_wp_admin_page()
{
	echo '<div class="wrap">';
	echo '<h1>TG WP Bot Stub Admin</h1>';
	echo '<p>Here you can configure your Bot Details</p>';
	if (isset($_POST['wp_tg_bottoken']) && wp_verify_nonce($_POST['tg_wp_nonce_field'], 'tg_wp_save_options'))
	{
		$token = sanitize_text_field($_POST['wp_tg_bottoken']);
		update_option('tg_wp_bottoken', $token, false);
		$webhook_secret_string = get_option('tg_wp_weebhook_route', false);
		$input['command'] = "setWebhook";
		$input['body'] = array(
			"url" => get_bloginfo("url") . "/wp-json/tg-wp-routes/v1/".$webhook_secret_string
		);
		$wbhk_response = tg_wp_send($input);
	}
	else
	{
		$input['command'] = "getWebhookInfo";
		$wbhk_response = tg_wp_send($input);
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
	echo '<span class="importer-desc"><input type="text"  value="' . $bot_token . '" name="wp_tg_bottoken" /></span>';
	echo '</td>';
	echo '</tr>';

	// Webhook  Line

	echo '<tr>';
	echo '<td>';
	echo '<span class="importer-title">Webhook</span>';
	echo '<span class="importer-action">Webhook response of command '.$input['command'] .'</span>';
	echo '</td>';
	echo '<td class="desc">';
	echo '<span class="importer-desc"><pre>';
	echo str_replace(",",",\n", $wbhk_response['body']);
	echo '</pre></span>';
	echo '</td>';
	echo '</tr>';

	// User  Lines

	echo '<tr>';
	echo '<td>';
	echo '<span class="importer-title">Users</span>';
	echo '<span class="importer-action">Users restriction is coming i nteh near future</span>';
	echo '</td>';
	echo '<td class="desc">';
	echo '<span class="importer-desc">Currently all Users are allowed</span>';
	echo '</td>';
	echo '</tr>';
	echo '</tbody>';
	echo '</table>';
	wp_nonce_field('tg_wp_save_options', 'tg_wp_nonce_field');
	echo '<input type="submit" value="Send Data" class="button button-primary" />';
	echo '</form>';
	echo '</div>'; // end wrap
}

?>