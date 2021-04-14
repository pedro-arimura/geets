// Função para fazer o form multi step
var tabatual = 0;
showTab(tabatual);

function showTab(tab) {
    // Pega todas as tabs
    var x = document.getElementsByClassName("tab");
    // Mostra a tab atual
    x[tab].style.display = "block";
}
function nextPrev(val) {
    // Pega todas as tabs
    var x = document.getElementsByClassName("tab");

    // Verifica qual o tipo de registro
    if($("#regForm").hasClass('nd') == true){
      // Valida os campos feitos
      if(val == 1){
        switch (tabatual) {
          case 1:
            if($("#modelo").val() == ""){
              $("#modelo").addClass("erro");
              $("#erro-1").css("display", "block");
              break;
            }
            else{
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Limpa a classe de erro e esconde o span
              $("#modelo").removeClass("erro");
              $("#erro-1").css("display", "none");
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);         
              break;
            }

          case 2:
            if($("#imgPerfil").val() == ""){
              $("#imgPreview").addClass("erro");
              document.getElementById("erro-2").style.display = "block";
              break;
            }
            else{
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Limpa a classe de erro e esconde o span
              $("#imgPreview").removeClass("erro");
              $("#erro-2").css("display", "none");
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);
              break;
            }
            default:
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);
              break;
        }
      }
    }
    else if($("#regForm").hasClass("pf") == true){
      if(val == 1){
        switch (tabatual) {
          case 1:
            if($("#perfil").val() == ""){
              $("#perfil").addClass("erro");
              $("#erro-1").css("display", "block");
              break;
            }
            else{
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Limpa a classe de erro e esconde o span
              $("#perfil").removeClass("erro");
              $("#erro-1").css("display", "none");
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);         
              break;
            }
          default:
          // Oculta a tab atual
          x[tabatual].style.display = "none";
          // Soma ou subtrai o valor de qual tab estamos
          tabatual = tabatual + val;
          // Mostra a tab
          showTab(tabatual);
          break;
        }
      }
    }
    else{
      if(val == 1){
        switch (tabatual) {
          case 1:
            if($("#especialidade").val() == ""){
              $("#especialidade").addClass("erro");
              $("#erro-1").css("display", "block");
              break;
            }
            else{
              // Limpa a classe de erro e esconde o span
              $("#especialidade").removeClass("erro");
              $("#erro-1").css("display", "none");
              // Coloca a borda verde no campo
              $("#especialidade").addClass("correto");
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);                     
              break;
            }
            default:
              // Oculta a tab atual
              x[tabatual].style.display = "none";
              // Soma ou subtrai o valor de qual tab estamos
              tabatual = tabatual + val;
              // Mostra a tab
              showTab(tabatual);
              break;
          }
      }
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $('#imgPreview').attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }
  
 $("#imgPerfil").change(function() {
    readURL(this);
  });

  function check_card(id) {
  switch (id) {
    case 1:
      $("#check1").addClass("show-selected");
      $("#check2").removeClass("show-selected");
      $("#check3").removeClass("show-selected");
      $("#prosseguir").css("display", "block");
      $("#iniCad").attr("action", "cadastro-nd.php");
      break;
  
    case 2:
      $("#check2").addClass("show-selected");
      $("#check1").removeClass("show-selected");
      $("#check3").removeClass("show-selected");
      $("#prosseguir").css("display", "block");
      $("#iniCad").attr("action", "cadastro-exp.php");
      break;

    case 3:
      $("#check3").addClass("show-selected");
      $("#check2").removeClass("show-selected");
      $("#check1").removeClass("show-selected");
      $("#prosseguir").css("display", "block");
      $("#iniCad").attr("action", "cadastro-pf.php");
      break;
  }
}
function check_card_mobile(id){
  switch (id) {
    case 1:
      $("#check-mobile1").addClass("show-selected");
      $("#check-mobile2").removeClass("show-selected");
      $("#check-mobile3").removeClass("show-selected");
      $("#prosseguir-md").css("display", "block");
      $("#iniCad").attr("action", "cadastro-nd.php");
      break;
  
    case 2:
      $("#check-mobile2").addClass("show-selected");
      $("#check-mobile1").removeClass("show-selected");
      $("#check-mobile3").removeClass("show-selected");
      $("#prosseguir-md").css("display", "block");
      $("#iniCad").attr("action", "cadastro-exp.php");
      break;

    case 3:
      $("#check-mobile3").addClass("show-selected");
      $("#check-mobile2").removeClass("show-selected");
      $("#check-mobile1").removeClass("show-selected");
      $("#prosseguir-md").css("display", "block");
      $("#iniCad").attr("action", "cadastro-pf.php");
      break;
  }
}
// Função para fazer o multi-step da publicação
$('.select-tipo').click(function(){
  $("#tipo").val($(this).attr("id"));
  $(".tab").addClass("d-none");
  passar($(this).attr("id"));
});
// Função para validar o campo de descrição
$("#formPublicacao").submit(function(e){
  if($("#tipo").val() == "parceria"){
    if($("#descricao_parceria").val().length < 10){
      $("#erro-"+$("#tipo").val() + "2").removeClass("d-none");
      e.preventDefault();
    }
    else{
      $("#erro-"+$("#tipo").val() + "2").addClass("d-none");
    }
  }
  else{
    if($("#descricao_servico").val().length < 10){
      $("#erro-"+$("#tipo").val() + "2").removeClass("d-none");
      e.preventDefault();
    }
    else{
      $("#erro-"+$("#tipo").val() + "2").addClass("d-none");
    }
  }
});
// Função de passar o carinha
$('.pass-button').click(function(){
  passar($("#tipo").val());
});
function passar(tipo){
  if(tipo == "parceria"){
    var tabs = document.getElementsByClassName("tab-parceria");
    if(tabatual != 0){
      if(validarPub($("#tipo").val()) === true){
        tabs[tabatual - 1].classList.add("d-none");
      }
    }
    if(validarPub($("#tipo").val()) === true){
      tabs[tabatual].classList.remove("d-none");
      tabatual++;
    }
  }
  else{
    var tabs = document.getElementsByClassName("tab-servico");
    if(tabatual != 0){
      if(validarPub($("#tipo").val()) === true){
        tabs[tabatual - 1].classList.add("d-none");
      }
    }
    if(validarPub($("#tipo").val()) === true){
      tabs[tabatual].classList.remove("d-none");
      tabatual++;
    }
  }
}

function validarPub(tipo){
  if(tipo == "parceria"){
    if(tabatual == 1){
      if($("#titulo_parceria").val().length < 3){
        $("#erro-"+$("#tipo").val() + "1").removeClass("d-none");
        return false;
      }
      else{
        $("#erro-"+$("#tipo").val() + "1").addClass("d-none");
        return true;
      }
    }
    else{
      return true;
    }
  }
  else{
    if(tabatual == 1){
      if($("#titulo_servico").val().length < 3){
        $("#erro-"+$("#tipo").val() + "1").removeClass("d-none");
        return false;
      }
      else{
        $("#erro-"+$("#tipo").val() + "1").addClass("d-none");
        return true;
      }
    }
    else{
      return true;
    }
  }
}

function expand(obj){
  if($(obj).hasClass("expandir") === true){
    $(obj).removeClass("expandir");
    $(obj).addClass("retrair");
    $($(obj).parent()).children(".descricao").toggleClass("d-none");
    $(obj).text("Ler menos");
  }
  else{
    $(obj).removeClass("retrair");
    $(obj).addClass("expandir");
    $($(obj).parent()).children(".descricao").toggleClass("d-none");
    $(obj).text("Ler mais");
  }
}

function validacao(){
  
}