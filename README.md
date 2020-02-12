# tg-wp-bot-stub
This a WordPress plugin for one single purpose. Simplify the process of creating Telegram bots with WordPress.

## Installation
Download the plugin and install it into WordPress via FTP or Backend.

Go to the settings page "TG WP Bot" and insert the bot token retrieved by t.me/botfather .
Afterwards you are all set, the Telegram bot should answer you the exact same phrase you send to it.

## Features
It uses the wp-json rest API with a secret Endpoint, so nobody else than you can see where it is.
The main process is the one you have to adopt according to your business logic.

## How to find my chat_id for restrictions
I suppose you can send your own chat id back in the main process or you use 
the @JsonDumpBot
 
## Usage
Find the main process in tg-wp-main-process.php and adopt it to your needs.
If you need to send a custom message
Insert an array with the parameters
Array("command" => "botcommand" , "body" => array ("some_param" => "some_value))

## New function wp_mail to Telegram bot
This is the newest change in version 0.2
it is a filter for wp_mail sending all e-mails to your Telegram bot,
restricted by your chat id. So you never need any emails anymore
because they are all send to Telegram instead of mail.
Attention: It really sends all emails to the bot so password reset, woocommerce
and anything else is delivered to Telegram, so nobody else is getting mails.
Also file attachments for e-mails are untested.


