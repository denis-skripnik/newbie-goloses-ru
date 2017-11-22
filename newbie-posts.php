<?php
header('Content-Type: text/html; charset=utf-8');
include 'golos/getnewbies.php';
$url = "http://185.203.243.142/api/?method=getnewbies&count=1200";
$curl = curl_init($url); // Инициализируем curl по указанному адресу
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
$page = curl_exec($curl);
$result = json_decode($page, true);
// Получаем текущую страницу
if (!empty($_REQUEST['page'])) {
    $currentPage = trim($_REQUEST['page']);
    $currentPage = (int) $currentPage;
} else {
    $currentPage = 0;
}
// Настройки разбиения на страницы   
$perPage = 30;
$numPages = ceil(1200 / $perPage);
if(!$currentPage || $currentPage > $numPages) {
    $currentPage = 0;
}
$start = $currentPage * $perPage;
$end = ($currentPage * $perPage) + $perPage;

// Нужные страницы
foreach ($result as $key => $value) {
    if($key >= $start && $key < $end) {
        $pagedData[] = $result[$key];
    }
}

echo '<table><tr><th>Автор</th><th>Заголовок поста</th><th>Голосов</th></tr>';
include 'golos/getvotes.php';
foreach($pagedData AS $item) {
    $voit_url = "http://185.203.243.142/api/?method=getvotes&permlink=";
    $voit_address = $voit_url.$item['permlink'].'&author='.$item['author'];
    $voit_curl = curl_init($voit_address); // Инициализируем curl по указанному адресу
    curl_setopt($voit_curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
    $voit_data = curl_exec($voit_curl);
    $voit_result = json_decode($voit_data);
    echo '<tr>
        <td><a href="https://goldvoice.club/@'.$item['author'].'" target="_blank">@'.$item['author'].'</a></td>
        <td><h2><a href="/post.php?permlink='.$item['permlink'].'&author='.$item['author'].'">'.$item['title'].'</a></h2></td>
        <td>'.count($voit_result).'</td>
    </tr>';
}
echo '</table>';
if((40 > $currentPage && ($currentPage - 1) < $numPages) && ($currentPage > 0)) {
    echo '<ul><li><a href="?page=' . ($currentPage - 1) . '">« Предыдущая страница</a></li></ul>';
}
if(40 > $currentPage && ($currentPage + 1) < $numPages) {
    echo '<ul><li><a href="?page=' . ($currentPage + 1) . '" class="right">Следующая страница »</a></li></ul>';
}
?>