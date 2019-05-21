# tg-wp-bot-stub
This a WordPress plugin for one single purpose. Simplify the process of creating Telegram bots with WordPress.

## Installation
Download the plugin and install it into WordPress via FTP or Backend.

Hi to the settings page "TG WP Bot" and insert the bot token retrieved by t.me/botfather .
Afterwards you are all set, the Telegram bot should answer you the exact same phrase you send to it.

## Features
It uses the wp-json rest API with a secret Endpoint, so nobody else than you can see where it is.
The main process is the one you have to adopt according to your business logic.
 
## Usage
Find the main process on ... and adopt it to your needs.
If you need to send a custom message
Insert an array with the parameters
Array("command" => "botcommand" , "body" => array ("some_param" => "some_value))


