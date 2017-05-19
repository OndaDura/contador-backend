<?php
include_once('model/Counter.php');

class CounterDAO {

    private $conn;

    public function __construct() {
        $registry = Registry::getInstance();
        $this->conn = $registry->get('Connection');
    }

    public function insert(User $user) {
        $this->conn->beginTransaction();
		
        try {
            $stmt = $this->conn->prepare(
                'INSERT INTO users (name, token) VALUES (:name, :token)'
            );

            $stmt->bindValue(':name', $user->getName());
            $stmt->bindValue(':token', $user->getToken());
            $stmt->execute();

            $this->conn->commit();
        }
        catch(Exception $e) {
            $this->conn->rollback();
        }
    }

    public function getAll() {
        $stmt = $this->conn->query(
            'SELECT * FROM users'
        );

        return $this->processResults($stmt, 1);
    }
	
	public function activeUserByToken($token) {
		$stmt = $this->conn->prepare(
			'UPDATE users SET active = 1, date_register = NOW() WHERE token = :token AND active = 0'
		);
		$stmt->execute(array(
			':token' => $token
		));
		if($stmt->rowCount()) {
			$stmt = $this->conn->prepare(
				'SELECT * FROM users WHERE token = :token'
			);
			$stmt->execute(array(
				':token' => $token
			));
			return $this->processResults($stmt, 0);
		}
		return new User();
	}

	public function desactiveUser($token) {
        $stmt = $this->conn->prepare(
            'UPDATE users SET active = 0, date_register = NULL WHERE token = :token AND active = 1'
        );
        $stmt->execute(array(
            ':token' => $token
        ));
        return $stmt->rowCount() != 0;
    }

    private function processResults($stmt, $type = 1) {
        if($stmt) {
			if ($type == 1) {
				$results = array();
				while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
					$user = new User($row->id, $row->name, $row->token, $row->active, $row->date_register);
					$results[] = $user;
				}
				return $results;
			} else {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$user = new User($row->id, $row->name, $row->token, $row->active, $row->date_register);
				return $user;
			}
        }
        return new User();
    }
}
?>