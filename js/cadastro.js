$(document).ready(function(){
    $.ajax({
        url: "php/get-categoria.php",
        cache: false,
        processData: false,
        contentType: false,
        success: function(response){
            $("#categorias").html(response);
            console.log(response);
        },
        error: function(response){
            console.log(response);
        }
    });
});

$("#categorias").change(function(){
    var categoria = $("#categorias").val();
    $.ajax({
        url: "php/get-subcategoria.php",
        type: "POST",
        data:{
            categoria: categoria
        },
        success: function(response){
            $("#subcategorias").html(response);
        },
        error: function(response){
            console.log(response);
        }
    });
});