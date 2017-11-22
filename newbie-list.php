<?php
echo '<ul>';
foreach($pagedData AS $item) {
echo '<li><a href="https://goldvoice.club/@'.$item['author'].'" target="_blank">'.$item['author'].'</a></li>';
}
echo '</ull>';
if((40 > $currentPage && ($currentPage - 1) < $numPages) && ($currentPage > 0)) {
    echo '<ul><li><a href="?page=' . ($currentPage - 1) . '">« Предыдущая страница</a></li></ul>';
}
if(40 > $currentPage && ($currentPage + 1) < $numPages) {
    echo '<ul><li><a href="?page=' . ($currentPage + 1) . '" class="right">Следующая страница »</a></li></ul>';
}
?>
