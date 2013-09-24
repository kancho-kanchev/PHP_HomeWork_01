<?php 
mb_internal_encoding('UTF-8');
$pageTitle = 'Форма';
$selectTitle = 'Избери';
require_once 'includes/header.php';
if ($_POST) {
	if (isset($_POST['rows'])){
		$rows = $_POST['rows'];
	}
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
	if (isset($selectedGroup) && !array_key_exists($selectedGroup, $groups)){
		echo '<p>Невалидна група</p>';
		$error = true;
	}
	if (isset($selectedGroup) && $selectedGroup==0){
		echo '<p>Не сте избрали група</p>';
		$error = true;
	}
	if (!$error){//. date("d.m.y", (int) $splitedArray[3]) .
		$result=++$rows.';'.date("d.m.Y").';'.$article.';'.$amount.';'.$price.';'.$selectedGroup."\n";
		if (file_put_contents('data.txt', $result, FILE_APPEND)){
			echo 'Записа е успешен';
		}
		//echo $result;
	}
}
echo "\n".'<pre>'.print_r( $_POST, true).'</pre>'."\n";
//echo (int) ( (0.1+0.7) * 10 ); // извежда 7!
?>
	<a href="index.php">Списък</a>
	<form method="POST">
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
		<div><input type="submit" value="Добави" /></div>
	</form>
<?php 
include_once 'includes/footer.php';
?>