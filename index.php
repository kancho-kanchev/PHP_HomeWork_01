<?php 
$pageTitle = 'Списък';
$selectTitle = 'Всички';
$filterGroup = 0;
if (isset($_POST['group'])){
	$filterGroup = (int)$_POST['group'];
}
require_once 'includes/header.php';
?>
		<form method="POST" action="form.php">
			<input type="hidden" name="rows" value="4"/>
			<input type="submit" value="Добави нов разход" />
		</form>
		<form method="POST" action="index.php">
			<select name="group">
				<?php 
					echo'<option value="0">'.$selectTitle.'</option>'."\n";
					foreach ($groups as $key=>$value) {
						echo'			<option value="'.$key.'">'.$value.'</option>'."\n";
					}
				?>
			</select>
			<input type="submit" value="Филтрирай" />
		</form>
		<table border="1">
			<tr>
				<td>№</td>
				<td>Дата</td>
				<td>Разход за</td>
				<td>Количество</td>
				<td>Стойност</td>
				<td>Сума</td>
				<td>Група</td>
				<td></td>
				<td></td>
			</tr>
<?php 
if (file_exists('data.txt')){
	$result = file('data.txt');
	foreach ($result as $value){
		$columns = explode(';', $value);
		$ID = $columns[0];
		echo '<tr>
				<td>'.$columns[0].'</td>
				<td>'.$columns[1].'</td>
				<td>'.$columns[2].'</td>
				<td>'.$columns[3].'</td>
				<td>'.$columns[4].'</td>
				<td>'.$columns[3]*$columns[4].'</td>
				<td>'.$groups[trim($columns[5])].'</td>
				<td>редактирай</td>
				<td>изтрий</td>
			</tr>';
	}
}
?>
		</table>
<?php 
include_once 'includes/footer.php';
?>