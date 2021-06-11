$(document).ready(()=>{
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

    function iniMaterias(){

        //Peitcion que permite desplegar la materias del usuario.
        let materias = peticion("../dynamics/php/user.php", "sesion="+true+"&asignaturas="+true);
        materias.done((resp)=>{
            $("#listaMat").html(resp);
        });
        materias.fail((resp)=>{
            alert("fallo asignatura");
        });

        //Desplegar materias en el select.
        let materias_select = peticion("../dynamics/php/user.php", "sesion="+true+"&materias_select="+true);
        materias_select.done((resp)=>{
            //alert("materias select"+resp);
            $("#agregarm").html("<option id='opcionTitulo1' value='' selected><p>Agregar materia</p></option>"+resp);
        });
        materias_select.fail((resp)=>{
            alert("fallo select asignatura");
        });

        //eliminar materia
        let eliminar_materias = peticion("../dynamics/php/user.php", "sesion="+true+"&eliminar="+true);
        eliminar_materias.done((resp)=>{
            //alert(resp);
            if(resp=="UNA MATERIA")
                $("#eliminarm").hide();
            else{
                $("#eliminarm").show();
                $("#eliminarm").html("<option id='opcionTitulo2' value='' selected><p>Eliminar materia</p></option>"+resp);
            }

        });
        eliminar_materias.fail((resp)=>{
            alert("fallo eliminar");
        });
    }

    //Funcion que inicializa los horarios.
    function iniHorarios(){
        let horarios = peticion("../dynamics/php/user.php", "sesion="+true+"&horarios="+true);
        horarios.done((resp)=>{
            $("#listaHor").html(resp);
        });
        horarios.fail((resp)=>{
            alert("fallo eliminar");
        });

        let eliminarHorario = peticion("../dynamics/php/user.php", "sesion="+true+"&eliminarHorarios="+true);
        eliminarHorario.done((resp)=>{
            if(resp=="UN HORARIO"){
                $("#eliminarHorario").hide();
            }
            else{
                $("#eliminarHorario").show();
                $("#eliminarHorario").html("<option value='' selected>Eliminar horario</option>"+resp);
            }
        });
        eliminarHorario.fail((resp)=>{
            alert("no se elimina");
        });
    }

    //Peticion que nos permite desplegar los datos básicos del usuario.
    function datos_usuario(){
        let datos = peticion("../dynamics/php/user.php", "sesion="+true+"&datos="+true);
        datos.done((resp)=>{
            let array_datos = resp.split(",");

            //Cambiar el valor del grado (C, Q, S).
            array_datos[4] = (array_datos[4] == 'C')? '4to':array_datos[4];
            array_datos[4] = (array_datos[4] == 'Q')? '5to':array_datos[4];
            array_datos[4] = (array_datos[4] == 'S')? '6to':array_datos[4];

            //Inserción de datos dentro del HTML.
            $("#img2").attr("src", "../statics/img/user/"+array_datos[5]);
            $("#nombre_usuario").html("<strong>Nombre: </strong>"+array_datos[1]);
            $("#no_cuenta").html("<strong>No. Cuenta: </strong>"+array_datos[0]);
            $("#tel").html("<strong>Telefóno: </strong>"+array_datos[3]);
            $("#correo_usuario").html("<strong>Correo: </strong>"+array_datos[2]);
            $("#cursando").html("<strong>Año que cursas: </strong>"+array_datos[4]);

            //SACAR EL AVG de las calificiones que tiene en la tabla de comentarios.
        });
        datos.fail((resp)=>{
            let mensaje = "error al cargar los datos";
            $("#img2").attr("src", "../statics/img/user/user.png");
            $("#p1").text("<strong>Nombre: </strong>"+mensaje);
            $("#no_cuenta").text("<strong>No. Cuenta: </strong>"+mensaje);
            $("#correo_usuario").text("<strong>Correo: </strong>"+mensaje);
            $("#cursando").text("<strong>Año que cursas: </strong>"+mensaje);
        });
    }

    //Peticion para redireccionar en caso de no haber una sesion activa.
    let sesion = peticion("../dynamics/php/user.php", "sesion="+true);
    sesion.done((resp)=>{
        //alert(resp);
        if(resp=="NO HAY SESION"){
            location = "./registro.html";
        }
    });

    datos_usuario();

    //Evento que detecta cuando se personalizó la imagen.
    $("#imagen").on("change", ()=>{
        let direccion = $("#imagen").val();
        //alert(direccion);
        let cambiar_img = peticion("../dynamics/php/user.php", "sesion="+true+"&foto="+direccion);
        cambiar_img.done((resp)=>{
            datos_usuario();
        });
    });

    //Peiticion que permite desplegar todo lo relacionado con las materias del usuario.
    iniMaterias();

    //Desplegar horarios del usuario.
    iniHorarios();

    //Evento que permite borrar o agregar materias.
    $("#aceptar").click(()=>{
        let agregarm=$("#agregarm").val();
        let eliminarm=$("#eliminarm").val();
        let agrEli = peticion("../dynamics/php/user.php", "sesion="+true+"&agregarm="+agregarm+"&eliminarm="+eliminarm);
        agrEli.done((resp)=>{
            alert("Se agrElio");
            iniMaterias();
        })
        agrEli.fail((resp)=>{
            alert("no se pudo agrEli");
        });
    });

    //Boton que permite borrar o agregar horaria.
    $("#botonhor").click(()=>{
        let editHora = ($("#Horariohora").val() == null)? "":$("#Horariohora").val();
        let editDia = ($("#Horariodia").val() == null)? "":$("#Horariodia").val();
        let eliminaHor = $("#eliminarHorario").val();
        let editarHor = peticion("../dynamics/php/user.php", "sesion="+true+"&editHora="+editHora+"&editDia="+editDia+"&eliminaHor="+eliminaHor);
        alert(editHora+" "+editDia+" "+eliminaHor);
        editarHor.done((resp)=>{
            alert(resp);
            iniHorarios();
        });
        editarHor.fail((resp)=>{
            alert(resp);
        });
        $("#Horariohora").val("");
        $("#Horariodia").val("");

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
    //Botones del modal footer (abrir y cerrar).
    $("#cred").click(()=>{
        $("#mCreditos").css("display", "block");
    });

    $("#closeBtn").click(()=>{
        $("#mCreditos").css("display", "none");
    });

});
