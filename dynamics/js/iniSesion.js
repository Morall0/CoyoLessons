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
    //Manda un mensaje en el placeholder y le cambia el color.
    function incorrecta(elemento, mensaje, clase){
        $(elemento).val("");
        $(elemento).attr("placeholder", mensaje);
        $(elemento).addClass(clase);
    }

    //Funcion que verifica que todos los datos concuerden con las RegEx.s
    function verifRegx(num_cuenta, nombre, apPaterno, apMaterno, correo, tel, contra){
        //Variables REGEX
        let regexNumcuenta = /^((3(19|20|21))|(1(16|17|18)))\d{6}$/;
        let regexNombre = /^([A-Za-zÑñáéíóúÁÉÍÓÚ]( )?){2,30}$/;
        let regexApellidos = /^([A-Za-zÑñáéíóúÁÉÍÓÚ]( )?){2,30}$/;
        let regexCorreo = /^[\w\.\-]{4,28}@(((g|hot)mail|outlook|live|yahoo)\.com|(comunidad|alumno\.enp|enp)\.unam\.mx)|\.mx$/;
        let regexTel = /^((55|56)(\d{8}))$/;
        let regexContra = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$#_\.\-@$!¡=\(\)/%*¿?&])([A-Za-z\d$#_\.\-@$!¡=\(\)/%*¿?&]|[^ +\\\{\}\[\]]){10,30}$/;
        let mensaje = "Formato inválido";

        let cont=0;

        //Si alguno de los datos no coinciden, vuelve a agregar la regex al formulario.
        if(regexNumcuenta.test(num_cuenta)){
            cont++;
        }else{
            $("#numcuenta").attr("pattern", "^((3(19|20|21))|(1(16|17|18)))\\d{6}$");
            incorrecta("#numcuenta", mensaje, "placeholdmorado");
        }
        if(regexNombre.test(nombre)){
            cont++;
        }else{
            $("#nombre").attr("pattern", "([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]( )?){2,30}");
            incorrecta("#nombre", mensaje, "placeholdmorado");
        }
        if(regexApellidos.test(apPaterno)){
            cont++;
        }else{
            $("#apPaterno").attr("pattern", "([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]( )?){2,30}");
            incorrecta("#apPaterno", mensaje, "placeholdmorado");
        }
        if(regexApellidos.test(apMaterno)){
            cont++;
        }else{
            $("#apMaterno").attr("pattern", "([A-Z,a-z,Ññ,á,é,í,ó,ú,Á,É,Í,Ó,Ú]( )?){2,30}");
            incorrecta("#apMaterno", mensaje, "placeholdmorado");
        }
        if(regexCorreo.test(correo)){
            cont++;
        }else{
            $("#correo").attr("pattern", "^[\\w\\.\\-]{4,28}@(((g|hot)mail|outlook|live|yahoo)\\.com|(comunidad|alumno\\.enp|enp)\\.unam\\.mx)|\\.mx$");
            incorrecta("#correo", mensaje, "placeholdmorado");
        }
        if(regexTel.test(tel)==true){
            cont++;
        }else{
            $("#tel").attr("pattern", "^((55|56)(\\d{8}))$");
            incorrecta("#tel", mensaje, "placeholdmorado");
        }
        if(regexContra.test(contra)==true){
            cont++;
        }else{
            $("#contraseña").attr("pattern", "^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d)(?=.*[$#@$!=\\(\\)/%*?&])([A-Za-z\\d$#@$!=\\(\\)/%*?&]|[^ ]){10,30}$");
            incorrecta("#contraseña", mensaje, "placeholdmorado");
        }

        return cont;
    };

    //Peticion que permite redireccionar en caso de que ya haya una sesion activa.
    let sesion = peticion("../dynamics/php/iniSesion.php", "sesionRegistro="+true);
    sesion.done((respsesion)=>{
        
        if(respsesion=="SI HAY SESION"){
            location = "../index.html";
        }
    });

    //Evento que permite iniciar sesión
    $("#inicio").on('submit', ()=>{
        event.preventDefault();
        let numero_cuenta=$("#numerocuenta").val();
        let contraseña=$("#contra").val();

        let iniciar = peticion('../dynamics/php/iniSesion.php','sesionRegistro='+true+'&num_ini='+numero_cuenta+'&contraseña='+contraseña);
        iniciar.done((resp)=>{
            if(resp == "CONTRASEÑA CORRECTA"){
                location="../index.html";

            }
            else if(resp == "NO EXISTE")
                incorrecta("#numerocuenta", "Número de cuenta no registrado", "placeholdrojo");
            else if(resp == "CONTRASEÑA INCORRECTA")
                incorrecta("#contra", "Contraseña incorrecta", "placeholdrojo");
        });
        iniciar.fail(()=>{
            
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
        let materias = peticion('../dynamics/php/iniSesion.php', 'sesionRegistro='+true+'&anio='+cursando);
        materias.done((resp)=>{
            $("#materias").html(resp);
        });
        materias.fail(()=>{
            
        });
    });

    //Evento que manda los datos mediante ajax al momento de darle submit al modal.
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

        //Funcion de regex.
        let regexing = verifRegx(num_cuenta, nombre, apPaterno, apMaterno, correo, tel, contra);

        if(regexing == 7){//Solo manda la petición si todas las regex son correctas.
            let respuestas = peticion('../dynamics/php/iniSesion.php', 'sesionRegistro='+true+'&num_cuenta='+num_cuenta+'&nombre='
            +nombre+' '+apPaterno+' '+apMaterno+'&correo='+correo+'&tel='+tel+'&fechaNac='+año+'-'+mes+'-'+dia+
            '&cursando='+cursando+'&materias='+materias+'&dsemana='+dsemana+'&hora='+hora+'&contra='+contra);

            respuestas.done((respuesta)=>{

                if(respuesta > 0)
                    incorrecta("#numcuenta", "Este numero de cuenta ya está registrado", "placeholdrojo");
                else{
                    location = "../index.html";
                }
            });

            respuestas.fail((respuesta)=>{
                
            });
        }
        else{
            
        }
    });
});
