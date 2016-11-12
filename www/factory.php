<?php
//настройки подключения к БД
require 'db.php';

function to_log($text){
	$f=fopen("log.txt","a");
	fputs($f,$text."\n");
	fclose($f);
}

//фабричный класс
class factory{
	public $client_cards = array();

	public function __construct(){
		$this->mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSW, DB_NAME);
		if ($this->mysqli->connect_errno){
			$err = "Не удалось подключиться к MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
			to_log($err);
			throw new Exception($err);
		}
	}
	
	public function new_client_cards($number, $status){
		$query = sprintf("select * from vclient_card where number = '%d'",$number);
		$result = $this->mysqli->query($query);
		if(!$result){
			$err = "Ошибка в запросе: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
			to_log($err);
			throw new Exception($err);
		}
		
		//создаем объекты класса client_card для каждого id_customer
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			
			//если клиент с id_customer еще не создан - создаем новый обект класса client_card
			if (!isset($this->client_cards[$row["id_customer"]])){
				$this->client_cards[$row["id_customer"]] = new client_card;
		
				$this->client_cards[$row["id_customer"]]->name_customer = $row["name_customer"];
				$this->client_cards[$row["id_customer"]]->company = $row["company"];
				$this->client_cards[$row["id_customer"]]->number = $row["number"];
				$this->client_cards[$row["id_customer"]]->date_sign = $row["date_sign"];
	
				$query2 = sprintf("select * from vclient_services where id_contract = %d and status in (%s)",
				$row["id_contract"],$status);
			
				//получить список сервисов
				$result2 = $this->mysqli->query($query2);
				$tmp = "";
				while($row2 = $result2->fetch_array(MYSQLI_ASSOC)){
					if ($tmp=="") $tmp = $row2["title_service"];
					else $tmp = $tmp."<br>".$row2["title_service"];
				};
				$this->client_cards[$row["id_customer"]]->services_name = $tmp;
			}
		}
	}	
}

//класс для данных карточки клиента
class client_card{
	public $mysqli;
	
	public $id_customer;
	public $name_customer;
	public $company;
	public $number;
	public $date_sign;
	public $services_name;	
}
