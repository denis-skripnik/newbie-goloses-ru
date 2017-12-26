<?php
header('Content-Type: text/html; charset=utf-8');
if ($_GET['page'] >=1) {
$url_page = "http://185.203.243.142/api/?method=getnewbies&count=30";
$url = $url_page."&offset=".$_GET['page']*30;
}
else {
$url = "http://185.203.243.142/api/?method=getnewbies&count=30&offset=0";
}
$curl = curl_init($url); // Инициализируем curl по указанному адресу
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // Записать http ответ в переменную, а не выводить в буфер
$page = curl_exec($curl);
$result = json_decode($page, true);
echo '<table><tr><th>Автор</th><th>Заголовок поста с ссылкой на этом сайте</th><th>Ссылка на golos.io</th><th>Ссылка на goldvoice</th><th>Голосов</th></tr>';
foreach($result AS $item) {
echo '<tr>
        <td><a href="https://goldvoice.club/@'.$item['author'].'" target="_blank">@'.$item['author'].'</a></td>
        <td><h2><a href="/post.php?permlink='.$item['permlink'].'&author='.$item['author'].'">'.$item['title'].'</a></h2></td>
                <td><a href="https://golos.io/'.$item['parent_permlink'].'/@'.$item['author'].'/'.$item['permlink'].'">Открыть на golos.io</a></td>        
		<td><a href="https://goldvoice.club/@'.$item['author'].'/'.$item['permlink'].'">Открыть на Goldvoice.club</a></td>        
		<td>'.$item['active_votes'].'</td>
    </tr>';
}
echo '</table>';
if((40 > $_GET['page'] && ($_GET['page'] - 1) < 40) && ($_GET['page'] > 0)) {
    echo '<ul><li><a href="?page=' . ($_GET['page'] - 1) . '">« Предыдущая страница</a></li></ul>';
}
if(40 > $_GET['page'] && ($_GET['page'] + 1) < 40) {
    echo '<ul><li><a href="?page=' . ($_GET['page'] + 1) . '" class="right">Следующая страница »</a></li></ul>';
}
?>