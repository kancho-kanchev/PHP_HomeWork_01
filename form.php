<?php 
mb_internal_encoding('UTF-8');
$pageTitle = 'Форма';
$selectTitle = 'Избери';
require_once 'includes/header.php';
if ($_POST) {
	if (isset($_POST['rows'])){
		echo $_POST['rows'];
	}
	$article = str_replace('; ', ' ', $_POST['article']);
	$article = str_replace(';', ' ', $article);
	$article = trim($article);
	$amount = trim($_POST['amount']);
	$amount = (int)$amount;
	$price = trim($_POST['price']);
	$price = str_replace(',', '.', $price);
	$price = floatval($price);
	$price = round($price, 2);
	$selectedGroup = (int)$_POST['group'];
	$error = false;
	if (mb_strlen($article)<3){
		echo '<p>Името на артикула/услугата е прекалено късо</p>';
		$error = true;
	}
	if ($amount<=0){
		echo '<p>Невалидна стойност за количество</p>';
	}
	if ($price<=0){
		echo '<p>Невалидна стойност за цена</p>';
		$error = true;
	}
	if (!array_key_exists($selectedGroup, $groups)){
		echo '<p>Невалидна група</p>';
		$error = true;
	}
	if ($selectedGroup==0){
		echo '<p>Не сте избрали група</p>';
		$error = true;
	}
	if (!$error){//. date("d.m.y", (int) $splitedArray[3]) .
		$ID = 0;
		$result=$ID.';'.date("d.m.Y").';'.$article.';'.$amount.';'.$price.';'.$selectedGroup."\n";
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