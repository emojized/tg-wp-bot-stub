<?php

function run_tg_wp_process($request)
{
	$parameters = $request->get_json_params();
	$chat_id = $parameters['message']['chat']['id'];

	if(tg_wp_user_is_allowed_to_use_bot((string)$chat_id))
	{
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
}

?>