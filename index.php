<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<!--[if lt IE 9]><script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script><![endif]-->
	<title>В помощь новичкам</title>
	<meta name="keywords" content="Голос, Клиент, помощь, новички" />
	<meta name="description" content="Новый клиент для Блокчейна Голос, созданный в помощь новичкам." />
	<link href="style.css" rel="stylesheet">
</head>

<body>

<div class="wrapper">

	<header class="header">
<h1>В помощь новичкам</h1>
<p>Данный сайт создан, чтобы сторожилы узнали о новичках, об их постах, могли поставить апвоут, поддержав их.</p>
<p>Ниже находятся вкладки: посты новичков, используя которую вы можете просматривать записи новичков Голоса, а также "Список новичков" со списком имён пользователей + ссылки на них. Для голосования используется ссылка на goldvoice.</p>
	</header><!-- .header-->

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
//функция funcTab(n) вызывается событием onclick на вкладке. N - номер вкладки, на которой кликнули
function funcTab(n) {
//получаем количество вкладок по классу. В нашем случае их - 4
   var NTab = document.getElementsByClassName('tab').length;
//запускаем цикл по количеству табов. Начинаем с 1, а не 0, чтобы удобнее было подставлять значение счетчика в айдишники
  for (var i=1; i < NTab+1; i++) {
//если значение счетчика цикла не равно номеру вкладки, на которую кликаем
    if (i != n){
//текущая вкладка может быть активна или не активна, поэтому для гарантии делаем текущую вкладку все равно не активной, пропуская вкладку, на которой кликнули
     document.getElementById('tab'+i).className = 'tab';
//тоже самое делаем для блоков с контентом
     document.getElementById('tab_content'+i).className = 'tab_content'
     }
  }
//теперь делаем таб, на котором кликнули, активным, меняя у него класс
   document.getElementById('tab'+n).className = 'tab active';
//тоже самое для блока с контентом
   document.getElementById('tab_content'+n).className = 'tab_content active';
}
</script>
	</main><!-- .content -->

</div><!-- .wrapper -->

<footer class="footer">
<p>newbie.goloses.ru - это клиент в помощь новичкам, созданный на основе библиотеки <a href="https://golos.io/@golosapi2" target="_blank">PHPGolosAPI 2.0</a> (Благодарность автору этого решения).</p>
<p>Создал данный клиент незрячий новичок в программировании <a href="https://goldvoice.club/@denis-skripnik" target="_blank">Денис Скрипник</a>. <a href="http://newbie.goloses.ru/newbie.goloses.ru.zip" target="_blank">Скачать архив с файлами скрипта</a></p>
<p>Благодарность за помощь в создании навигации постраничной и исправлении ошибки при нахождении на главной <a href="https://golos.io/@tristamoff" target="_blank">@tristamoff</a>.</p>
</footer><!-- .footer -->

</body>
</html>