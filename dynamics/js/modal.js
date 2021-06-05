$(document).ready(function() {
    $("#crearCuenta").click(()=>{
        $("#miModal").css("display", "block");
    });

    $("#closeBtn").click(()=>{
        $("#miModal").css("display", "none");
    });

    $("#cursando").on("change",()=>{
        let cursando= $("#cursando").val();
        let peticion=$.ajax({
            url:"../dynamics/php/consultaModal.php",
            data:{dato1:cursando},
            method:"POST"
        });
        peticion.done(function(resp){
            $("#materias").html(resp);
        })
        peticion.fail(function(resp){
            alert("falle");
        })
    });
    $("#HorarioDia").on("change",()=>{
        let dsemana= $("#HorarioDia").val();
        let peticion=$.ajax({
            url:"../dynamics/php/consultaModal.php",
            data:{dato2:dsemana},
            method:"POST"
        });
        peticion.done(function(resp){
            $("#HorarioHora").html(resp);
            alert(resp);
        })
        peticion.fail(function(resp){
            alert("falle");
        })
    });
    $("#enviar").on("submit",()=>{
        let num_cuenta=$("#numcuenta");
        let nombre=$("#nombre");
        let apPaterno=$("#apPaterno");
        let apMaterno=$("#apMaterno");
        let correo=$("#correo");
        let tel=$("#tel");
        let dia=$("#dia");
        let mes=$("#mes");
        let año=$("#año");
        let materias=$("#materias");
        let hora= $("#HorarioHora").val();
        let contra=$("#contraseña")
        let peticion=$.ajax({
            url:"../php/consultaModal.php",
            data:{dato3:num_cuenta, dato4:nombre, dato5:apPaterno, dato6:apMaterno, dato7: correo, dato8:tel, dato9:dia,
                 dato10:mes, dato11:año, dato12:materias,dato13:hora, dato14:contra},
            method:"POST"
        });

        peticion.done(function(resp){
            $(".tablero").html(resp);
        })
        peticion.always(function(resp){
            alert("datos enviados");
        })
        peticion.fail(function(resp){
            alert("falle");
        })
    })
})
    /*
    $("#enviar").on("submit",()=>{
        let num_cuenta=$("#numcuenta");
        let nombre=$("#nombre");
        let apPaterno=$("#apPaterno");
        let apMaterno=$("#apMaterno");
        let nombre=$("#correo");
        let tel=$("#tel");
        let dia=$("#dia");
        let mes=$("#mes");
        let año=$("#año");
        let cursando= $("#cursando").val();
        let name= $(".nombre").val();
        alert(num);
        let peticion=$.ajax({
            url:"../php/consultaModal.php",
            data:{dato1:cuenta, dato2:name},
            method:"POST"
        });

        peticion.done(function(resp){
            $(".tablero").html(resp);
        })
        peticion.always(function(resp){
            alert("datos enviados");
        })
        peticion.fail(function(resp){
            alert("falle");
        })
    })
    */


