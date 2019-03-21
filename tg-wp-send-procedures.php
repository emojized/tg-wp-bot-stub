<?php

// The send procedure is the direct link to Telegram Bot API

function tg_wp_send($input = array())
{
	$command = $input['command'];
	$token = get_option('tg_wp_bottoken', false);
	$url = "https://api.telegram.org/bot" . $token . "/" . $command;
	$args = array(
		'method' => 'POST',
		'timeout' => 45,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => true,
		'headers' => array() ,
		'body' => $input['body'],
		'cookies' => array()
	);
	$response = wp_remote_post($url, $args);
	$message = '';
	if (is_wp_error($response))
	{
		$error_message = $response->get_error_message();
		$message = "Something went wrong: $error_message";
	}
	else
	{
		$message = $response;
	}

	return $message;
}

add_action('rest_api_init', function ()
{
	$webhook_secret_string = get_option('tg_wp_weebhook_route', false);
	register_rest_route('tg-wp-routes/v1', $webhook_secret_string, array(
		'methods' => 'POST',
		'callback' => 'run_tg_wp_process'
	));
});

// we have to hide our own Endpoints for Security reasons

add_filter('rest_route_data',
function ($routes)
{
	$webhook_secret_string = get_option('tg_wp_weebhook_route', false);
	$hiddenRoutes = array(
		'/tg-wp-routes/v1',
		'/tg-wp-routes/v1/'. $webhook_secret_string
		);
	foreach($routes as $key => $route)
	{
		if (in_array($key, $hiddenRoutes))
		{
			unset($routes[$key]);
		}
	}

	return $routes;
});

function run_tg_wp_process($request)
{
	$parameters = $request->get_json_params();
	$chat_id = $parameters['message']['chat']['id'];
	$telegram_username = $parameters['message']['chat']['username'];
	$telegram_firstname = $parameters['message']['chat']['first_name'];
	$text = $parameters['message']['text'];

	// currently it only sends the text back you send to it

	$input = array();
	$input['command'] = "sendMessage";
	$input['body'] = array(
		"chat_id" => $chat_id,
		"text" => $text
	);
	tg_wp_send($input);
}

?>