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

    var ham=document.querySelector("#hamburguesa");
    var barra=document.querySelectorAll(".link");
    ham.addEventListener("click",()=>{
        document.querySelector(".nav").classList.toggle("navbarMob");
        for(let i=0; i< barra.length;i++){
            barra[i].classList.toggle("barraNMob");
        }

    });

     //Para saber si hay sesión
     let sesion = peticion('./dynamics/php/index.php', 'sesion='+true);
     sesion.done((resp)=>{
         if(resp=="NO HAY SESION")
             location = "./templates/registro.html";
     })


    let tabla = peticion("./dynamics/php/MisAsesorias.php","sesion="+true+"&todasAsesorias="+true);
    tabla.done((resp)=>{
        $("tbody").html(resp);
    })
    tabla.fail((resp)=>{
        alert(resp);
    })

    //Inscribirse
    let body= $(document.body);
    $(body).on('click','.inscribirse', function(){
        let boton = $(this).attr("id");
        console.log(boton);
        let insc = peticion("./dynamics/php/index.php", "sesion="+true+"&inscribirse="+boton);
        insc.done((resp1)=>{
            console.log(resp1);
        });
        insc.fail((resp1)=>{
            alert("Hubo un problema para procesar tu peticion");
        });
    });


});
