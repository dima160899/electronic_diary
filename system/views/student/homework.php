<?php
sys::inc_no_cache('javascript', 'js/student/homework.js');
function mark_semest($date, $data){
    $result = 0;
    foreach($data as $row){
    if($date <= $row["finish_date"]){
        $result = $row["id"];
        break;
    }
    }
    return $result;
}
?>
<div class="journal_header">
    <h3>Домашнее Задание</h3>
</div>
<br/>
<?php
$date = date("Y-m-d");
$semestr = mark_semest($date, $data);
?>
<div class="row">
    <div class="col-2">
        <select class="form-control" id="disciplin">
        </select>
    </div>
</div>
<br/>
<div class="hw" id="hw">
        
</div>


