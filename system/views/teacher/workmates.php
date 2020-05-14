<div class="classmate_header">
    <h3>Учителя</h3>
</div>
<div class="classmates">
    <table class=" table table-bordered" style="width:512">
        <thead>
            <tr>   
                <th class="text-center">ФИО</th>
                <th class="text-center">Телефон</th>
                <th class="text-center">Классный педагог</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($data as $row){
            $checked="";
            if($row["has_class_manager"] == 1){
                $checked="checked";
            }
            echo '<tr>
                <td class="text-center">'.$row["first_name"].' '.$row["last_name"].' '.$row["otc"].'</td>
                <td class="text-center">'.$row["phone_number"].'</td>
                <td class="text-center"><input type="checkbox" name="checkbox" '.$checked.' disabled></td>
                </tr>';
        }
        ?>
        </tbody>
    </table>
</div>