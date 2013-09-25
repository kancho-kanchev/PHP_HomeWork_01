<?php 
/*
 * Не ми харесва визуално GET заявката затова я ползвам само в краен случай
 * (за 'search' поле примерно)
 * по тази причина всички заявки са ми POST.
 * 
 * Нарочно не съм използвал грам CSS и JavaScript за да може да се оцени по лесно
 * PHP кода и да е по лесно на проверяващия.
 * 
 * \n ползвам за да се визуализира html кода прегледно.
 * 
 * ID-то може да се получи да не е уникално, но за всяко действие се прави проверка
 * по всички колони. Дори да има два еднакви записа няма да има проблем единият да се
 * промени или изтрие.
 * 
 */
$pageTitle = 'Списък';
$selectTitle = 'Всички'; // Добавя "Всички" в падащото меню на филтъра
$filterGroup = 0; // Задава филтър по подразбираане "Всички"
require_once 'includes/header.php';
if (isset($_POST['filterGroup'])){
	$filterGroup = (int)$_POST['filterGroup'];
}
if (isset($_POST['action']) && $_POST['action']=='edit'){
	//редактира реда
	echo 'edit';
}
if (isset($_POST['action']) && $_POST['action']=='del'){
	//изтрива реда
	echo 'del';
}
?>
		<form method="POST" action="index.php"> <!-- action-a е указан за прегледност -->
			<!-- <span>Начална дата <input type="text" name="date1" /></span> -->
			<!-- <span>Крайна дата <input type="text" name="date2" /></span> -->
			<select name="filterGroup">
				<?php 
					echo'<option value="0">'.$selectTitle.'</option>'."\n";
					foreach ($groups as $key=>$value) {
						echo'				<option value="'.$key.'"';
						if ($filterGroup==$key){
							echo 'selected';
						}
						echo '>'.$value.'</option>'."\n";
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
	$counter = 1;
	$sum = 0;
	$row = 0;
	foreach ($result as $value){
		$columns = explode(';', $value);
		$row++;
		if ($filterGroup==0 || $filterGroup==$columns[5]){
			$sum+=$columns[3]*$columns[4];
			// подавам всички данни, вкл. номера на реда за да не се получи
			// погрешно изтриване на редове чрез помпане на F5 или подобни
			echo '			<tr>
				<td>'.$counter++.'</td>
				<td>'.$columns[1].'</td>
				<td>'.$columns[2].'</td>
				<td>'.$columns[3].'</td>
				<td>'.number_format($columns[4], 2).'</td>
				<td>'.number_format($columns[3]*$columns[4], 2).'</td>
				<td>'.$groups[trim($columns[5])].'</td>
				<td>
					<form method="POST" action="form.php"> 
						<input type="hidden" name="row" value="'.$row.'"/>
						<input type="hidden" name="value" value="'.$value.'"/>
						<input type="hidden" name="action" value="edit"/>
						<input type="submit" value="Редактирай" />
					</form>
				</td>
				<td>
					<form method="POST" action="form.php">
						<input type="hidden" name="row" value="'.$row.'"/>
						<input type="hidden" name="value" value="'.$value.'"/>
						<input type="hidden" name="action" value="del"/>
						<input type="submit" value="Изтрий" />
					</form>
				</td>
			</tr>'."\n";
		}
	}
}
?>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>Сума:</td>
				<td><?= number_format($sum, 2); ?></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		</table>
		<form method="POST" action="form.php">
			<!-- <input type="hidden" name="action" value="add"/> -->
			<input type="submit" value="Добави нов разход" />
		</form>
<?php
include_once 'includes/footer.php';
