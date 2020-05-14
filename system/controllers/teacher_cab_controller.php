<?php
class teacher_cab_controller extends Controller{
  function __construct(){ 
            include "system/models/teacher_cab_model.php";
            $this->model = new teacher_cab_model();
            $this->view = new View();
	}
	
	function index(){    
            $data = $this->model->get_data();
            $this->view->render('profile.php', 'teacher/teacher_cab_view.php', $data);
	}
        function news(){
            $data = $this->model->news();
            $this->view->render('news.php', 'teacher/teacher_cab_view.php', $data);
        }
        function workmates(){
            $data = $this->model->workmates();
            $this->view->render('workmates.php', 'teacher/teacher_cab_view.php', $data);
        }
        function journal(){
            $data = $this->model->journal();
            $this->view->render('journal.php', 'teacher/teacher_cab_view.php', $data);
        }
        function homework(){
            $data = $this->model->homework();
            $this->view->render('homework.php', 'teacher/teacher_cab_view.php', $data);
        }
        function students(){
            $data = $this->model->students();
            $this->view->render('students.php', 'teacher/teacher_cab_view.php', $data);
        }
        function education(){
            $data = $this->model->education();
            $this->view->render('education.php', 'teacher/teacher_cab_view.php', $data);
        }
        function save_mark(){
            $data = $this->model->save_mark();
            $this->view->render('', 'ajax_view.php', $data);
        }
        function save_hw(){
            $data = $this->model->save_hw();
            $this->view->render('', 'ajax_view.php', $data);
        }
}
?>