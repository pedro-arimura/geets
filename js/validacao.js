$(document).keyup(function(){
    var validacao = 0;
    $("input").each(function(){
        switch($(this).attr("id")){
            case 'email':
                if(validaEmail($(this).val()) === false){
                    validacao++;
                }
                break;
            case 'senha':
                if($(this).val().length < 8){
                    validacao++;
                }
                break;
            case 'reptSenha':
                if($(this).val() != $('#senha').val()){
                    validacao++;
                }
                break;
        }
    });
    if(validacao == 0){
        $("#teste").prop("disabled", false);   
    }
    else{
        $("#teste").prop("disabled", true);        
    }
});

function validaEmail(email){
    usuario = email.substring(0, email.indexOf("@"));
    dominio = email.substring(email.indexOf("@")+ 1, email.length);
    
    if ((usuario.length >=1) &&
        (dominio.length >=3) &&
        (usuario.search("@")==-1) &&
        (dominio.search("@")==-1) &&
        (usuario.search(" ")==-1) &&
        (dominio.search(" ")==-1) &&
        (dominio.search(".")!=-1) &&
        (dominio.indexOf(".") >=1)&&
        (dominio.lastIndexOf(".") < dominio.length - 1)){
        return true;
    }
    else{
        return false;
    }
}

$("form").submit(function(e){
    var alerta = `
    <div class="alert alert-success" role="alert">
        Cadastro iniciado com sucesso!
    </div>
    `;        
    $("#alerts").html(alerta);     
})