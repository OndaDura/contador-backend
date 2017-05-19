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

$registry = Registry::getInstance();
$registry->set('Connection', $conn);

$data = json_decode(file_get_contents('php://input'), true);

$userDAO = new UserDAO();
$json_str = 'Nenhuma informação selecionada';

if ($data["action"] == 'token') {
	$user = $userDAO->activeUserByToken($data["token"]);
	
	$json_str = json_encode($user);
} elseif ($data["action"] == 'removeAdmin') {
    $ok = $userDAO->desactiveUser($data["token"]);

    $json_str = json_encode(['ok' => $ok]);
} elseif ($data["action"] == 'newCounter') {

}
echo $json_str;
?>