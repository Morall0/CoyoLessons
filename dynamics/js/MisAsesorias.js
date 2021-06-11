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

    function tabla(){
        let tabla= peticion('../dynamics/php/MisAsesorias.php', 'sesion='+true+'&tabla='+true);
        tabla.done((resp)=>{
            $("#tablasec").html(resp)
        })
        tabla.fail((resp)=>{
            alert("fallo tabla");
    })
    }
    //abrir y cerrar el modal
    $("#botonAsesoria").click(()=>{
        $("#miModal").css("display", "block");
    });
    $("#closeBtn").click(()=>{
        $("#miModal").css("display", "none");
    });
    //Para saber si hay sesión
    let sesion = peticion('../dynamics/php/user.php', 'sesion='+true);
    sesion.done((resp)=>{
        if(resp=="NO HAY SESION")
            location = "./registro.html";
    })

    //Materias que tiene el usuario
    $("#materias").on("focus",()=>{
        let materias = peticion('../dynamics/php/user.php', 'sesion='+true+'&eliminar='+true+'&materiaAsesoria='+true);
        materias.done((resp)=>{
            $("#materias").html(resp);
        })
        materias.fail((resp)=>{
            alert("fallaron las materias");
        })

    })
    //Horarios
    $("#horario").on("focus",()=>{
        let horario = peticion('../dynamics/php/user.php', 'sesion='+true+'&eliminarHorarios='+true+'&horarioAsesoria='+true);
        horario.done((resp)=>{
            $("#horario").html("<option selected>Elige un horario</option>"+resp);
        })
        horario.fail((resp)=>{
          alert("fallaron los horarios");
        })
    })
    $("#horario").on("change",()=>{
        let valorhorario= $("#horario").val();
        console.log(valorhorario);
        let horariofecha = peticion('../dynamics/php/misAsesorias.php', 'sesion='+true+'&valorhorario='+valorhorario);
        horariofecha.done((resp)=>{
            console.log(resp);
            $("#fecha").html(resp);
        })
        horariofecha.fail((resp)=>{
          alert("fallaron las fechas de los horarios");
        })

    })
    //Agregar asesorias
    $("#crearAsesoria").on("submit",()=>{
        event.preventDefault();
        let materiaSelect = $("#materias").val();
        let tema = $("#tema").val();
        let modalidad = $("#modalidad").val();
        let medio = $("#medio").val();
        let horario = $("#horario").val();
        let duracion = $("#duracion").val();
        let fecha = $("#fecha").val();
        let cupo = $("#cupo").val();
        let crear = peticion('../dynamics/php/MisAsesorias.php', 'sesion='+true+'&formAsesoria='+true+'&materiaSelect='+materiaSelect+'&tema='+tema
        +'&modalidad='+modalidad+'&medio='+medio+'&horario='+horario+'&duracion='+duracion+'&fecha='+fecha+'&cupo='+cupo);
        crear.done((resp)=>{
            alert(resp);
            tabla();
            $("#miModal").css("display", "none");
            $("#crearAsesoria")[0].reset();
        })
        crear.fail((resp)=>{
          alert("falló el form");
        })
    })
    //Cargar tabla
        tabla();
    //eliminar asesoria
    let body= $(document.body);
    $(body).on('click','.borrar', function(){
        let boton = $(this).attr("id");
        alert(boton);
        let eliminar = peticion("../dynamics/php/MisAsesorias.php", "sesion="+true+"&delete="+boton);
        eliminar.done((resp)=>{
            alert(resp+"respuesta");
            tabla();
        });
        eliminar.fail((resp)=>{
            alert("Hubo un problema para procesar tu peticion");
        });
    });
    $(body).on('click','.estado', function(){
        let boton = $(this).attr("id");
        alert(boton);
        let estado= peticion("../dynamics/php/MisAsesorias.php", "sesion="+true+"&estadoases="+boton);
        estado.done((resp)=>{
            //alert(resp+"respuesta");
            //tabla();
        });
        estado.fail((resp)=>{
            alert("Hubo un problema para procesar tu peticion");
        });
    });

})
