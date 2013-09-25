<?php 
mb_internal_encoding('UTF-8');
$pageTitle = 'Форма';
$selectTitle = 'Избери'; // Добавя "Избери" в падащото меню за група
require_once 'includes/header.php';
if ($_POST && isset($_POST['action'])) {
	$action = $_POST['action'];
	if ($action=='add'){
		//нормализация
		if (isset($_POST['article'])){
			$article = str_replace('; ', ' ', $_POST['article']);
			$article = str_replace(';', ' ', $article);
			$article = trim($article);
		}
		if (isset($_POST['amount'])){
			$amount = trim($_POST['amount']);
			$amount = (int)$amount;
		}
		if (isset($_POST['price'])){
			$price = trim($_POST['price']);
			$price = str_replace(',', '.', $price);
			$price = floatval($price);
			$price = round($price, 2);
		}
		if (isset($_POST['group'])){
			$selectedGroup = (int)$_POST['group'];
		}
		//валидация
		$error = false;
		if (isset($article) && mb_strlen($article)<3){
			echo '<p>Името на артикула/услугата е прекалено късо</p>';
			$error = true;
		}
		if (isset($amount) && $amount<=0){
			echo '<p>Невалидна стойност за количество</p>';
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
		if (!$error){//. date("d.m.y", (int) $splitedArray[3]) .
			if (file_exists('data.txt')){
				$result = file('data.txt');
				$id = count($result);
			}
			else {
				$id=1;
			}
			$result=$id.';'.date("d.m.Y").';'.$article.';'.$amount.';'.$price.';'.$selectedGroup."\n";
			//if (file_put_contents('data.txt', $result, FILE_APPEND)){
			//	echo 'Записа е успешен';
			//}
			echo $result;
		}
	}
	if ($action=='edit'){
		if (file_exists('data.txt')){
			$result = file('data.txt');
			$row = 0;
			$match = false;
			$resultRow = $_POST['id'].';'.$_POST['date'].';'.$_POST['article'].';'.$_POST['amount'].';'.$_POST['price'].';'.$_POST['group']."\n";
			foreach ($result as $value){
				$row++;
				echo $row.' '.$_POST['row'].'</br>';
				echo $value.'</br>';
				echo $_POST['value'].'</br>';
				if ($value == $_POST['value']) {
					$match = true;
				}
			}
			if ($match) {
				echo 'savpada';
			}
			else echo 'ne savpada';
		}
		else {
			echo 'ГРЕШКА -> НЯМА ФАЙЛ';
		}
	}
	if ($action=='del'){
		if (file_exists('data.txt')){
			$result = file('data.txt');

		}
		else {
			echo 'ГРЕШКА -> НЯМА ФАЙЛ';
		}
	}
}
else {
	$action = 'add';
}
echo "\n".'<pre>'.print_r( $_POST, true).'</pre>'."\n";
//echo (int) ( (0.1+0.7) * 10 ); // извежда 7! ---> интересен факт за PHP 
?>
	<form method="POST" action="form.php"> <!-- action-a е указан за прегледност -->
		<input type="hidden" name="action" value="<?= $action ?>"/>
		<div>Дата:<input type="text" name="date" /></div>
		<div>артикул:<input type="text" name="article" /></div>
		<div>количество:<input type="text" name="amount" /></div>
		<div>цена:<input type="text" name="price" /></div>
		<div>група:
			<select name="group">
				<?php 
					echo'<option value="0">'.$selectTitle.'</option>'."\n";
					foreach ($groups as $key=>$value) {
						echo'				<option value="'.$key.'">'.$value.'</option>'."\n";
					}
				?>
			</select>
		</div>
		<div><input type="submit" value="<?php
switch ($action) {
	case 'add':
		echo "Добави";
		break;
	case 'edit':
		echo "Редактирай";
		break;
	case 'del':
		echo "Изтрий";
		break;
	default:
		echo "Добави";
}?>" /></div>
	</form>
	<form method="POST" action="index.php">
	    <input type="submit" value="Отказ">
	</form>
<?php 
include_once 'includes/footer.php';
?>