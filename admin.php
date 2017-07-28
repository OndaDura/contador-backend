<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methos: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
header("Content-Type: application/json");

require_once('connection/connection.php');
require_once('Registry.php');
require_once('dao/UserDAO.php');
require_once('model/User.php');
require_once('dao/CounterDAO.php');
require_once('model/Counter.php');

$registry = Registry::getInstance();
$registry->set('Connection', $conn);

$data = json_decode(file_get_contents('php://input'), true);

$json_str = 'Nenhuma informação selecionada';

if ($data["action"] == 'token') {
	$userDAO = new UserDAO();
	$user = $userDAO->activeUserByToken($data["token"]);
	
	$json_str = json_encode($user);
} elseif ($data["action"] == 'removeAdmin') {
	$userDAO = new UserDAO();
    $ok = $userDAO->desactiveUser($data["token"]);

    $json_str = json_encode(['ok' => $ok]);
} elseif ($data["action"] == 'newCounter') {
	$counterDAO = new CounterDAO();
	$counters = [];
	if ($data["type"] == 'SOMMA') {
	    
	    $counter = new Counter();
	    $counter->setIdAdmin($data["id"]);
    	$counter->setDateEvent($data["date"]);
    	$counter->setHour($data["hour"]);
    	$counter->setTitle($data["title"]);
		
    	$counter->setType("Total");
    	array_push($counters, $counterDAO->insert($counter));
    	
    	$counter->setType("Visitantes");
    	array_push($counters, $counterDAO->insert($counter));
    	
    	$counter->setType("Kinder");
    	array_push($counters, $counterDAO->insert($counter));
		
		$counter->setType("Cadeiras");
    	array_push($counters, $counterDAO->insert($counter));
		
		$counter->setType("Convertidos");
    	array_push($counters, $counterDAO->insert($counter));
		
		$counter->setType("Voluntarios");
    	array_push($counters, $counterDAO->insert($counter));
	} elseif ($data["type"] == 'METANOIA') {
	    $counter = new Counter();
	    $counter->setIdAdmin($data["id"]);
    	$counter->setDateEvent($data["date"]);
    	$counter->setHour($data["hour"]);
    	$counter->setTitle($data["title"]);
    	$counter->setType("Total");
    	
    	array_push($counters, $counterDAO->insert($counter));
    	
    	$counter->setType("Batizados");
	
    	array_push($counters, $counterDAO->insert($counter));
	} else {
	    $counter = new Counter();
	    $counter->setIdAdmin($data["id"]);
    	$counter->setDateEvent($data["date"]);
    	$counter->setHour($data["hour"]);
    	$counter->setType($data["type"]);
    	$counter->setTitle($data["title"]);
	
    	array_push($counters, $counterDAO->insert($counter));
	}
    	
    $json_str = json_encode($counters);   
	
} elseif ($data["action"] == 'openCounter') {
	$counterDAO = new CounterDAO();
	$counter = new Counter();
	
	$counter = $counterDAO->openNewCounter($data["token"]);
	
	$json_str = json_encode($counter);
} elseif ($data["action"] == 'disableCounter') {
	$counterDAO = new CounterDAO();	
	$counterDAO->disable($data["id"], $data["type"]);
} elseif ($data["action"] == 'syncCounter') {
	$counterDAO = new CounterDAO();
	
	$total = $counterDAO->sync($data["id"], $data["amount"]);
	$json_str = json_encode(['total' => $total]);
}
echo $json_str;
?>