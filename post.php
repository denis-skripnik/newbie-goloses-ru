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
<html>
<meta charset="UTF-8">
<title><?php echo $value['title']; ?></title>
</head>
<body>
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
</body>
</html>