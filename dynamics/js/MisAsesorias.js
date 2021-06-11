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

    //Funcion que despliega la tabla.
    function tabla(){
        let tabla= peticion('../dynamics/php/MisAsesorias.php', 'sesion='+true+'&tabla='+true);
        tabla.done((resp)=>{
            $("#tablasec").html(resp)
        });
        tabla.fail((resp)=>{
            alert("fallo tabla");
        });
    }

    //Variables del canvas.
    let canvas = document.getElementById("canvas");
    let ctx = canvas.getContext("2d");

    //Funcion que despliega el canvas con los datos de la asesoria.
    function canvasAsesoria(ctx, datos){
        //Arreglo de datos
        datos = datos.split(",");   //0 = Materia, 1 = tema, 2 = modalidad, 3 = medio, 4 = horario,5 = fecha,6 = cupo,7 = Asesor.
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        //Tema
        ctx.beginPath();
            ctx.font = "bold 20px Verdana";
            ctx.fillStyle="blue";
            ctx.fillText(datos[1], 0, canvas.height/8);
        ctx.closePath();
        //Materia
        ctx.beginPath();
            ctx.font = "bold 10px Verdana";
            ctx.fillStyle="black";
            ctx.fillText(datos[0], 0, canvas.height/5);
        ctx.closePath();
        //Fecha
        ctx.beginPath();
            ctx.font = "bold 10px Verdana";
            ctx.fillStyle="black";
            ctx.fillText("Fecha: "+datos[5], canvas.width*.6, canvas.height/4);
        ctx.closePath();
        //Horario
        ctx.beginPath();
            ctx.font = "bold 12px Verdana";
            ctx.fillStyle="red";
            ctx.fillText(datos[4], canvas.width/4, canvas.height*.35);
        ctx.closePath();
        // //Modalidad
        ctx.beginPath();
            ctx.font = "bold 12px Verdana";
            ctx.fillStyle="purple";
            ctx.fillText("Modalidad: "+datos[2], 0, canvas.height*.45);
        ctx.closePath();
        // //Medio
        ctx.beginPath();
            ctx.font = "bold 10px Verdana";
            ctx.fillStyle="black";
            ctx.fillText("Medio: "+datos[3], 0, canvas.height*.55);
        ctx.closePath();
        //Cupo
        ctx.beginPath();
            ctx.font = "bold 12px Verdana";
            ctx.fillStyle="red";
            ctx.fillText("Cupo: "+datos[6]+" personas", canvas.width*.30, canvas.height*.70);
        ctx.closePath();
        //Asesor
        ctx.beginPath();
            ctx.font = "bold 12px Verdana";
            ctx.fillStyle="black";
            ctx.fillText("Asesor: "+datos[7], 0, canvas.height*.9);
        ctx.closePath();
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
            tabla();
            canvas.style.display = "block";
            $("#descargarCanvas").show();
            canvasAsesoria(ctx, resp);
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
        let estado= peticion("../dynamics/php/MisAsesorias.php", "sesion="+true+"&valorhorario="+boton+"&estadoases="+true);
        estado.done((resp)=>{
            alert(resp);
            tabla();
        });
        estado.fail((resp)=>{
            alert("Hubo un problema para procesar tu peticion");
        });
    });

    //Evento que detecta el boton de borrar un elemento.
    document.getElementById("download").addEventListener('click',()=>{
        document.getElementById("download").href = canvas.toDataURL("image/png");
    });

})
