$(function(){
    $(".send").on("click",function(){
            var id = this.id;
            id=id.replace("s",'');
            var disc_id = $("#class"+id + " #disc").val();
            var class_id = $("#class"+id + " #class_id").val();
            var hw = $("#class"+id + " textarea").val();
            if(hw != ""){
                var date = $("#date").val();
                if(date != ""){
                    $.ajax({
                        url:"save_hw",
                        data:{class_id:class_id, hw:hw, disc_id:disc_id, date:date},
                        success:function(data){
                        }
                    });
                }else{
                    alert("Введите дату сдачи ДЗ");
                }
            }else{
                alert("Введите ДЗ");
            }
    });
   
});