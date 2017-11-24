<?php
include 'golos/getpost.php';
	$url1 = "http://185.203.243.142/api/?method=getpost&permlink=";
	$url = $url1.$_GET['permlink']."&author=".$_GET['author'];
    $curl = curl_init($url); // Инициализируем curl по указанному адресу
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
    $page = curl_exec($curl);
$result = json_decode($page, true);

spl_autoload_register(function($class){
	require 'Michelf/'.preg_replace('{\\\\|_(?!.*\\\\)}', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

// Get Markdown class
use \Michelf\Markdown;
include 'golos/getvotes.php';
foreach ($result as $key => $value) {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title><?php echo $value['title']; ?></title>
	<meta name="keywords" content="Голос, Клиент, помощь, новички" />
	<meta name="description" content="Новый клиент для Блокчейна Голос, созданный в помощь новичкам." />
	<link href="style.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="/favicon.ico"/>
	</head>

<body>

<div class="wrapper">

	<header class="header">
<h1>В помощь новичкам</h1>
<p>Данный сайт создан, чтобы сторожилы узнали о новичках, об их постах, могли поставить апвоут, поддержав их.</p>
<p>Ниже находятся вкладки: посты новичков, используя которую вы можете просматривать записи новичков Голоса, а также "Список новичков" со списком имён пользователей + ссылки на них. Для голосования используется ссылка на goldvoice.</p>
	</header><!-- .header-->

	<main class="content">
<?php
$my_html = Markdown::defaultTransform($value['body']);
	$voit_url = "http://185.203.243.142/api/?method=getvotes&permlink=";
$voit_address = $voit_url.$value['permlink'].'&author='.$value['author'];
    $voit_curl = curl_init($voit_address); // Инициализируем curl по указанному адресу
    curl_setopt($voit_curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
    $voit_data = curl_exec($voit_curl);
$voit_result = json_decode($voit_data);
	echo '<h1>'.$value['title'].'</h1>
<p align="center">Автор: <a href="https://goldvoice.club/@'.$value['author'].'" target="_blank">'.$value['author'].'</a><br />
Дата: <span>'.$value['created']['date'].'</span><br />
Голосов: '.count($voit_result).'</p>
<div id="content">'.$my_html.'</div>
<p align="center"><a href="https://goldvoice.club/@'.$value['author'].'/'.$value['permlink'].'" target="_blank">Проголосовать за пост на Goldvoice</a></p>';
}
?>
	</main><!-- .content -->

</div><!-- .wrapper -->

<footer class="footer">
<p>newbie.goloses.ru - это клиент в помощь новичкам, созданный на основе библиотеки <a href="https://golos.io/@golosapi2" target="_blank">PHPGolosAPI 2.0</a> (Благодарность автору этого решения).</p>
<p>Создал данный клиент незрячий новичок в программировании <a href="https://goldvoice.club/@denis-skripnik" target="_blank">Денис Скрипник</a>. <a href="https://github.com/denis-skripnik/newbie-goloses-ru" target="_blank">Ссылка на github рипозеторий</a></p>
<p>Благодарность за помощь в создании навигации постраничной и исправлении ошибки при нахождении на главной <a href="https://golos.io/@tristamoff" target="_blank">@tristamoff</a>.</p>
</footer><!-- .footer -->

</body>
</html>