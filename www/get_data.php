<?php
//подключаем скрипт с описанием класса фабрики
require "factory.php";

//номер договора
$number = isset($_GET["number"]) ? $_GET["number"] : "";

//массив статусов
$status_ = isset($_GET["status"]) ? $_GET["status"] : "";

//статусы в формате дл€ услови€ во фразе where
$status = "";
foreach ($status_ as $val){
	if ($status == "") $status = "'".$val."'";
	else $status = $status.",'".$val."'";
}

//создаем класс фабрику - в конструкторе подключение к Ѕƒ
$factory = new factory;

//формируем карточки клиентов
$factory->new_client_cards($number, $status);

//если карточка клиента не найдена
if (empty($factory->client_cards)){
	$response = array("name_customer"=>"none");
	echo json_encode($response);	
	exit;
}

//получить key первой карточки - массив ассоциативный
$id_customer=array_keys($factory->client_cards)[0];

//масив с данными дл€ json 
$response = array(
	"name_customer"=>$factory->client_cards[$id_customer]->name_customer,
	"company"=>$factory->client_cards[$id_customer]->company,
	"number"=>$factory->client_cards[$id_customer]->number,
	"date_sign"=>$factory->client_cards[$id_customer]->date_sign,
	
	"services_name"=>$factory->client_cards[$id_customer]->services_name
);

//json ответ
echo json_encode($response);
?>