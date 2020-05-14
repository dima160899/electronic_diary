<?php
$teacher = $data["content"];
?>
<div class="header_profile">
    <h3>Мой профиль</h3>
</div>
<br/>
<div class="profil">
    <div class="row">
        <div class="col-6">
            <div><h5>Личная информация</h5></div><br/>
            <div class="row">
                <div class="col-4">
                    <p>Фамилия</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $teacher["last_name"] ?>"" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Имя</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $teacher["first_name"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Отчество</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $teacher["otc"] ?>"" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Телефон</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $teacher["phone_number"] ?>"" disabled/>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div><h5>Изменения в расписании</h5></div><br/>
        </div>
    </div>
</div>