<?php
echo '<ul>';
foreach($result AS $item) {
echo '<li><a href="https://goldvoice.club/@'.$item['author'].'" target="_blank">'.$item['author'].'</a></li>';
}
echo '</ull>';
if((40 > $_GET['page'] && ($_GET['page'] - 1) < 40) && ($_GET['page'] > 0)) {
    echo '<ul><li><a href="?page=' . ($_GET['page'] - 1) . '">« Предыдущая страница</a></li></ul>';
}
if(40 > $_GET['page'] && ($_GET['page'] + 1) < 40) {
    echo '<ul><li><a href="?page=' . ($_GET['page'] + 1) . '" class="right">Следующая страница »</a></li></ul>';
}
?>
