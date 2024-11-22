$(document).ready(function(){
    $('#distrito').change(function(){
        var distrito = $(this).val();
        if (distrito == "0" ) {
          $('#concelho').empty().append('<option value ="0">Selecionar Concelho</option>');
          $('#fregue').empty().append('<option value ="">Selecionar a Freguesia</option>');
        } 
        else if(distrito == "" ){
            $('#concelho').empty().append('<option value ="">Todos os Concelhos</option>');
            $('#fregue').empty().append('<option value ="">Todas as Freguesias</option>');
        }
        else {
          let tag = "concelho";
          $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {distrito: distrito, tag: tag},
            dataType:'json',
            success: function(response){
              $('#concelho').empty().append('<option value="">Selecionar Concelho</option>');
              $('#fregue').empty().append('<option value="">Selecionar Freguesia</option>');
              response.forEach((item,index)=>{
                var option = document.createElement("option");
                option.value = item['id'];
                option.text = item['nome'];
                $('#concelho')[0].appendChild(option);
              })
            }
          })
        }
      })
      $('#concelho').change(function(){
        var concelho = $(this).val();
        if (concelho == "0" ) {
            $('#fregue').empty().append('<option value ="">Selecionar a Freguesia</option>');
          } 
          else if(concelho == "" ){
              $('#fregue').empty().append('<option value ="">Todas as Freguesias</option>');
          }else {
          let tag = "fregue";
          $.ajax({
            type: 'POST',
            url: 'ajax.php',
            data: {concelho: concelho, tag: tag},
            dataType:'json',
            success: function(response){
              $('#fregue').empty().append('<option value="">Selecionar Freguesia</option>');
              response.forEach((item,index)=>{
                var option = document.createElement("option");
                option.value = item['id'];
                option.text = item['nome'];
                $('#fregue')[0].appendChild(option);
              })
            }
          })
        }
      })
      $('#popupes').click(function() {
        popup();
    });
    $('#indexfilter').click(function() {
      filtermenu();
  });
})
c=0
function popup(){
    if(c%2==0){
        document.getElementById("popup").style.display="none";
        document.querySelector(".pop-up").style.paddingLeft=3+"px";
        document.getElementById("popupicon").classList.add("rotate-right");
        document.getElementById("popupicon").classList.remove("rotate-left");         
    }else{
        document.getElementById("popup").style.display="block";
        document.querySelector(".pop-up").style.paddingLeft=10+"px";
        document.getElementById("popupicon").classList.add("rotate-left"); 
        document.getElementById("popupicon").classList.remove("rotate-right");
    }
    c++;
}
cfilter=0
function filtermenu(){
  if(cfilter%2==0){
    document.getElementById("filtermenu").style.display="flex"
  }
  else{
    document.getElementById("filtermenu").style.display="none"
  }
}
