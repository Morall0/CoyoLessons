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

    let url = "../dynamics/php/coment.php"

    //Peticion que permite comprobar la sesion.
    let sesion = peticion(url, "sesion="+true);
    sesion.done((resp)=>{
        if(resp == "NO HAY SESION"){
            location = "../index.html";
        }
    });
    sesion.fail((resp)=>{
        console.log("Falló consulta de la sesión");
    });

    //Peticion que permite desplegar las asesorias en las que ha participado el usuario.
    let asesorias = peticion(url, "sesion="+true+"&asesoria"+true);
    asesorias.done((resp)=>{
        alert(resp);
    });
    asesorias.fail((resp)=>{
        alert(resp);
    });
});