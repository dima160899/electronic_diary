<?php

class admin_cab_model extends model {

    public function get_data() {
        $data = array();
        $data['title'] = conf::$SITE_NAME;
        $data['content'] = self::content();
        return $data;
    }

    function content() {
        
    }

    function settings() {
        $sql = "SELECT * FROM public.users 
        LEFT JOIN public.user_group ON public.users.group_user_id = public.user_group.group_id
        WHERE login = '" . sys::user_login() . "'";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q = $q->fetchAll();
        return array("user_data" => $Q[0]);
    }

    public function change_users() {
        $sql = "SELECT u.id, u.login, u.password, u.group_id, t.last_name, t.first_name, t.otc,  g.descr
                FROM USERS u left join 
                TEACHERS t on u.profile_id = t.teacher_id left join 
                USER_GROUP g on g.id = u.group_id
                WHERE u.group_id = 1 ORDER BY u.id";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q = $q->fetchAll();
        $sql = "SELECT u.id, u.login, u.password, u.group_id, s.last_name, s.first_name, s.otc,  g.descr
                FROM USERS u left join 
                STUDENTS s on u.profile_id = s.stud_id left join 
                USER_GROUP g on g.id = u.group_id
                WHERE u.group_id = 2 ORDER BY u.id";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $users = array_merge_recursive($Q, $q->fetchAll());
        $sql = "SELECT * FROM USER_GROUP WHERE id <> 99";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q1 = $q->fetchAll();
        return array("users" => $users, "group_users" => $Q1, "page" => "users", "page_name" => "Пользователи");
    }
    
    function change_groups_users(){
        $sql = "SELECT * FROM USER_GROUP WHERE group_id <> 99 ORDER BY group_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q = $q->fetchAll();
        return $Q;
    }
  

    function get_group_user_info_by_id(){
        if($_POST["id"] != 99){
            $sql = "
                  SELECT user_group_name, user_status, descr
                  FROM user_group
                  WHERE group_id = :id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("id"=>$_POST["id"]));
            $Q = $q->fetchAll();
            return $Q[0];
        }
    }
    function save_groups_users_edit() {
        $sql="UPDATE user_group set user_group_name = :user_group_name, user_status = :user_status, descr = :descr
              WHERE group_id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("user_group_name" => $_POST["user_group_name"], "user_status" => $_POST["user_status"], "descr" => $_POST["descr"], "id" => $_POST["id"]));
        return array("response"=>200);
    }
    function add_group_user(){
        $sql = "INSERT INTO user_group (group_id, user_group_name, user_status, descr)
                VALUES(((SELECT group_id FROM user_group WHERE group_id <> 99 ORDER BY group_id DESC
                        limit 1) + 1), :user_group_name, :user_status, :descr);
               ";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("user_group_name" => $_POST["user_group_name"], "user_status" => $_POST["user_status"],  "descr" => $_POST["descr"]));
        $sql = "SELECT group_id FROM user_group WHERE group_id <> 99 ORDER BY group_id DESC
               limit 1";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q = $q->fetchAll();
        return array("id" => $Q[0][0]);
        
    }
    function delete_group_user(){
        if($_REQUEST["group_id"] == 1){
            $sql = "DELETE FROM TEACHERS WHERE teacher_id=:id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("id" => $_POST["id"]));
        }else{
            $sql = "DELETE FROM STUDENTS WHERE id=:id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("id" => $_POST["id"]));
        }
        $sql = "DELETE FROM USERS WHERE id=:id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id" => $_POST["id"]));
        return array("response" => 200);
    }
    function get_user_info_by_id(){
        $Q;
        if($_POST["user_group"] == 1){
        $sql = "
            SELECT t.first_name, t.last_name, t.otc, u.login, u.password
            FROM USERS u left join  
            TEACHERS t on u.profile_id = t.teacher_id
            WHERE u.id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id"=>$_POST["id"]));
        $Q = $q->fetchAll();
        }else{
        $sql = "
            SELECT s.first_name, s.last_name, s.otc, u.login, u.password
                FROM USERS u left join
                STUDENTS s on u.profile_id = s.stud_id
                WHERE u.id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id"=>$_POST["id"]));
        $Q = $q->fetchAll();
        
        }
        return $Q[0];
    }
    
    function save_users_edit() {
        if($_POST["user_group"] == 1){
            $sql="UPDATE teachers set last_name = :last_name, 
                first_name = :first_name, otc = :otc
                WHERE teacher_id = (SELECT profile_id FROM USERS WHERE ID = :id) ";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("last_name" => $_POST["last_name"], 
                "first_name" => $_POST["first_name"], "otc" => $_POST["otc"], "id" => $_POST["id"]));
            $sql="UPDATE users set u.login = :login, u.password = :password
                WHERE u.id = :id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("login" => $_POST["login"], 
                "password" => $_POST["password"], "id" => $_POST["id"]));
        }
        else{
            $sql="UPDATE students set last_name = :last_name, 
                first_name = :first_name, otc = :otc
                WHERE stud_id = (SELECT profile_id FROM USERS WHERE ID = :id) ";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("last_name" => $_POST["last_name"], 
                "first_name" => $_POST["first_name"], "otc" => $_POST["otc"], "id" => $_POST["id"]));
            $sql="UPDATE users set u.login = :login, u.password = :password
                WHERE u.id = :id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("login" => $_POST["login"], 
                "password" => $_POST["password"], "id" => $_POST["id"]));
        }
//        $sql="UPDATE users set last_name = :last_name, first_name = :first_name, otc = :otc, login = :login, password = :password
//              WHERE id = :id";
//        $q = sys::$PDO->prepare($sql);
//        $q->execute(array("last_name" => $_POST["last_name"], "first_name" => $_POST["first_name"], "otc" => $_POST["otc"], "login" => $_POST["login"], "password" => $_POST["password"], "id" => $_POST["id"]));
        return array("response"=>200);
    }
    function change_user_active_sign(){
        $sql="UPDATE users set active_sign = not active_sign
              WHERE id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id" => $_POST["id"]));
        return array("response"=>200);
    }
    function change_user_role(){
        $sql="UPDATE users set group_id = :group_id
              WHERE id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("group_id" => $_POST["group_id"],"id" => $_POST["id"]));
        return array("response"=>200);
    }
    function add_user(){
        if($_POST["user_group"] == 1){
        $sql = "
            INSERT INTO TEACHERS (first_name, last_name, otc)
            FROM USERS u left join  
            TEACHERS t on u.profile_id = t.teacher_id
            WHERE u.id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id"=>$_POST["id"]));
        }else{
        $sql = "
            SELECT s.first_name, s.last_name, s.otc, u.login, u.password
                FROM USERS u left join
                STUDENTS s on u.profile_id = s.stud_id
                WHERE u.id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id"=>$_POST["id"]));
        $Q = $q->fetchAll();
        
        }
        $sql = "SELECT id from users where login=:login;
               ";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("login" => $_POST["login"]));
        $Q = $q->fetchAll();
        return array("id" => $Q[0][0]);
        
    }
    function get_users_groups(){
         $sql = "SELECT * FROM USERS WHERE group_user_id <> 99 ORDER BY id";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q = $q->fetchAll();
        $sql = "SELECT * FROM USER_GROUP WHERE group_id <> 99";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $Q1 = $q->fetchAll();
        $data = array("users" => $Q, "group_users" => $Q1);
        $result = '<select class="form-control form-control-sm role" id = "role">';
        foreach ($data["group_users"] as $row) {
          $result .="<option value=" . $row["group_id"] . " ";
          if ($_GET['group_user_id'] == $row["group_id"]) {
            $result .= "selected";
          } $result .= ">" . $row["descr"] . "</option>";
        }
        $result .= "</select>";
        return $result;
    }
    function delete_user(){
        if($_REQUEST["group_id"] == 1){
            $sql = "DELETE FROM TEACHERS WHERE teacher_id=(SELECT profile_id FROM USERS WHERE ID=:id)";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("id" => $_POST["id"]));
        }else{
            $sql = "DELETE FROM STUDENTS WHERE stud_id=(SELECT profile_id FROM USERS WHERE ID=:id)";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("id" => $_POST["id"]));
        }
        $sql = "DELETE FROM USERS WHERE id=:id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id" => $_POST["id"]));
        return array("response" => 200);
    }
}
