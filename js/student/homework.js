$(function(){
    $.ajax({
      url:"get_disc",
      success:function(data){
          $("#disciplin").html(data);
          console.log(data);
          get_hw();
      }
       
   });
   
});
function get_hw(){
    var disc = $("#disciplin").children("option:selected").val();
    $.ajax({
      url:"get_hw",
      data:{disciplin:disc},
      success:function(data){
          $("#hw").html(data);
      }
       
   });
}

