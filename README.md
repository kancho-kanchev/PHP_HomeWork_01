PHP_HomeWork_01
===============

PHP WEB разработка<br>
Домашна работа No: 1<br>
Крайна дата за предаване: 25.09.2013 00:00<br>
<br>
Описание<br>
Да се създаде система WEB базирана система за следене<br>
на разходи, която има следните минимални възможности:<br>
● Въвеждане на нов разход<br>
● Избиране на група(вид/категория) на разхода<br>
● Запазване на датата на разхода<br>
● Визуализиране на всички разходи, и показване на тяхната<br>
сума<br>
● Филтър за показване на разходи само от един вид<br>
<br>
Описание на страницата index<br>
В страницата index трябва да се визуализират всички въведени до момента разходи,<br>
препоръчително в табличен вид.<br>
Филтър за видове е препоръчително да бъде <select> с всички възможни видове<br>
плюс опцията “Всички”. Ако е избран определен вид ще трябва да се визуализират<br>
САМО разходите от избраният вид.<br>
Последният ред на таблицата трябва да съдържа сумата на всички визуализирани<br>
по-горе разходи.<br>
<br>
Описание на страницата "разход"<br>
В този екран трябва да се въвежда нов разход. Име, Сума и Вид са задължителни полета<br>
За валидно име се смята текст над 3 символа.<br>
За валидна сума се смята всяка сума по-голяма от 0.<br>
Датата на разхода се определя от датата на записа. PHP трябва да вземе текущата дата<br>
в момента на записа и да използва нея. Погледнете PHP функцията date()
<br>
Допълнителни задачи<br>
● Добавяне на опция за изтриване<br>
● Добавяне на опция за редакция<br>
● Добавяне на опция потребителя да избира дата на разхода,и<br>
валидацията на датата въведена от потребителя<br>
<br>
● Добавяне на опция за филтриране на разходите по дата, катото<br>
този филтър трябва да работи в комбинация с филтъра за ВИД<br>
<br>
Критерии за оценка<br>
● Валидност на HTML/CSS НЕ трябва да участват в оценката.Оценява се PHP<br>
кода, не външният вид или валидността на HTML/CSS<br>
● Външният вид не е задължително да е като посочения в презентацията. Може<br>
да бъде и на други езици!<br>
● Може да бъдат използвани произволни javascript/css библиотеки.<br>
● Изпълнението или неизпълнението на допълнителните задачи НЕ дават<br>
влияние на оценката. Те са дадени за хората желаещи да разширят задачата.<br>
● Правилно ли се записват данните в случай на специфични символи и подобни<br>
● Съществува ли валидация на входящите данни и съответните съобщения<br>
● Дали филтъра по видове работи<br>
● Дали общата сума след филтриране по вид е правилна<br>
● Има ли повторение на код между различните файлове<br>
<br>
Забранено е<br>
● Писане на код, който уврежда по какъвто и да е било начин<br>
чужди системи и компютри<br>
● Плагиатстването.<br>
● Манипулиране на домашните/резултатите по какъвто и да е<br>
било начин<br>
