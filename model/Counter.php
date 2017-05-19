<?php
class Counter implements JsonSerializable {

    private $id;
    private $dateEvent;
    private $token;
    private $type;
    private $total;
	
	function __construct($id = 0, $dateEvent = '', $token = 0, $type = '', $total = 0) {
		$this->id = $id;
		$this->dateEvent = $dateEvent;
		$this->token = $token;
		$this->type = $type;
		$this->total = $total;
	}

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getDateEvent() {
        return $this->dateEvent;
    }

    public function setDateEvent($dateEvent) {
        $this->dateEvent = $dateEvent;
        return $this;
    }
	
	public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

	public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }
	
	public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'dateEvent' => $this->getDateEvent(),
            'token' => $this->getToken(),
            'total' => $this->getTotal(),
            'type' => $this->getType()
        ];
    }
}
?>