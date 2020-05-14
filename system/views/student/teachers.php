<div class="classmate_header">
    <h3>Одноклассники</h3>
</div>
<div class="classmates">
    <table class=" table table-bordered" style="width:512">
        <thead>
            <tr>   
                <th class="text-center">ФИО</th>
                <th class="text-center">Телефон</th>
                <th class="text-center">Предмет</th>
                <th class="text-center">Экзамен</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($data as $row){
            $checked="";
            if($row["teacher_disc"]["has_exam"] == 1){
                $checked="checked";
            }
            echo '<tr>
                <td class="text-center">'.$row["teacher_info"]["first_name"].' '.$row["teacher_info"]["last_name"].' '.$row["teacher_info"]["otc"].'</td>
                <td class="text-center">'.$row["teacher_info"]["phone_number"].'</td>
                <td class="text-center">'.$row["teacher_disc"]["disc_name"].'</td>
                <td class="text-center"><input type="checkbox" name="checkbox" '.$checked.' disabled></td>
                </tr>';
        }
        ?>
        </tbody>
    </table>
</div>