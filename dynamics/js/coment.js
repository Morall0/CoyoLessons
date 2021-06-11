$(document).ready(()=>{
    //Funcion que nos permite hacer petiiciones.
    function peticion(url, data=""){
        let peticion =$.ajax({
            url: url,
            type: 'POST',
            data: data
        });
        return peticion;
    };

    //Peticion que permite desplegar las asesorias en las que ha participado el usuario.
    function tabla(){
        let asesorias = peticion(url, "sesion="+true+"&asesoria="+true);
        asesorias.done((resp)=>{
            $("tbody").html(resp);
        });
        asesorias.fail((resp)=>{
        });
    }

    let url = "../dynamics/php/coment.php"

    //Peticion que permite comprobar la sesion.
    let sesion = peticion(url, "sesion="+true);
    sesion.done((resp)=>{
        if(resp == "NO HAY SESION"){
            location = "../index.html";
        }
    });
    sesion.fail((resp)=>{
    });
    //genera tabla
    tabla();
    //coments
    let body= $(document.body);
    $(body).on('click','.comentar', function(){
        let boton = $(this).attr("id");
        let insc = peticion("./dynamics/php/index.php", "sesion="+true+"&comentar="+boton);
        insc.done((resp1)=>{
            $(".comentario").show();
            $("#comentarBtn").append("<input id='numhid' hidden value="+resp1+">");
        });
        insc.fail((resp1)=>{

        });
    });

    //Evento que permite enviar el comentario y la calificacion.
    $(body).on('submit','#comentBtn',function(){
        event.preventDefault();
        let coment= $("#comentario").val();
        let select= $("rangcalif").val();
        let hidden= $("#numhid").val();
        //Peticion
        let sendcoment = peticion("./dynamics/php/index.php", "sesion="+true+"&comentario="+coment+"&calif="+select+"&id_asesoria="+hidden);
        sendcoment.done((resp1)=>{
            $(".comentario").hide();
            tabla();
        });
        sendcoment.fail((resp1)=>{
            
        });
    })

});
