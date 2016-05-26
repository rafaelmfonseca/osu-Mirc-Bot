<?php
include_once "OSUBot.php";

class BanchoBot extends OSUBot {

    // Handle result
    public $result = array( "Status" => "Idle" );
    private $count = 0;

    /**
     * Opens the server connection.
     * @param array
     */
    function __construct($config)
    {
        $this->socket = fsockopen($config["server"], $config["port"]);
        $this->login($config);
        $this->main($config);
    }

    /**
     * Log me on the server.
     * @param array
     */
    function login($config)
    {
        $this->send_data('PASS', $config["pass"]);
        $this->send_data('NICK', $config["nick"]);
        $this->send_data('USER', $config["nick"] . ' 8 * :' . $config["nick"]);
        $this->send_data('JOIN', '#BanchoBot');
        $this->send_data('PRIVMSG Banchobot STATS', $config["whois"]);
    }

    /**
     * Main function.
     */
    function main($config)
    {
        $data = fgets($this->socket, 256);

        if($count < 50){
            echo nl2br($data);
        }else{
            $this->close();
            return;
        }

        flush();

        $this->main($config);
    }

}
