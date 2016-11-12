<?php
//���������� ������ � ��������� ������ �������
require "factory.php";

//����� ��������
$number = isset($_GET["number"]) ? $_GET["number"] : "";

//������ ��������
$status_ = isset($_GET["status"]) ? $_GET["status"] : "";

//������� � ������� ��� ������� �� ����� where
$status = "";
foreach ($status_ as $val){
	if ($status == "") $status = "'".$val."'";
	else $status = $status.",'".$val."'";
}

//������� ����� ������� - � ������������ ����������� � ��
$factory = new factory;

//��������� �������� ��������
$factory->new_client_cards($number, $status);

//���� �������� ������� �� �������
if (empty($factory->client_cards)){
	$response = array("name_customer"=>"none");
	echo json_encode($response);	
	exit;
}

//�������� key ������ �������� - ������ �������������
$id_customer=array_keys($factory->client_cards)[0];

//����� � ������� ��� json 
$response = array(
	"name_customer"=>$factory->client_cards[$id_customer]->name_customer,
	"company"=>$factory->client_cards[$id_customer]->company,
	"number"=>$factory->client_cards[$id_customer]->number,
	"date_sign"=>$factory->client_cards[$id_customer]->date_sign,
	
	"services_name"=>$factory->client_cards[$id_customer]->services_name
);

//json �����
echo json_encode($response);
?>