$(document).ready(()=>{
    
    function peticion(url, data=""){
        let peticion =$.ajax({
            url: url,
            type: 'POST',
            data: data
        });
        return peticion;
    };

    function incorrecta(elemento, mensaje){
        $(elemento).val("");
        $(elemento).attr("placeholder", mensaje);
        $(elemento).addClass("placehold");
    }

    function verifRegx(num_cuenta, nombre, apPaterno, apMaterno, correo, tel, contra){
        //Variables REGEX
        let regexNumcuenta = /^((3(19|20|21))|(1(16|17|18)))\d{6}$/;
        let regexNombre = /([A-Za-zÑñáéíóúÁÉÍÓÚ]( )?){2,30}/;
        let regexApellidos = /^([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]){2,30}$/;
        let regexCorreo = /^[\w\.\-]{4,28}@(((g|hot)mail|outlook|live|yahoo)\.com|(comunidad|alumno\.enp|enp)\.unam\.mx)|\.mx$/;
        let regexTel = /^((55|56)(\d{8}))$/;
        let regexContra = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#@$!=\(\)/%*?&])([A-Za-z\d$#@$!=\(\)/%*?&]|[^ ]){10,30}$/;

        let cont=0;

        if(regexNumcuenta.test(num_cuenta)==true){
            cont++;
        }else{
            $("#numcuenta").attr("pattern", "^((3(19|20|21))|(1(16|17|18)))\\d{6}$");
            $("#numcuenta").attr("title", "Introduce un número de cuenta válido");
        }
        if(regexNombre.test(nombre)==true){
            cont++;
            console.log("condicionalNombreIF");
        }else{
            $("#nombre").attr("pattern", "([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]( )?){2,30}");
            $("#nombre").attr("title", "Ingresa tu(s) nombre(s)");
            console.log("condicionalNombreELSE");
        }
        if(regexApellidos.test(apPaterno)==true){
            cont++;
        }else{
            $("#apPaterno").attr("pattern", "^([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]){2,30}$");
            $("#apPaterno").attr("title", "Introduce tu apellido paterno");
        }
        if(regexApellidos.test(apMaterno)==true){
            cont++;
        }else{
            $("#apMaterno").attr("pattern", "^([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]){2,30}$");
            $("#apMaterno").attr("title", "Introduce tu apellido materno");
        }
        if(regexCorreo.test(correo)==true){
            cont++;
        }else{
            $("#correo").attr("pattern", "^[\\w\\.\\-]{4,28}@(((g|hot)mail|outlook|live|yahoo)\\.com|(comunidad|alumno\\.enp|enp)\\.unam\\.mx)|\\.mx$");
            $("#correo").attr("title", "Introduce un correo válido");
        }
        if(regexTel.test(tel)==true){
            cont++;
        }else{
            $("#tel").attr("pattern", "^((55|56)(\\d{8}))$");
            $("#tel").attr("title", "Introduce tu número telefónico");
        }
        if(regexContra.test(contra)==true){
            cont++;
        }else{
            $("#contraseña").attr("pattern", "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[$#@$!=\\(\\)/%*?&])([A-Za-z\\d$#@$!=\\(\\)/%*?&]|[^ ]){10,30}$");
            $("#contraseña").attr("title", "Introduce una contraseña de 10 a 30 caracteres, con al menos un caracter especial, un número, una minúscula y una mayúscula");
        }

        return cont;
    };

    //Evento que permite iniciar sesión
    $("#inicio").on('submit', ()=>{
        event.preventDefault();
        let numero_cuenta=$("#numerocuenta").val();
        let contraseña=$("#contra").val();

        let iniciar = peticion('../dynamics/php/consultaModal.php', 'num_ini='+numero_cuenta+'&contraseña='+contraseña);
        iniciar.done((resp)=>{
            if(resp == "CONTRASEÑA CORRECTA")
                alert("location");
            else if(resp == "NO EXISTE")
                incorrecta("#numerocuenta", "Número de cuenta no registrado");
            else if(resp == "CONTRASEÑA INCORRECTA")
                incorrecta("#contra", "Contraseña incorrecta"); 
        });
        iniciar.fail(()=>{
            alert("fallo");
        });
    })

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

        let regexing = verifRegx(num_cuenta, nombre, apPaterno, apMaterno, correo, tel, contra);

        if(regexing == 7){
            let respuestas = peticion('../dynamics/php/consultaModal.php', 'num_cuenta='+num_cuenta+'&nombre='
            +nombre+' '+apPaterno+' '+apMaterno+'&correo='+correo+'&tel='+tel+'&fechaNac='+año+'-'+mes+'-'+dia+
            '&cursando='+cursando+'&materias='+materias+'&dsemana='+dsemana+'&hora='+hora+'&contra='+contra);

            respuestas.done((respuesta)=>{
                alert("si se envian desde JS");
                alert(respuesta);
                if(respuesta > 0)
                    incorrecta("#numcuenta", "Este numero de cuenta ya está registrado");
                else{
                    $("#miModal").css("display", "none");
                    //alert("location");
                }
            });
            
            respuestas.fail((respuesta)=>{
                alert("NO se envian desde JS");
            });
        }
        else{
            alert("Verificar que se hayan puesto correctamente en el html");
        }

        
    });


});