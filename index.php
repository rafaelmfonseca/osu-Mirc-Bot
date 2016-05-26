<?php
// So the bot doesnt stop
set_time_limit(0);
ini_set('display_errors', 'on');

include "libraries/OSUBot.php";

// Get the user
$user = @$_GET['user'];
$callback = @$_GET['callback'];

if(empty($user) || empty($callback) || !preg_match("/^[a-zA-Z0-9\[\]\s\-\_]*$/", $user))
{
    exit();
}

// Connection data
$config = array('server'  =>  'cho.ppy.sh',
                'port'    =>  6667,
                'name'    =>  '',
                'nick'    =>  '',
                'pass'    =>  '',
                'whois'   =>  str_replace(' ', '_', $user) );

//Start the bot
$bot = new OSUBot($config);

// Show the result
echo sprintf('%s({"%s":"%s"});', $callback, "Result", $bot->result["Status"]);

?>
