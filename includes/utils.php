<?php
//нормализация
function normalize (){
	if (isset($_POST['article'])){
		$_POST['article'] = str_replace('; ', ' ', $_POST['article']);
		$_POST['article'] = str_replace(';', ' ', $_POST['article']);
		$_POST['article'] = trim($_POST['article']);
	}
	if (isset($_POST['amount'])){
		$_POST['amount'] = trim($_POST['amount']);
		$_POST['amount'] = (int)$_POST['amount'];
	}
	if (isset($_POST['price'])){
		$_POST['price'] = trim($_POST['price']);
		$_POST['price'] = str_replace(',', '.', $_POST['price']);
		$_POST['price'] = floatval($_POST['price']);
		$_POST['price'] = round($_POST['price'], 2);
	}
	if (isset($_POST['group'])){
		$_POST['group'] = (int)$_POST['group'];
	}
}

//валидация
function validation($article, $amount, $price, $selectedGroup, $groups){
	$error = false;
	if (isset($article) && mb_strlen($article)<3){
		echo '<p>Името на артикула/услугата е прекалено късо</p>';
		$error = true;
	}
	if (isset($amount) && $amount<=0){
		echo '<p>Невалидна стойност за количество</p>';
		$error = true;
	}
	if (isset($price) && $price<=0){
		echo '<p>Невалидна стойност за цена</p>';
		$error = true;
	}
	if (isset($selectedGroup) && !array_key_exists($selectedGroup, $groups) && !$selectedGroup==0){
		echo '<p>Невалидна група</p>';
		$error = true;
	}
	if (isset($selectedGroup) && $selectedGroup==0){
		echo '<p>Не сте избрали група</p>';
		$error = true;
	}
	return $error;
}
?>