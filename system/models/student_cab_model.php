<?php
class student_cab_model extends model
{
    public function get_data() 
    {
      $data = array();
      $data['title'] = conf::$SITE_NAME;
      $data['content'] = self::content();
      return $data;
    }
    function content(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM STUDENTS WHERE STUD_ID=:stud_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id));
        $student = $q->fetchAll()[0];
        $sql = "SELECT * FROM PARENTS p left join FAMILY_TAB f on p.parents_id = f.parents_id
                WHERE STUD_ID=:stud_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id));
        $parents = $q->fetchAll();
        return array("student" => $student, "parents" => $parents);
    }
    function news(){
        
    }
    function classmates(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT CLASS_ID FROM STUDENTS WHERE STUD_ID = :stud_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id));
        $class_id = $q->fetchAll()[0][0];
        $sql = "SELECT * FROM STUDENTS WHERE CLASS_ID = :class_id AND STUD_ID <> :stud_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("class_id" => $class_id, "stud_id" => $stud_id));
        $result = $q->fetchAll();
        return $result;
    }
    function journal(){
        $sql = "SELECT * FROM SEMESTR";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $return = $q->fetchAll();
        return $return;
    }
    function homework(){
       
    }
    function teachers(){
        $result = array(); 
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT CLASS_ID FROM STUDENTS WHERE STUD_ID = :stud_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id));
        $class_id = $q->fetchAll()[0][0];
        $sql = "SELECT * FROM CLASS_TO_TEACH WHERE CLASS_ID = :class_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("class_id" => $class_id));
        $teachers = $q->fetchAll();
        foreach($teachers as $teacher){
            $sql = "SELECT * FROM TEACHERS WHERE TEACHER_ID = :teacher_id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("teacher_id" => $teacher["teacher_id"]));
            $teacher_info = $q->fetchAll();
            $sql = "SELECT * FROM DISCIPLINS WHERE DISC_ID = :disc_id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("disc_id" => $teacher["disc_id"]));
            $teacher_disc = $q->fetchAll();
            array_push($result, array("teacher_info" =>$teacher_info[0],"teacher_disc" =>$teacher_disc[0]));
        }
        return $result;
    }
    function education(){
       
    }
    function get_disc(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $return = "";
        $sql = "SELECT DISC_ID FROM CLASS_TO_TEACH WHERE CLASS_ID = (SELECT CLASS_ID FROM STUDENTS WHERE STUD_ID = :stud_id)";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id));
        $disciplins = $q->fetchAll();
        foreach($disciplins as $disc){
            $sql = "SELECT * FROM DISCIPLINS WHERE DISC_ID = :disc_id";
            $q = sys::$PDO->prepare($sql);
            $q->execute(array("disc_id" => $disc[0]));
            $Q = $q->fetchAll();
            $return .= '<option value="'.$disc[0].'">'.$Q[0]["disc_name"].'</option>';
        }
        return $return;
    }
    function get_mark(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM SEMESTR WHERE id = :id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("id" => $_REQUEST["semestr"]));
        $dates = $q->fetchAll()[0];
        $sql = "SELECT * FROM USPEVAEMOST WHERE STUD_ID = :stud_id AND DISC_ID = :disc_id AND MARK_DATE >= :start_date AND MARK_DATE <= :finish_date";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $stud_id, "disc_id" => $_REQUEST["disciplin"], "start_date" => $dates["start_date"], "finish_date" => $dates["finish_date"]));
        $Q = $q->fetchAll();
        $return = '<table class="table table-bordered" style="width:auto"><thead><tr>';
        foreach($Q as $row){
        $return .= '<th>'.$row["mark_date"].'</th>';
        }
        $return .= "</thead><body><tr>";
        foreach($Q as $row){
        $return .= '<td>'.$row["mark"].'</td>';
        }
        $return .= "</body>";
        return $return;
    }
    function get_hw(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * 
                FROM HOME_WORK 
                WHERE DISC_ID = :disc_id AND CLASS_ID = (SELECT CLASS_ID FROM STUDENTS WHERE stud_id=:stud_id) AND ACTIVE_SIGN = '1'";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("disc_id" => $_REQUEST["disciplin"], "stud_id" => $stud_id));
        $active = $q->fetchAll();
        $sql = "SELECT * 
                FROM HOME_WORK 
                WHERE DISC_ID = :disc_id AND CLASS_ID = (SELECT CLASS_ID FROM STUDENT WHERE stud_id=:stud_id) AND ACTIVE_SIGN = '0'";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("disc_id" => $_REQUEST["disciplin"], "stud_id" => $stud_id));
        $archive = $q->fetchAll();
        $return = '<div class="row"><div class="col-6">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#active" aria-expanded="false" aria-controls="collapseExample">
                        Активные
                      </button>
                    
                    <div class="collapse" id="active"><br/>
                    ';
        if(!$active){
            $return .= 'Нет активных заданий';
        }else{
            $return .= '<table class="table table-bordered text-center" style="max-width:512px" style="max-width:512px"><thead><tr><th>Задание</th><th>Срок сдачи</th></thead><tbody>';
            foreach($active as $row){
            $return .= '<tr><td>'.$row["task"].'</td><td><input class="form-control" type="date" value="'.$row["date_finish"].'"disabled /></td></tr>';
            }
            $return .= '</tbody></table>';
        }
        $return .= '</div></div><div class="col-6">
                    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#finished" aria-expanded="false" aria-controls="collapseExample">
                        Завершенные
                      </button>
                    <div class="collapse" id="finished"><br/>
                    ';
         if(!$archive){
            $return .= 'Ни одно из заданий не было завершено';
        }else{
            $return .= '<table class="table table-bordered text-center" style="max-width:512px" style="max-width:512px"><thead><tr><th>Задание</th><th>Срок сдачи</th></thead><tbody>';
            foreach($archive as $row){
            $return .= '<tr><td>'.$row["task"].'</td><td>'.$row["date_finish"].'</td></tr>';
            }
            $return .= '</tbody></table>';
        }
        $return .= '</div></div></div>';
        return $return;
    }
}
