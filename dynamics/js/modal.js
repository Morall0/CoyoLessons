$(document).ready(function(){

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
            //alert(resp);
        })
        peticion.fail(function(resp){
            alert("falle");
        })
    });
    $("#cuenta").on("submit",()=>{
        let cursando= $("#cursando").val();
        let dsemana= $("#HorarioDia").val();
        let num_cuenta=$("#numcuenta").val();
        let nombre=$("#nombre").val();
        let apPaterno=$("#apPaterno").val();
        let apMaterno=$("#apMaterno").val();
        let correo=$("#correo").val();
        let tel=$("#tel").val();
        let dia=$("#dia").val();
        let mes=$("#mes").val();
        let año=$("#año").val();
        let materias=$("#materias").val();
        let hora= $("#HorarioHora").val();
        let contra=$("#contraseña").val();
        let peticion=$.ajax({
            url:"../dynamics/php/consultaModal.php",
            data:{dato1:cursando, dato2:dsemana, dato3:num_cuenta, dato4:nombre+" "+apPaterno+" "+apMaterno, dato5:correo, dato6:tel, dato7:año+"-"+mes+"-"+dia,
                 dato8:materias, dato9:hora, dato10:contra},
            method:"POST"
        });


        //SI NO FUNCIONA, DESCOMENTAR ESTO.
        /*peticion.done(function(resp1){
            alert("SI FUNCIONA"+resp1);
        })
        peticion.fail(function(resp1){
            alert("falle");
        })*/
    })
});



