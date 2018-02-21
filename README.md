# Telegram Bot
This git let you setup your own telegram bot in just 2 minutes.

*Note: To get all information of group you need to add your BOT to that group. 

# Settingup webhook
Requirenment:
  -Webserver with valid SSL certificate.
  -Create These files in your server in the same directory of your bot file.

## To setup webhook open this URL in browser
https://api.telegram.org/bot{Your-BOT-TOKEN}/setwebhook?url=https://yourdomain.com/bot/full/path

## Greet New Users with welcome message
$bot->newUserCheck('Your custom Message Here.');

## To get new Pinned Message.
$bot->checkPinnedMessage();

## To get Group Chat Admin
$bot->getChatAdmin('@yourgroup');

*More Function Welcome
