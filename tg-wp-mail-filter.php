<?php
// We have a relative new approach on E-Mails here.
// if the checkbox in the admin page is checked
// wp_mail does not work anymore and sends it to
// Telegram bot instead

add_filter('wp_mail','tg_wp_mail_filter', 10,1);

function tg_wp_mail_filter( $args )
{
	$tg_wp_mail_activated = get_option("tg_filter_wp_mail", false);
	if ( $tg_wp_mail_activated == 'on')
	{
		
		// now we set the tg_message
		$tg_message = $args['to'] ."\n";
		$tg_message .= $args['subject'] ."\n";
		$tg_message .= $args['message'] ."\n";
		$tg_message .= $args['headers'] ."\n";
		
		// do we have file attachments?
		// but we have not tested it right now
		$with_attachments = false;
		if ( count ($args['attachments']) > 0)
		{
			$attachments = $args['attachments'];
			$with_attachments = true;
		}
		
		
		
		// Now we send the stuff from the message to Telegram
		// We need to do this foreach chat ids
		$tg_wp_mail_bot_chat_ids = explode(';' , get_option("tg_wp_mail_bot_chat_ids", false));

		foreach ($tg_wp_mail_bot_chat_ids as $chat_id)
		{
			$input = array();
			$input['command'] = "sendMessage";
			$input['body'] = array(
				"chat_id" => $chat_id,
				"text" => $tg_message
				);
			tg_wp_send($input);
			
			// if we have attachments, we do it again foreach file
			// its only pretending it works like this, we still dont know
			if ( $with_attachments )
			{
				foreach ( $attachments as $attachment )
				{
					$input['command'] = "sendDocument";
					$input['body'] = array(
						"chat_id" => $chat_id,
						"document" => array(
							"type" => 'document',
							"media" => $attachment
							)
						);
					tg_wp_send($input);
				}
			}
		}
		
		
		return array (
			'to' => "",
			'headers' => "",
			'message' => "",
			'subject' => ""
			);
		
	}
	else
	{
		// We only return args , when filter is inactive
		return $args;
	}

}



?>