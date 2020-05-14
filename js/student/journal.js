$(function(){
    $.ajax({
      url:"get_disc",
      success:function(data){
          $("#disciplin").html(data);
          console.log(data);
          get_mark();
      }
       
   });
   
});
function get_mark(){
    var semestr = $("#semestr").children("option:selected").val();
    var disc = $("#disciplin").children("option:selected").val();
    $.ajax({
      url:"get_mark",
      data:{semestr:semestr, disciplin:disc},
      success:function(data){
          $("#marks").html(data);
      }
       
   });
}

