<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methos: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
header("Content-Type: application/json");
require_once('connection/connection.php');
require_once('Registry.php');
/*require_once('dao/UserDAO.php');
require_once('model/User.php');

// Armazenar essa instância no Registry
$registry = Registry::getInstance();
$registry->set('Connection', $conn);

$primeiro = new User();
$primeiro->setName('Pessoa Teste');
$primeiro->setToken('KKKK01');

// Instanciar o DAO e trabalhar com os métodos
$userDAO = new UserDAO();
$userDAO->insert($primeiro);

// Resgatar todos os registros e iterar
$results = $userDAO->getAll();
foreach($results as $user) {
    echo $user->getId() . '<br />';
    echo $user->getName() . '<br />';
    echo $user->getToken() . '<br />';
    echo $user->getActive() . '<br />';
    echo $user->getDate() . '<br />';
    echo '<br />';
} */
$teste = $_POST['id'];
echo $teste;



/*$obj = json_decode($param);
echo $obj->action;*/

?>

