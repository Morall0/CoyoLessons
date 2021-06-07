/*let hamburguesa = document.getElementById('hamburguesa'); //Variable que controla boton de la aburguesa.

//Evento que detecta cuando se presiono en la hamburguesa.
hamburguesa.addEventListener('click', ()=>{
    let barra = document.getElementsByClassName('nav'); //div de la barra de navegación.
    let links = document.getElementsByClassName('link');   //Variable que almacena los planetas(elementos con la clase barraN).

    //Condición que determina si el dropDown esta hecho o no.
    if(barra[0].getAttribute('style')!= null){
        //En caso de que si, remueve los atributos para volver todo a la normalidad.
        barra[0].removeAttribute('style');
        for(let i=0; i<4; i++)
        {
            links[i].removeAttribute('style');
        }
    }
    else{
        //En caso de que no, despliega el contenido en una columna.
        barra[0].style.flexDirection= 'column';
        barra[0].style.height = '200px';
        barra[0].style.alignItems = 'center';
        barra[0].style.justifyContent = 'flex-start';
        hamburguesa.style.alignSelf = 'flex-end';
        hamburguesa.style.paddingTop = '9px';
        hamburguesa.style.paddingBottom = '9px';
        for(let i=0; i<4; i++)
        {
            linkds[i].style.display = 'flex';
        }
    }

});*/

var ham=document.querySelector("#hamburguesa");
var barra=document.querySelectorAll(".link")
ham.addEventListener("click",()=>{
    document.querySelector(".nav").classList.toggle("navbarMob");
    for(let i=0; i< barra.length;i++){
        barra[i].classList.toggle("barraNMob")
    }
})