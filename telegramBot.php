<?php

class telegramBot
{
    var $BOT_TOKEN;
    var $API_URL;
    var $update;
    var $chatId;
    var $userId;

    public function __construct()
    {   
        $BOT_TOKEN = '';
        $API_URL = '';
        $update = '';
        $chatId = '';
        $userId = '';
    }

    /**
     * @param string $API_URL
     */
    public function setAPIURL($API_URL)
    {
        $this->API_URL = $API_URL;
    }

    /**
     * @param string $BOT_TOKEN
     */
    public function setBOTTOKEN($BOT_TOKEN)
    {
        $this->BOT_TOKEN = $BOT_TOKEN;
    }



    /**
     * @return string
     */
    public function getBOTTOKEN()
    {
        return $this->BOT_TOKEN;
    }

    /**
     * @return string
     */
    public function getAPIURL()
    {
        return $this->API_URL;
    }



    /*
        To received POST data sent by telegram webhook.
    */
    public function getContents($postResponse)
    {
        $hookResponse = file_get_contents($postResponse);
        $this->update = json_decode($hookResponse, true);
    }


    /*
        For debugging purpose
    */
    public function showContents()
    {
        $this->createLogs($this->update);
    }


    /*
        Returns chatId from Data received.
    */
    public function getChatId()
    {
        $this->chatId = $this->update['message']['chat']['id'];
        return $this->chatId; 
    }

    /*
        Returns userId from Data received.
    */
    public function getUserId()
    {
        $this->userId = $this->update['message']['from']['id'];
        return $this->userId; 
    }



    /*
        This function allows you to send Message to perticular user and in a group chat
    */
    public function sendMessage($chatId,$message)
    {
        $url = $this->getAPIURL()."sendmessage?chat_id=".$chatId."&text=".urlencode($message);
        file_get_contents($url);
    }

    /*
        This function will return the list of Admin Users with their First name and Username array.
   */
    public function getChatAdmin($chatId)
    {
        $url = 'getChatAdministrators?chat_id='.$chatId;
        $users = [];
        $admins = json_decode(file_get_contents($this->getAPIURL().$url),true);
        foreach($admins['result'] as $key => $value)
            $users[] = $value['user']['first_name'].' @'.$value['user']['username'];
        return $users;
    }



    /*
        This function is create logs used for debugging. Wanna debug POST method call this method.
        *Note: Create logs.txt files first in same directory.
    */
    public function createLogs($content)
    {
        $logfile = fopen("logs.txt", "w") or die("Unable to open file!");
        fwrite($logfile, json_encode($content));
        fclose($logfile);
    }



    /*
        This function will greet every new user joins the group with welcome message.
    */
    public function newUserCheck()
    {
        if(isset($this->update['message']['new_chat_participant']))
        {
            $this->chatId = $this->update["message"]["chat"]["id"];
            $this->userId = $this->update['message']['new_chat_participant']['id'];
            
            $return = [
                'status'=>true,
                'first_name'=>$this->update['message']['new_chat_participant']['first_name'],
                'chatId'=>$this->chatId,
                'userId'=>$this->userId
                ];

            return json_encode($return);
        }
        else
        {
            return ['status'=>false];
        }
    }


    /*
        This function will check for any new pinned message and save it to file and return that message for further use. 
        Like if you want to show pinned message with greeting message to your new user or old user.
    */
    public function checkPinnedMessage()
    {
        if(isset($this->update['message']['pinned_message']))
        {
            $pinnedMsg = $this->update['message']['pinned_message']['text'];
            $myfile = fopen("pinnedMsg.txt", "w") or die("Unable to open file!");
            fwrite($myfile, $pinnedMsg);
            fclose($myfile);
        }

        $myfile = fopen("pinnedMsg.txt", "r") or die("Unable to open file!");
        $pinnedMsg = fread($myfile,filesize("pinnedMsg.txt"));
        fclose($myfile);
        return $pinnedMsg;
    }


    public function __destruct()
    {}

};

//Initialize BOT
$bot = new telegramBot();
$bot->setBOTTOKEN('132456789:YOUR-BOT-TOKEN');
$bot->setAPIURL('https://api.telegram.org/bot'.$bot->getBOTTOKEN().'/');
$bot->getContents("php://input");
$bot->sendMessage($bot->getUserId(),"Hi from bot");

?>
