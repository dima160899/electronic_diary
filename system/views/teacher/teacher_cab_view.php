<?php
//require_once conf::$ROOT . 'system/etc/functions.php';
// получаем адрес страницы без учета параметров
if ($_SERVER['REQUEST_URI'] == '/') {
  $CURRENT_PAGE = 'teacher_cab';
  $CURRENT_PAGE_HARD = conf::$SITE_URL;
} else {
  $CURRENT_PAGE = basename($_SERVER['REQUEST_URI']); // получаем адрес
// способ 2
// парсим адрес 
  $arr = parse_url($CURRENT_PAGE);
  $CURRENT_PAGE_HARD = $CURRENT_PAGE; // сохраняем для жестких ссылок прописанных с учетом параметров в запросе
  $CURRENT_PAGE = $arr['path']; // получаем конечный адрес
  
}
?>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Кабинет учителя</title>

    <?php
    sys::inc_no_cache('css', 'css/tablesorter.css');
    sys::inc_no_cache('css', 'css/bootstrap.css');
    
    sys::inc_no_cache('javascript', 'js/libraries/jquery-3.4.1.js');
    sys::inc_no_cache('javascript', 'js/libraries/popper.min.js');
    sys::inc_no_cache('javascript', 'js/libraries/bootstrap.min.js');
    sys::inc_no_cache('javascript', 'js/libraries/jquery-ui.js');
    sys::inc_no_cache('javascript', 'js/admin/admin.js');
    
    sys::inc_no_cache('css', 'css/admin_cab.css');
    sys::inc_no_cache('css', 'css/icons-fontawesome.css');
    ?>

  </head>
  <body>
    <!--верхнее меню-->
    <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" >Учитель</a>

      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="<?php echo conf::$SITE_URL . 'logout' ?>">Выйти</a>
        </li>
      </ul>
    </nav>
    <!--конец верхнего меню-->
    
    <!--начало основного блока контента-->
    <div class="container-fluid">
      <div class="row">

        <!-------------левое меню--------------->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='teacher_cab'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/">
                    <i class="fas fa-user-edit"></i> Мой профиль
                  </a>
                </li>
<!--                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='news'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/news">
                    <i class="fas fa-list"></i> Новости
                  </a>
                </li>-->
                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='classmates'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/workmates">
                    <i class="fas fa-user-friends"></i> Cотрудники
                  </a>
                </li>
              </ul><br/>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='journal'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/journal">
                    <i class="fas fa-address-book"></i> Журнал
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='homework'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/homework">
                    <i class="fas fa-chalkboard-teacher"></i> Дз
                  </a>
                </li>       
              </ul><br/>
<!--              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link <?=($CURRENT_PAGE=='education'?'active':'')?>" href="<?=conf::$SITE_URL?>teacher_cab/education">
                    <i class="fas fa-book-reader"></i> Образование
                  </a>
                </li>      
              </ul>-->
          </div>
        </nav>
        <!-------------конец левого меню--------------->

        <!-------------Основной контент--------------->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!--вставить содержимое сюда-->
            <?php
            if ($content_view <> '') {
               include 'system/views/teacher/' . $content_view;
            }
            ?>
            <!--конец блока содержимого-->
        </main>
      </div>
    </div>
  </body>
</html>