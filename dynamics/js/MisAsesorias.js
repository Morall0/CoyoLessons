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

    $("#botonAsesoria").click(()=>{
        $("#crearA").css("display", "block");
    })
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
            $("#horario").html(resp);
        })
        horario.fail((resp)=>{
          alert("fallaron los horarios");  
        })
    })

    $("#crearAsesoria").on("submit",()=>{
        event.preventDefault(); 
        let materiaSelect = $("#materias").val();
        let tema = $("#tema").val();
        let modalidad = $("#modalidad").val();
        let medio = $("#medio").val();
        let horario = $("#horario").val();
        let duracion = $("#duracion").val();
        let fecha = $("#fecha").val();
        let crear = peticion('../dynamics/php/MisAsesorias.php', 'sesion='+true+'&formAsesoria='+true+'&materiaSelect='+materiaSelect+'&tema='+tema
        +'&modalidad='+modalidad+'&medio='+medio+'&horario='+horario+'&duracion='+duracion+'&fecha='+fecha);
        crear.done((resp)=>{
            alert(resp);
        })
        crear.fail((resp)=>{
          alert("falló el form");  
        })
    })
}) 
