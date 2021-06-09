$(document).ready(function(){

    let url = "../dynamics/php/admin.php";

    //Funcion que nos permite hacer petiiciones.
    function peticion(url, data=""){
        let peticion =$.ajax({
            url: url,
            type: 'POST',
            data: data
        });
        return peticion;
    };

    //Funcion que despliega los usuarios.
    function desp_usuarios(){
        let usuarios = peticion(url, "usuarios="+true);
        usuarios.done((resp)=>{
            $("tbody").html(resp);
        });
        usuarios.fail((resp)=>{
            alert("Hubo problemas");
        });
    }

    desp_usuarios();
    let body= $(document.body);
    //Evento que activa la peticion que elimina usuarios
    $(body).on('click','.borrar', function(){
        let boton = $(this).attr("id");
        alert(boton);
        let eliminar = peticion(url, "delete="+boton);
        eliminar.done((resp)=>{
            alert(resp+"respuesta");
            desp_usuarios();
        });
        eliminar.fail((resp)=>{
            alert("Hubo un problema para procesar tu peticion");
        });
    });
});
