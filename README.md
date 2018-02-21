# Telegram Bot
This git let you setup your own telegram bot in just 2 minutes.

*Note: To get all information of group you need to add your BOT to that group. 

# Settingup webhook
Requirenment:
  -Webserver with valid SSL certificate.
  -Create there files in your server in the same directory of your bot file.
    -logs.txt
    -pinnedMsg.txt

## To setup webhook open this URL in browser
https://api.telegram.org/bot{Your-BOT-TOKEN}/setwebhook?url=https://yourdomain.com/bot/full/path

## Returns true if New User, with their firstname, chatid and userid else false
$bot->newUserCheck();

## To get new Pinned Message.
$bot->checkPinnedMessage();

## To get Group Chat Admin
$bot->getChatAdmin('@yourgroup');

## Sent message to group or any person
$bot->sendMessage(chatId,"Your message here");

## To get ChatId
$bot->getChatId();
This will return chatid.

## To get UserId who messeged in group
$bot->getUserId();
This will return UserId. You can directly send personal message to any user using this ID.

*More Function Welcome
