<?php
sys::inc_no_cache('javascript', 'js/student/journal.js');
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
    <h3>Журнал</h3>
</div>
<br/>
<?php
$date = date("Y-m-d");
$semestr = mark_semest($date, $data);
?>
<div class="row">
    <div class="col-2">
        <select class="form-control" id="semestr">
            <?php for($i = 1; $i <= 4; $i++){
                $selected = "";
                if($i == $semestr){
                    $selected = "selected";
                }
                echo '<option value="'.$i.'" '.$selected.'>'.$i.' четверть</option>';
                if($selected != ""){
                    break;
                }
            }
        ?>
        </select>
    </div>
    <div class="col-2">
        <select class="form-control" id="disciplin">
        </select>
    </div>
</div>
<br/>
<div class="marks" id="marks">
        
</div>


