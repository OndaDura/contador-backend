<?php
class Counter implements JsonSerializable {

    private $id;
    private $dateEvent;
    private $hour;
    private $token;
    private $title;
    private $type;
    private $total;
	private $totalGeneral;
	
	function __construct($id = 0, $dateEvent = '', $hour = '', $token = 0, $title = '', $type = '', $total = 0, $totalGeneral = 0) {
		$this->id = $id;
		$this->dateEvent = $dateEvent;
		$this->hour = $hour;
		$this->token = $token;
		$this->title = $title;
		$this->type = $type;
		$this->total = $total;
		$this->totalGeneral = $totalGeneral;
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
		if(strpos($dateEvent, "/") !== false) {
			$this->dateEvent = implode("-", array_reverse(explode("/", $dateEvent)));
		} else {
			$this->dateEvent = $dateEvent;
		}
        return $this;
    }
    
    public function getHour() {
        return $this->hour;
    }

    public function setHour($hour) {
        $this->hour = $hour;
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
	
	public function getTotalGeneral() {
        return $this->totalGeneral;
    }

    public function setTotalGeneral($totalGeneral) {
        $this->totalGeneral = $totalGeneral;
        return $this;
    }
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
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
            'hour' => $this->getHour(),
            'token' => $this->getToken(),
			'title' => $this->getTitle(),
            'total' => $this->getTotal(),
            'totalGeneral' => $this->getTotalGeneral(),
            'type' => $this->getType()
        ];
    }
}
?>