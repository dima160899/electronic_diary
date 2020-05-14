<?php
$student = $data["content"]["student"];
$parents = $data["content"]["parents"];
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
                    <input class="form-control form-control-sm" value="<?php echo $student["last_name"] ?>"" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Имя</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $student["first_name"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Отчество</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $student["otc"] ?>"" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Телефон</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $student["phone_number"] ?>"" disabled/>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div><h5>Изменения в расписании</h5></div><br/>       
        </div>
    </div>
</div>

<div class="header_parents">
    <h5>Родители</h5>
</div>
<div class="parents">
    <div class="row">
        
<?php foreach ($parents as $parent){ ?>
        <div class="col-6">
            <div class="row">
                <div class="col-4">
                    <p>Тип опекуна</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $parent["parents_type"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Имя</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $parent["first_name"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Фамилия</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $parent["last_name"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Отчество</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $parent["otc"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Телефон</p> 
                </div>
                <div class="col-6">
                    <input class="form-control form-control-sm" value="<?php echo $parent["phone_number"] ?>" disabled/>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <p>Место работы</p> 
                </div>
                <div class="col-6">
                    <textarea class="form-control form-control-sm"disabled><?php echo $parent["work_place"] ?></textarea>
                </div>
            </div>
        </div>
<?php } ?>
        </div>
</div>