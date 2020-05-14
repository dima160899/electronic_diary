<div class="classmate_header">
    <h3>Одноклассники</h3>
</div>
<div class="classmates">
    <table class=" table table-bordered" style="width:512">
        <thead>
            <tr>
                <th class="text-center">ФИО</th>
                <th class="text-center">Телефон</th>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($data as $row){
            echo '<tr><td class="text-center">'.$row["last_name"].' '.$row["first_name"].' '.$row["otc"].'</td>
                  <td class="text-center">'.$row["phone_number"].'</td></tr>';
        }
        ?>
        </tbody>
    </table>
</div>