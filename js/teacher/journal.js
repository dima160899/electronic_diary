$(function(){
    var student_id = 0;
    $("#students").on("change",function(){
        
        student_id = $("#students").children("option:selected").val();
        if(student_id != 0){
            $("#mark").removeAttr("disabled");
            $("#date").removeAttr("disabled")
        }else{
            $("#mark").attr("disabled","disabled");
            $("#mark").html("Введите домашнее задание");
            $("#date").attr("disabled","disabled");
        }
    });
    $(".send").on("click",function(){
        if(student_id != 0){
            var class_id = this.id;
            class_id=class_id.replace("s",'');
            var disc_id = $("#class"+class_id + " #disc").val();
            var mark = $("#class"+class_id + " #mark").children("option:selected").val();
            var date = $("#date").val();
            if(date <= now()){
                    $.ajax({
                        url:"save_mark",
                        data:{stud_id:student_id, disc_id:disc_id, mark:mark, date:date},
                        success:function(data){
                        }
                    });
            }else{
                alert("Не существующая дата");
            }
        }else{
            alert("Выберите студента");
        }    
    });
   
});