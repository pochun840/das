<?php

if (file_exists('/var/www/html/database/das.db') && PHP_OS_FAMILY == 'Linux') {
	$db_iDas = new PDO('sqlite:/var/www/html/database/das.db'); //das設定DB
	// $db_iDas = new PDO('sqlite:./das.db'); //das設定DB
	$result = $db_iDas->query("SELECT * FROM config WHERE config_name = 'agent_type' ");
	$rows = $result->fetch(PDO::FETCH_ASSOC);
	$agent_type = $rows['config_value'];

	$result = $db_iDas->query("SELECT * FROM config WHERE config_name = 'agent_server_ip' ");
	$rows = $result->fetch(PDO::FETCH_ASSOC);
	$agent_server_ip = $rows['config_value'];

	$db_iDas = null;
	$result = null;

	if( $agent_type == 1 && $agent_server_ip != '' ){// client
        // $pgrepCommand = "php /var/www/html/client2.php";
        // exec($pgrepCommand, $pidList);
        exec('bash -c "exec nohup setsid php /var/www/html/das/service/agent_client.php > /dev/null 2>&1 &"');
	}

	if($agent_type == 2){// server
		// $pgrepCommand = "php /var/www/html/server.php";
        // exec($pgrepCommand, $pidList);
        exec('bash -c "exec nohup setsid php /var/www/html/das/service/agent_server.php > /dev/null 2>&1 &"');
        exec('bash -c "exec nohup setsid php /var/www/html/das/service/agent_client.php > /dev/null 2>&1 &"');
	}
}

