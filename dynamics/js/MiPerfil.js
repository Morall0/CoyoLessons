$(document).ready(()=>{

    var ham=document.querySelector("#hamburguesa");
    var barra=document.querySelectorAll(".link")
    ham.addEventListener("click",()=>{
        document.querySelector(".nav").classList.toggle("navbarMob");
        for(let i=0; i< barra.length;i++){
            barra[i].classList.toggle("barraNMob")
        }
    })

    //Funcion que nos permite hacer petiiciones.
    function peticion(url, data=""){
        let peticion =$.ajax({
            url: url,
            type: 'POST',
            data: data
        });
        return peticion;
    };

    let datos = peticion("../dynamics/php/user.php");
    datos.done((resp)=>{
        let array_datos = resp.split(",");

        //Cambiar el valor del grado (C, Q, S).
        array_datos[4] = (array_datos[4] == 'C')? '4to':array_datos[4];
        array_datos[4] = (array_datos[4] == 'Q')? '5to':array_datos[4];
        array_datos[4] = (array_datos[4] == 'S')? '6to':array_datos[4];

        //Inserción de datos dentro del HTML.
        $("#img2").attr("src", "../statics/img/user/"+array_datos[5]);
        $("#nombre_usuario").text("Nombre: "+array_datos[1]);
        $("#no_cuenta").text("No. Cuenta: "+array_datos[0]);
        $("#tel").text("Telefóno: "+array_datos[3]);
        $("#correo_usuario").text("Correo: "+array_datos[2]);
        $("#cursando").text("Año que cursas: "+array_datos[4]);

        //SACAR EL AVG de las calificiones que tiene en la tabla de comentarios.

    })
    datos.fail((resp)=>{
        let mensaje = "error al cargar los datos"
        $("#img2").attr("src", "../statics/img/user/user.png");
        $("#p1").text("Nombre: "+mensaje);
        $("#no_cuenta").text("No. Cuenta: "+mensaje);
        $("#correo_usuario").text("Correo: "+mensaje);
        $("#cursando").text("Año que cursas: "+mensaje);
    });

})
