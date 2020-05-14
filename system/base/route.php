<?php

class Route
{
  static $path;
  static $fields;
	static function start()
	{ 
    global $CONF;
		// контроллер и действие по умолчанию
    
    $controller_name = 'default';
    
    $action_name = 'index';
   
		
    $aUrl=parse_url(trim($_SERVER['REQUEST_URI'],'/\\'));
    $path = explode('/', $aUrl['path']);
    
    //array_shift($path); // удаляем первый элемент - год
    for($i=0;$i<conf::$SITE_SUBDIR_INDEX;$i++){
      array_shift($path); // удаляем кол-вол вложенных директорий
    }
    
    self::$path=$path;
    
    if(!isset($path[0]) || !$path[0]){
        $modul = 'default';
    }else{
        $modul = $path[0];
    }
    if(sys::is_autorised()){
        
        if($_SESSION["diary"]["user_status"] === "administrator"){
            if($modul =='default'){
                $modul ='admin_cab';
            }
        }
        if($_SESSION["diary"]["user_status"] === "teacher"){
            if($modul =='default'){
                $modul ='teacher_cab';
            }
        }
        if($_SESSION["diary"]["user_status"] === "student"){
            if($modul =='default'){
                $modul ='student_cab';
            }
        }     
      require_once conf::$ROOT.'system/etc/functions.php';
      
      if($modul=='ajax'){
        $controller_file = 'ajax_controller.php';
        if(file_exists("system/controllers/".$controller_file)){
          include "system/controllers/".$controller_file;
          $controller_name='ajax_controller';
          if (class_exists($controller_name)){
            $controller = new $controller_name;
            $action = $path[1];
                if (method_exists($controller, $action))
                {
                  // вызываем действие контроллера
                  $param='';
                  if (isset($param))
                            $controller->$action($param);
                        else
                            $controller->$action();
                }
                else
                {
  //          			throw new Exception('action_not_found');
                }
          }else{
            throw New Exception('Controller_class_not_found');
          }
        }
      }else{
        $fields=array();
        $fields['filename']=$modul.'_controller';

        self::$fields=$fields;

  //      if(isset($fields['filename'])){
          $controller_file = $fields['filename'].'.php';
          if(file_exists("system/controllers/".$controller_file)){
            include "system/controllers/".$controller_file;
            $controller_name=$fields['filename'];//$url;//'simple_page_tpl';
            if (class_exists($controller_name)){
              $controller = new $controller_name;
              
              $action = 'index';
              if(isset($path[1])){
                $action = $path[1].'';
              }
                  if (method_exists($controller, $action))
                  {
                    // вызываем действие контроллера
                    $param='';
                    if (isset($param))
                        $controller->$action($param);
                    else
                        $controller->$action();
                  }
                  else
                  {
                        $action = 'index';
    			$param='';
                    if (isset($param))
                        $controller->$action($param);
                    else
                        $controller->$action();
                  }
            }else{
              throw New Exception('Controller_class_not_found');
            }
          }else{
            
            if($_SESSION["diary"]["user_status"] === "administrator"){
                $controller_name ='admin_cab';
            }
            if($_SESSION["diary"]["user_status"] === "teacher"){
                    $controller_name ='teacher_cab';
            }
            if($_SESSION["diary"]["user_status"] === "student"){
                    $controller_name ='student_cab';
            }     
            $controller_name .= '_controller';
            $controller_file = $controller_name.'.php';
            include "system/controllers/".$controller_file;
            echo $controller_name;
            $controller = new $controller_name;
              
              $action = 'index';
              $controller->$action();
          }
      }
    }else{
      $fields=array();

      $fields['filename']='login_controller';

      self::$fields=$fields;

//      if(isset($fields['filename'])){
        $controller_file = $fields['filename'].'.php';
        if(file_exists("system/controllers/".$controller_file)){
          include "system/controllers/".$controller_file;
          $controller_name=$fields['filename'];//$url;//'simple_page_tpl';
          if (class_exists($controller_name)){
            $controller = new $controller_name;
  //          $action = $path[1];
            $action = 'index';
            if(isset($path[1])){
                $action = $path[1].'';
              }
                if (method_exists($controller, $action))
                {
                  // вызываем действие контроллера
                  $param='';
                  if (isset($param))
                      $controller->$action($param);
                  else
                      $controller->$action();
                }
                else
                {
  //          			throw new Exception('action_not_found');
                }
          }else{
            throw New Exception('Controller_class_not_found');
          }
        }
        else{
          throw New Exception('Controller_not_found');
        }
    }
		
	
	}
    
}
?>