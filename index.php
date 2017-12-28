<!DOCTYPE html>
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title>В помощь новичкам</title>
	<meta name="keywords" content="Голос, Клиент, помощь, новички">
	<meta name="description" content="Новый клиент для Блокчейна Голос, созданный в помощь новичкам.">
 <meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/style.min.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="https://newbie.goloses.ru/favicon.ico">
<link rel="stylesheet" href="css/stacktable.css">
	</head>

<body>

<div class="wrapper">

	<header class="header">
<h1>В помощь новичкам</h1>
<p>Данный сайт создан, чтобы сторожилы узнали о новичках, об их постах, могли поставить апвоут, поддержав их.</p>
<p>Ниже находятся вкладки: посты новичков, используя которую вы можете просматривать записи новичков Голоса, а также "Список новичков" со списком имён пользователей + ссылки на них. Для голосования используется ссылка на goldvoice.</p>
	</header>

	<main class="content">
<div id="tab_block">
   <ul id="tabs">
     <li id="tab1" class="tab active" onclick="funcTab(1);">Записи новичков</li>
     <li id="tab2" class="tab" onclick="funcTab(2);">Список новичков</li>
   </ul>
   <div id="tabs_content">
     <div class="tab_content active" id="tab_content1">
     <?php require 'newbie-posts.php'; ?>
     </div>
     <div class="tab_content" id="tab_content2">
<h2>Список новичков Голоса</h2>
     <?php require 'newbie-list.php'; ?>
	 </div>
   </div>
</div>

<script type="text/javascript">
var numberOfTab = localStorage.getItem('number');
if (numberOfTab) {
funcTab(numberOfTab);
} else {
localStorage.setItem('number', 1);
};

function funcTab(n) {
var NTab = document.getElementsByClassName('tab').length;
for (var i=1; i < NTab+1; i++) {
if (i != n){
document.getElementById('tab'+i).className = 'tab';
document.getElementById('tab_content'+i).className = 'tab_content'
}
}
document.getElementById('tab'+n).className = 'tab active';
document.getElementById('tab_content'+n).className = 'tab_content active';
localStorage.setItem('number', n);
}
</script>
	</main>
<footer class="footer">
    <p class="footer_text">newbie.goloses.ru - это клиент в помощь новичкам, созданный на основе библиотеки <a href="https://golos.io/@golosapi2" target="_blank">PHPGolosAPI 2.0</a> (Благодарность автору этого решения).</p>
    <p class="footer_text">Создал данный клиент незрячий новичок в программировании <a href="https://goldvoice.club/@denis-skripnik" target="_blank">Денис Скрипник</a>. <a href="https://github.com/denis-skripnik/newbie-goloses-ru" target="_blank">Ссылка на github рипозеторий</a></p>
    <p class="footer_text">Благодарность за помощь в создании навигации постраничной и исправлении ошибки при нахождении на главной <a href="https://golos.io/@tristamoff" target="_blank">@tristamoff</a>.</p>
  </footer>

</div>


<script type="text/javascript" src="js/libs/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/stacktable.js"></script>
<script>
jQuery(document).ready(function($) {
  jQuery(function($){
    $('table').stacktable();
  });
});
</script>
</body></html>