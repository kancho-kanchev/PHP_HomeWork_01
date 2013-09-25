<?php 
mb_internal_encoding('UTF-8');
$pageTitle = 'Форма';
$selectTitle = 'Избери'; // Добавя "Избери" в падащото меню за група
require_once 'includes/header.php';
if ($_POST && isset($_POST['action'])) {
	$action = $_POST['action'];
	if ($action=='add'){
		$nextStep = 'form.php';
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
	if ($action=='edit' || $action=='del'){
		$nextStep = 'index.php';
		if (file_exists('data.txt')){
			$result = file('data.txt');
			$row = 0;
			foreach ($result as $value){
				$row++;
				$value = trim($value);
				if ($value == trim($_POST['value']) && $row == $_POST['row'])  {
					$columns = explode(';', $value);
					$date = $columns[1];
					$article = $columns[2];
					$amount = $columns[3];
					$price = $columns[4];
					$group = $groups[trim($columns[5])];
				}
			}
		}
		else {
			echo 'ГРЕШКА -> НЯМА ФАЙЛ';
		}
	}
	if ($action=='edit_is_true' || $action=='del_is_true'){
		
	}
}
else {
	$action = 'add';
}
echo "\n".'<pre>'.print_r( $_POST, true).'</pre>'."\n";
//echo (int) ( (0.1+0.7) * 10 ); // извежда 7! ---> интересен факт за PHP 
?>
	<form method="POST" action="<?= $nextStep; ?>">
		<input type="hidden" name="action" value="<?= ($action=='add') ? $action : $action.'_is_true' ?>"/>
		<div>Дата:<input type="text" name="date" value="<?= (isset($date)) ? $date : '';?>"/></div>
		<div>артикул:<input type="text" name="article" value="<?= (isset($article)) ? $article : '';?>"/></div>
		<div>количество:<input type="text" name="amount" value="<?= (isset($amount)) ? $amount : '';?>"/></div>
		<div>цена:<input type="text" name="price"  value="<?= (isset($price)) ? $price : '';?>"/></div>
		<div>група:
			<select name="group">
				<?php 
					echo'<option value="0">'.$selectTitle.'</option>'."\n";
					foreach ($groups as $key=>$value) {
						echo'				<option value="'.$key.'"';
						if (trim($group)==$value){
							echo ' selected';
						}
						echo '>'.$value.'</option>'."\n";
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