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

    //Funcion que despliega las asesorias.
    function tablita(){
        let tabla = peticion("./dynamics/php/MisAsesorias.php","sesion="+true+"&todasAsesorias="+true);
        tabla.done((resp)=>{
            $(".resultados").html(resp);
        })
        tabla.fail((resp)=>{
        })
    }

    //Evento que permite desplegar la nav.
    var ham=document.querySelector("#hamburguesa");
    var barra=document.querySelectorAll(".link");
    ham.addEventListener("click",()=>{
        document.querySelector(".nav").classList.toggle("navbarMob");
        for(let i=0; i< barra.length;i++){
            barra[i].classList.toggle("barraNMob");
        }

    });

     //Para saber si hay sesión
     let sesion = peticion('./dynamics/php/index.php', 'sesion='+true+"&eltipo="+true);
     sesion.done((resp)=>{
        if(resp=="NO HAY SESION")
             location = "./templates/registro.html";
        else if(resp=="SI ES ADMIN"){
            $("#administrar").show();
        }
        else if(resp=="NO ES ADMIN"){
            $("#administrar").hide();
        }
     })

     //despliega la tabla
     tablita();

    //Inscribirse
    let body= $(document.body);
    $(body).on('click','.inscribirse', function(){
        let boton = $(this).attr("id");
        console.log(boton);
        let insc = peticion("./dynamics/php/index.php", "sesion="+true+"&inscribirse="+boton);
        insc.done((resp1)=>{
            console.log(resp1);
            tablita();
        });
        insc.fail((resp1)=>{
        });
    });
    $(body).on('click','.desinscribirse',function(){
        let boton = $(this).attr("id");
        console.log(boton);
        let desins=peticion("./dynamics/php/index.php", "sesion="+true+"&desinscribirse="+boton);
        desins.done((resp)=>{
            console.log(resp);
            tablita();
        })
        desins.fail((resp)=>{
        })
    })
    $(body).on('click','#buscar',function(){
        let search= $("#buscador").val();
        let desins=peticion("./dynamics/php/index.php", "sesion="+true+"&search="+search);
        desins.done((resp)=>{
            console.log(resp);
            $(".resultados").html(resp);
        })
        desins.fail((resp)=>{
        })
    });

    $(body).on('focus', '.filtro', function(){
        let filtros = $(this).attr("id");
        let seleccionar = peticion("./dynamics/php/index.php", "sesion="+true+"&filtro="+filtros);
        // console.log(filtros);
        seleccionar.done((resp)=>{
            $(this).html("<option>Selecciona</option>"+resp);
        })
        seleccionar.fail((resp)=>{
        })
    })
    $(body).on('blur', '.filtro', function(){
        let filtro = $(this).attr("id");
        if(filtro=="hora"){
            $(this).html("<option class='filtro' id='"+filtro+"'>Hora</option>");
        }
        else if(filtro=="Nombre"){
            $(this).html("<option class='filtro' id='"+filtro+"'>Materia</option>");
        }
        else{
            $(this).html("<option class='filtro' id='"+filtro+"'>"+filtro+"</option>");
        }
    })
    $(body).on('change', '.filtro', function(){
        let filtro = $(this).attr("id");
        let buscando= $(this).val();
        let buscaSelect = peticion("./dynamics/php/index.php", "sesion="+true+"&buscando="+buscando+"&filtrobusq="+filtro);
        buscaSelect.done((resp)=>{
            $(".resultados").html(resp);
        })
        buscaSelect.fail((resp)=>{
        })
    })
    $(body).on('click','.borrar', function(){
        let boton = $(this).attr("id");
        let eliminar = peticion("./dynamics/php/MisAsesorias.php", "sesion="+true+"&delete="+boton);
        eliminar.done((resp)=>{
            tablita();
        });
        eliminar.fail((resp)=>{
        });
    })

     //Botones del modal footer (abrir y cerrar).
     $("#cred").click(()=>{
        $("#mCreditos").css("display", "block");
    });

    $("#closeBtn").click(()=>{
        $("#mCreditos").css("display", "none");
    });
});
