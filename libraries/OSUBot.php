<?php
class OSUBot {

    // Handle TCP/IP connection and result
    private $socket;
    public $result = array( "Status" => "Online" );

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
        $this->send_data('WHOIS', $config["whois"]);
    }

    /**
     * Main function.
     */
    function main($config)
    {
        $data = fgets($this->socket, 256);

        if($this->contains_word(":No such nick/channel", $data)) {
            $this->result["Status"] = "Offline";
        }

        if($this->contains_word("QUIT", $data)){
            $this->close();
            return;
        }

//      echo nl2br($data);

        flush();

        $this->main($config);
    }

    /**
     * Close the server connection and show the result;
     */
    function close()
    {
        fclose($this->socket);
    }

    /**
     * Check if string contains specific words.
     * @param String $word
     * @param String $msg
     */
    function contains_word($word, $msg)
    {
        return strpos($msg, $word) !== false;
    }

    /**
     * Send data to the server.
     * @param String $cmd
     * @param String $msg
     */
    function send_data($cmd, $msg = null)
    {
        if($msg == null)
        {
            fputs($this->socket, $cmd . "\n");
        }
        else
        {
            fputs($this->socket, $cmd . ' ' . $msg . "\n");
        }
    }

}
