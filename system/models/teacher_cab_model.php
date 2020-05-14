<?php
class teacher_cab_model extends model 
{
    public function get_data() 
    {
      $data = array();
      $data['title'] = conf::$SITE_NAME;
      $data['content'] = self::content();
      return $data;
    }
    function content(){
        $teacher_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM TEACHERS WHERE TEACHER_ID=:teacher_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("teacher_id" => $teacher_id));
        $teacher = $q->fetchAll()[0];
        return $teacher;
    }
    function news(){
        
    }
    function workmates(){
        $stud_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM TEACHERS";
        $q = sys::$PDO->prepare($sql);
        $q->execute();
        $result = $q->fetchAll();
        return $result;
    }
    function journal(){
        $result="";
        $teacher_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM CLASSES c left join CLASS_TO_TEACH t on c.CLASS_ID = t.CLASS_ID WHERE t.TEACHER_ID = :teacher_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("teacher_id" => $teacher_id));
        $classes = $q->fetchAll();
        foreach($classes as $class){
            $result .= '<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#class'.$class["class_name"].'" aria-expanded="false" aria-controls="collapseExample">
                        '.$class["class_name"].'
                      </button>
                    <div class="collapse" id="class'.$class["class_name"].'"><br/><div hidden><input id="disc" value="'.$class["disc_id"].'"/></div><div class="row">
                    <div class="col-3"><select class="form-control" id="students"><option value="0">Выберете ученика</option>';
                $sql = "SELECT * FROM STUDENTS s WHERE CLASS_ID = :class_id";
                $q = sys::$PDO->prepare($sql);
                $q->execute(array("class_id" => $class["class_id"]));
                $students = $q->fetchAll();
                foreach($students as $student){
                    $result .= '<option value="'.$student["stud_id"].'">'.$student["last_name"].' '.$student["first_name"].' '.$student["otc"].'</option>';
                }
                $result .= '</select></div><div class="col-2"><button type="button" class="btn btn-sm btn-primary send" id="s'.$class["class_name"].'">Поставить оценку</button></div></div>
                        <div class="row"><div class="col-3"><div>Выберите оценку</div><select class="form-control" id="mark" disabled><option>2</option><option>3</option><option>4</option><option>5</option></select></div><div class="col-3"><div>Дата оценки:</div><input type="date" id="date" max="'.date("Y-m-d").'" class="form-control" disabled></div></div></div>';
        }
        
        return $result;
       
    }
    function homework(){
        $result="";
        $teacher_id = $_SESSION["diary"]["user_id"];
        $sql = "SELECT * FROM CLASSES c left join CLASS_TO_TEACH t on c.CLASS_ID = t.CLASS_ID WHERE t.TEACHER_ID = :teacher_id";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("teacher_id" => $teacher_id));
        $classes = $q->fetchAll();
        foreach($classes as $class){
            $result .= '<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#class'.$class["class_name"].'" aria-expanded="false" aria-controls="collapseExample">
                        '.$class["class_name"].'
                      </button>
                    <div class="collapse" id="class'.$class["class_name"].'">';
                $result .= '
                        <br/><div hidden><input id="disc" value="'.$class["disc_id"].'"/></div><div hidden><input id="class_id" value="'.$class["class_id"].'"/></div><div class="row"><div class="col-3"><textarea class="form-control" id="hw">Введите домашнее задание</textarea></div><div class="col-3"><div>Дата сдачи задания:</div><input type="date" id="date" class="form-control"></div><div class="col-2"><button type="button" class="btn btn btn-primary send" id="s'.$class["class_name"].'">Дать домашнее задание</button></div></div></div>';
        }
        
        return $result;
    }
    function students(){
       
    }
    function education(){
       
    }
    function save_hw(){
        $sql = "INSERT INTO HOME_WORK (disc_id, class_id, task, date_finish) VALUES (:disc_id, :class_id, :task, :date_finish)";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("disc_id" => $_REQUEST["disc_id"], "class_id" => $_REQUEST["class_id"], "task" => $_REQUEST["hw"], "date_finish" => $_REQUEST["date"]));
    }
    function save_mark(){
        $date = "";
        if ($_REQUEST["date"] == ''){
            $date = "default";
        }else{
            $date = "'".$_REQUEST["date"]."'";
        }
        $sql = "INSERT INTO USPEVAEMOST (stud_id, disc_id, mark, mark_date) VALUES (:stud_id, :disc_id, :mark, ".$date.")";
        $q = sys::$PDO->prepare($sql);
        $q->execute(array("stud_id" => $_REQUEST["stud_id"], "disc_id" => $_REQUEST["disc_id"], "mark" => $_REQUEST["mark"]));
        echo $sql;
        return $sql;
    }
}
