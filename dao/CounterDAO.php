<?php
include_once('model/Counter.php');
include_once('generateToken.php');

class CounterDAO {

    private $conn;

    public function __construct() {
        $registry = Registry::getInstance();
        $this->conn = $registry->get('Connection');
    }

    public function insert(Counter $counter) {
        $this->conn->beginTransaction();
		
		$token = generateToken();
		
        try {
			//INSERE UM NOVO CONTADOR
            $stmt = $this->conn->prepare(
                'INSERT INTO counters (token, id_admin, date, type) VALUES (:token, :id_admin, :date, :type)'
            );

            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':id_admin', $counter->getId());
            $stmt->bindValue(':date', $counter->getDateEvent());
            $stmt->bindValue(':type', $counter->getType());
            $stmt->execute();

            $this->conn->commit();
        }
        catch(Exception $e) {
            $this->conn->rollback();
        }
        
        return $this->getCounterToken($token, 'ASC');
    }
	
	public function openNewCounter($token) {
		$counterRef = getCounterToken($token, 'ASC');
		
        $this->conn->beginTransaction();
		
        try {
			//INSERE UM NOVO CONTADOR
            $stmt = $this->conn->prepare(
                'INSERT INTO counters (token, date, type) VALUES (:token, now(), :type)'
            );

            $stmt->bindValue(':token', $token);
            $stmt->bindValue(':type', $counterRef->getType());
            $stmt->execute();

            $this->conn->commit();
        }
        catch(Exception $e) {
            $this->conn->rollback();
        }
        
        return $this->getCounterToken($token, 'DESC');
    }
	
	public function disable($id, $type) {
		//DESATIVA UM CONTADOR PELO ID
        $stmt = $this->conn->prepare(
            'UPDATE counters SET active = :type, date_finish = NOW() WHERE id = :id AND active = 1'
        );
        $stmt->execute(array(
			':type' => $type,
            ':id' => $id
        ));
    }
	
	public function getCounterToken($token, $order = 'ASC') {
		//BUSCA O CONTADOR REFERENTE AO TOKEN
		$stmt = $this->conn->prepare(
			'SELECT * FROM counters WHERE token = :token ORDER BY :order LIMIT 1'
		);
		$stmt->execute(array(
			':token' => $token,
			':order' => $order
		));
		return $this->processResults($stmt, 0);
	}
	
	public function sync($id, $amount) {
		//INSERE O NOVO TOTAL DO CONTADOR
		$stmt = $this->conn->prepare(
            'UPDATE counters SET total = :amount WHERE id = :id AND active = 1'
        );
        $stmt->execute(array(
			':amount' => $amount,
            ':id' => $id
        ));
		
		//PEGA O CÓDIGO DO CONTADOR ATUAL
		$stmt = $this->conn->prepare(
			'SELECT token FROM counters WHERE id = :id'
		);
		$stmt->execute(array(
			':id' => $id
		));
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		
		//FAZ A SOMATÓRIA DOS CONTADORES
		$stmt = $this->conn->prepare(
			'SELECT SUM(total) as total FROM counters WHERE token = :token'
		);
		$stmt->execute(array(
			':token' => $row->token
		));
		$row = $stmt->fetch(PDO::FETCH_OBJ);
		
		//INSERE NO CONTADOR PRINCIAL O TOTAL DA SOMATORIA
		$stmt = $this->conn->prepare(
            'UPDATE counters SET total_general = :total_general WHERE id = :id AND active = 1'
        );
        $stmt->execute(array(
			':total_general' => $row->total,
            ':id' => $id
        ));
		
		return $row->total;
	}

    public function getAll() {
		//BUSCA TODOS OS CONTADORES
        $stmt = $this->conn->query(
            'SELECT * FROM counters'
        );

        return $this->processResults($stmt, 1);
    }

    private function processResults($stmt, $type = 1) {
        if($stmt) {
			if ($type == 1) {
				$results = array();
				while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
					$counter = new Counter($row->id, $row->date_event, $row->token, $row->type, $row->total, $row->total_general);
					$results[] = $counter;
				}
				return $results;
			} else {
				$row = $stmt->fetch(PDO::FETCH_OBJ);
				$counter = new Counter($row->id, $row->date_event, $row->token, $row->type, $row->total, $row->total_general);
				return $counter;
			}
        }
        return new counter();
    }
}
?>