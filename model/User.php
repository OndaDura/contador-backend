<?php
class User implements JsonSerializable {

    private $id;
    private $name;
    private $token;
    private $active;
    private $dateRegister;
	
	function __construct($id = 0, $name = '', $token = 0, $active = 0, $dateRegister = '') {
		$this->id = $id;
		$this->name = $name;
		$this->token = $token;
		$this->dateRegister = $dateRegister;
		$this->active = $active;
	}

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
	
	public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
        return $this;
    }

    public function getActive() {
        return $this->active;
    }

    public function setActive($active) {
        $this->active = $active;
        return $this;
    }

	public function getDateRegister() {
        return $this->dateRegister;
    }

    public function setDateRegister($date) {
        $this->dateRegister = $date;
        return $this;
    }
	
	public function jsonSerialize() {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'token' => $this->getToken(),
            'active' => $this->getActive(),
            'dateRegister' => $this->getDateRegister()
        ];
    }
}
?>