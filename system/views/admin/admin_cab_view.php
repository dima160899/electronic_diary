<?php
//require_once conf::$ROOT . 'system/etc/functions.php';
// получаем адрес страницы без учета параметров
if ($_SERVER['REQUEST_URI'] == '/') {
  $CURRENT_PAGE = 'admin';
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
    <title>Кабинет администратора</title>

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
      <a class="navbar-brand col-sm-3 col-md-2 mr-0" >Администратор</a>

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
                  <a class="nav-link <?=($CURRENT_PAGE=='change_users'?'active':'')?>" href="<?=conf::$SITE_URL?>admin_cab/change_users">
                    <i class="fas fa-user-edit"></i> Пользователи
                  </a>
                </li>
              </ul>
          </div>
        </nav>
        <!-------------конец левого меню--------------->

        <!-------------Основной контент--------------->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <!--вставить содержимое сюда-->
            <?php
            if ($content_view <> '') {
              include 'system/views/admin/' . $content_view;
            } else {

            }
            ?>
            <!--конец блока содержимого-->
        </main>
      </div>
    </div>
  </body>
</html>