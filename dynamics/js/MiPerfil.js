$(document).ready(()=>{
    let dia = $("#Horariodia");
    let hora = $("#Horariohora");
    dia.hide();
    hora.hide();
    var ham=document.querySelector("#hamburguesa");
    var barra=document.querySelectorAll(".link");
    ham.addEventListener("click",()=>{
        document.querySelector(".nav").classList.toggle("navbarMob");
        for(let i=0; i< barra.length;i++){
            barra[i].classList.toggle("barraNMob");
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

    let sesion = peticion("../dynamics/php/user.php", "sesion="+true);
    sesion.done((resp)=>{
        alert(resp);
        if(resp=="NO HAY SESION"){
            location = "./registro.html";
        }
    });

    let datos = peticion("../dynamics/php/user.php", "sesion="+true+"&datos="+true);
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

    });
    
    datos.fail((resp)=>{
        let mensaje = "error al cargar los datos";
        $("#img2").attr("src", "../statics/img/user/user.png");
        $("#p1").text("Nombre: "+mensaje);
        $("#no_cuenta").text("No. Cuenta: "+mensaje);
        $("#correo_usuario").text("Correo: "+mensaje);
        $("#cursando").text("Año que cursas: "+mensaje);
    });

    //Peitcion que permite desplegar la materias del usuario.
    let materias = peticion("../dynamics/php/user.php", "sesion="+true+"&asignaturas="+true);
    materias.done((resp)=>{
        alert("Si salió");
    });
    materias.fail((resp)=>{
        alert("fallo asignatura");
    });

    //Desplegar materias en el select.
    let materias_select = peticion("../dynamics/php/user.php", "sesion="+true+"&materias_select="+true);
    materias_select.done((resp)=>{
        alert("materias select"+resp);
        $("#agregarm").append(resp);
    });
    materias_select.fail((resp)=>{
        alert("fallo select asignatura");
    });
    
    //eliminar materia
    let eliminar_materias = peticion("../dynamics/php/user.php", "sesion="+true+"&eliminar="+true);
    eliminar_materias.done((resp)=>{
        alert("Si salió");
        $("#eliminarm").append(resp);
    });
    eliminar_materias.fail((resp)=>{
        alert("fallo eliminar");
    });

    //Desplegar horarios del usuario.
    let horarios = peticion("../dynamics/php/user.php", "sesion="+true+"&horarios="+true);
    horarios.done((resp)=>{
        $("#horitas").append(resp);
    });
    horarios.fail((resp)=>{
        alert("fallo eliminar");
    });

    let administrar = $("#administrar").on('click',()=>{
        dia.show();
        hora.show();
        $("#botonhor").show();
        
    });

    //Cerrar session
    $("#cerrar").click(()=>{
        let cerrar = peticion("../dynamics/php/user.php", "sesion="+true+"&cerrar="+true);
        cerrar.done((resp)=>{
            location = "./registro.html";
        });
        cerrar.fail((resp)=>{
            alert("no funciona");
        });
    
    });
});