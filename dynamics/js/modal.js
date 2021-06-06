$(document).ready(()=>{

    function peticion(url, data=""){
        let peticion =$.ajax({
            url: url,
            type: 'POST',
            data: data
        });
        return peticion;
    };

    //Botones del modal (abrir y cerrar).
    $("#crearCuenta").click(()=>{
        $("#miModal").css("display", "block");
    });

    $("#closeBtn").click(()=>{
        $("#miModal").css("display", "none");
    });

    //Petición que despliega las materias dependiendo del año.
    $("#cursando").on('change', ()=>{
        let cursando = $('#cursando').val();
        let materias = peticion('../dynamics/php/consultaModal.php', 'anio='+cursando);
        materias.done((resp)=>{
            $("#materias").html(resp);
        });
        materias.fail(()=>{
            alert("fallo");
        });
    });

    //Evento que manda los datos mediante ajax al momento de darle submit. 
    $("#cuenta").on('submit', ()=>{

        event.preventDefault(); //Evita que la página se recargue al darle submit.

        let num_cuenta=$("#numcuenta").val();
        let nombre=$("#nombre").val();
        let apPaterno=$("#apPaterno").val();
        let apMaterno=$("#apMaterno").val();
        let correo=$("#correo").val();
        let tel=$("#tel").val();
        let dia=$("#dia").val();
        let mes=$("#mes").val();
        let año=$("#año").val();
        let cursando= $("#cursando").val();
        let materias=$("#materias").val();
        let dsemana= $("#HorarioDia").val();
        let hora= $("#HorarioHora").val();
        let contra=$("#contraseña").val();
        let respuestas = peticion('../dynamics/php/consultaModal.php', 'num_cuenta='+num_cuenta+'&nombre='
        +nombre+' '+apPaterno+' '+apMaterno+'&correo='+correo+'&tel='+tel+'&fechaNac='+año+'-'+mes+'-'+dia+
        '&cursando='+cursando+'&materias='+materias+'&dsemana='+dsemana+'&hora='+hora+'&contra='+contra);

        respuestas.done((respuesta)=>{
            alert("si se envian desde JS");
            alert(respuesta);
            if(respuesta == "REGISTRO EXITOSO"){
                alert("location");
            }
            if(respuesta > 0){
                $("#numcuenta").val("");
                $("#numcuenta").attr("placeholder","Este numero de cuenta ya está registrado");
                $("#numcuenta").addClass("placehold");
            }
            //$("#miModal").css("display", "none");
        });
        
        respuestas.fail((respuesta)=>{
            alert("NO se envian desde JS");
        });
        
    });


});