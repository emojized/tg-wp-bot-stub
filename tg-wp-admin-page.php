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
		$restriction = sanitize_text_field($_POST['tg_wp_restriction']);
		update_option('tg_wp_restriction', $restriction, false);
		$restriction_chat_ids = explode(';', sanitize_text_field($_POST['tg_wp_restriction_chat_ids']));
		update_option('tg_wp_restriction_chat_ids', $restriction_chat_ids, false);
		$webhook_secret_string = get_option('tg_wp_weebhook_route', false);
		$input['command'] = "setWebhook";
		$input['body'] = array(
			"url" => get_bloginfo("url") . "/wp-json/tg-wp-routes/v1/" . $webhook_secret_string
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
	echo '<span class="importer-action">Webhook response of command ' . $input['command'] . '</span>';
	echo '</td>';
	echo '<td class="desc">';
	echo '<span class="importer-desc"><pre>';
	echo str_replace(",", ",\n", $wbhk_response);
	echo '</pre></span>';
	echo '</td>';
	echo '</tr>';

	// User  Lines

	echo '<tr>';
	echo '<td>';
	echo '<span class="importer-title">User restriction</span>';
	echo '<span class="importer-action">Select if you wanna restrict your bot<br />to specific Chat IDs</span>';
	echo '</td>';
	echo '<td class="desc">';
	$tg_wp_restriction = get_option("tg_wp_restriction", false);
	echo '<label><input type="radio" name="tg_wp_restriction" value="false" ';
	if ($tg_wp_restriction == false || $tg_wp_restriction == "false") echo 'checked="checked" ';
	echo '/> No restriction</label><br />';
	echo '<label><input type="radio" name="tg_wp_restriction" value="chat-ids" ';
	if ($tg_wp_restriction == "chat-ids") echo 'checked="checked" ';
	echo '/> By chat_id (divided by ;)</label><br />';
	$tg_wp_restriction_chat_ids = implode(';', get_option("tg_wp_restriction_chat_ids", false));
	echo '<input type="text" name="tg_wp_restriction_chat_ids" value="' . $tg_wp_restriction_chat_ids . '" /><br />';
	if (class_exists('WPTelegram_Login'))
	{
		echo '<label><input type="radio" name="tg_wp_restriction" value="wp-telegram-login" ';
		if ($tg_wp_restriction == "wp-telegram-login") echo 'checked="checked" ';
		echo '/> By WPTelegram Login (by Manzoor Wani)</label>';
	}

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