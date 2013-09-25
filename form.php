<?php 
$pageTitle = 'Форма';
$selectTitle = 'Избери'; // Добавя "Избери" в падащото меню за група
require_once 'includes/header.php';
if ($_POST && isset($_POST['action'])) {
	$action = $_POST['action'];
	if ($action=='add'){
		$nextStep = 'form.php';
		normalize();
		if (isset($_POST['article'])) $article = $_POST['article'];
		if (isset($_POST['amount'])) $amount = $_POST['amount'];
		if (isset($_POST['article'])) $price = $_POST['price'];
		if (isset($_POST['article'])) $selectedGroup = $_POST['group'];
		$error = validation($article, $amount, $price, $selectedGroup, $groups);
		if (!$error){//. date("d.m.y", (int) $splitedArray[3]) .
			if (file_exists('data.txt')){
				$result = file('data.txt');
				$id = count($result);
			}
			else {
				$id=1;
			}
			$result=$id.';'.date("d.m.Y").';'.$article.';'.$amount.';'.$price.';'.$selectedGroup."\n";
			if (file_put_contents('data.txt', $result, FILE_APPEND)){
				echo 'Записа е успешен';
			}
			//echo $result;
			$date = date("d.m.Y");
			$article = '';
			$amount = '';
			$price = '';
			$selectedGroup = 0;
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
	$nextStep = 'form.php';
	$date = date("d.m.Y");
}
//echo "\n".'<pre>'.print_r( $_POST, true).'</pre>'."\n";
//echo (int) ( (0.1+0.7) * 10 ); // извежда 7! ---> интересен факт за PHP 
?>
	<form method="POST" action="<?= $nextStep; ?>">
		<input type="hidden" name="action" value="<?= $action; ?>"/>
		<?php if ($action=='edit' || $action=='del') echo '<input type="hidden" name="row" value="'.$_POST['row'].'"/>'; ?>
		<div>Дата:<input type="hidden" name="date" value="<?= (isset($date)) ? $date : date("d.m.Y");?>"/></div> <!-- трябва да се направи валидация за дата -->
		<div>артикул:<input type="text" name="article" value="<?= (isset($article)) ? $article : '';?>"/></div>
		<div>количество:<input type="text" name="amount" value="<?= (isset($amount)) ? $amount : '';?>"/></div>
		<div>цена:<input type="text" name="price"  value="<?= (isset($price)) ? $price : '';?>"/></div>
		<div>група:
			<select name="group">
				<?php 
					echo'<option value="0">'.$selectTitle.'</option>'."\n";
					foreach ($groups as $key=>$value) {
						echo'				<option value="'.$key.'"';
						if (isset($group) && trim($group)==$value){
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
