<?php
class student_cab_controller extends Controller{
  function __construct(){ 
            include "system/models/student_cab_model.php";
            $this->model = new student_cab_model();
            $this->view = new View();
	}
	
	function index(){    
            $data = $this->model->get_data();
            $this->view->render('profile.php', 'student/student_cab_view.php', $data);
	}
        function news(){
            $data = $this->model->news();
            $this->view->render('news.php', 'student/student_cab_view.php', $data);
        }
        function classmates(){
            $data = $this->model->classmates();
            $this->view->render('classmates.php', 'student/student_cab_view.php', $data);
        }
        function journal(){
            $data = $this->model->journal();
            $this->view->render('journal.php', 'student/student_cab_view.php', $data);
        }
        function homework(){
            $data = $this->model->homework();
            $this->view->render('homework.php', 'student/student_cab_view.php', $data);
        }
        function teachers(){
            $data = $this->model->teachers();
            $this->view->render('teachers.php', 'student/student_cab_view.php', $data);
        }
        function education(){
            $data = $this->model->education();
            $this->view->render('education.php', 'student/student_cab_view.php', $data);
        }
        function get_disc(){
            $data = $this->model->get_disc();
            $this->view->render('', 'ajax_view.php', $data);
        }
        function get_mark(){
            $data = $this->model->get_mark();
            $this->view->render('', 'ajax_view.php', $data);
        }
        function get_hw(){
            $data = $this->model->get_hw();
            $this->view->render('', 'ajax_view.php', $data);
        }
        
}
?>