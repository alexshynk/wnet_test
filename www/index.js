$(document).ready(function(){
	
	//очистить данные на странице поиска
	$("#number").val("");
	$("input[type=checkbox]").prop('checked', false);
})

//ко вводу только цифры
function keypress_n(e){
	var charCode = (e.which) ? e.which : e.keyCode;
	
	if (charCode != 8 &&(charCode < 48 || charCode > 57) && charCode != 116){
		alert("Ко вводу только цифры");
		return false;
	}
    return true;
}

//функция выполняющая отправку поисковых данных и получение карточки клиента
function fsearch_client(){
	var number = document.getElementById("number").value;
	if (number.trim()=="") {
		alert("Укажите номер договора");
		return false;
	}
	
	var el_status = document.getElementsByName("status[]");
	var status = [];
	for(i=0; i<el_status.length; i++) if (el_status[i].checked){
		status.push(el_status[i].value);
	}
	if (status.length == 0){
		alert("Выберите по крайне мере один статус договора");
		return false;
	}

	$.ajax({
		method: "GET",
		url: "get_data.php",
		data: {"number":number,"status":status},
		dataType: "json",
		async: false,
		success: function(res){
			if (res.name_customer=="none") alert("Карточка клиента не найдена");
			
			else
			location.href="card.html?name_customer="+res.name_customer+
				"&company="+res.company+
				"&number="+res.number+
				"&date_sign="+res.date_sign+
				"&services_name="+res.services_name;
		}
	});
}