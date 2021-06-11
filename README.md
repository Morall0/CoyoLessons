# PROYECTO FINAL CW2021

## COYOLESSONS

### Integrantes del equipo: 

* Alan Mauricio Morales López
* Melissa Natalia Archundia Tapia
* Alexa Flores Madero Campos
* Janeth Irandy Reyes Herrera

### Guía de instalación del proyecto

1. Insatalación de XAMPP:
   * Si aún no tienes instalado XAMPP, es necesario buscar en yu navegador la dirección https://www.apachefriends.org/es/index.html para instala la versión 7.4.19 de XAMPP.
   * Después, dirigete a esta ubicación en tu línea de comandos C:\xampp\htdocs y crea una carpeta en la que se guardarán tus repositorios.
   * En la línea de comandos, dirigete a la ubicacion C:\xampp\htdocs + nombre de la carpeta que creaste, después utiliza el comando git clone con el link:                                https://github.com/Maurici0ML/CoyoLessons.git.
   * Con esto deberías contar con todos los archivos necesarios para el uso de CoyoLessons.
   
2. Uso de base de datos:
   

3. Guía de configuración del proyecto:
    * Una vez hecha la instalación de XAMPP y de haber clonado el repositorio correctamente, tendrás que buscar entre tus aplicaciones XAMPP y activar la opción de Apache             dandole click al botón junto a la palabra Apache. También deberás activar la opción de MySQL.  
    * Nuevamente, dirigete a tu navegador y busca la dirección localhost/nombre_de_tu_carpeta_de_repositorios/CoyoLessons/index.html.
    * Al seguir los pasos anteriores, deberás poder usar la página web de CoyoLessons. 

3. Características del proyecto
    * Esta es una página creada con el fin de ayudar a los estudiantes de prepa 6 a conseguir mejores notas.
    * La página cuenta con 5 vistas: Principal, Inicio de sesión, Perfil, Historial, Créditos y Administración.
    * En la vista de principal se encuentran los filtros de búsqueda y la parte de agendar o cancelar una asesoría. Inicio es la parte en la que podrás crear una cuenta o usar         tus datos para entrar en el caso de ya tener una cuenta. Perfil contiene los datos dados en tu registro, las asesorías que agendasre, las clases que tienes pendientes, los       temas que dominas y los horarios en los que estás disponible. Para entrar a historial tienes que ingresar primero tu perfil y buscar esa opción, ahí podrás ver las               asesorías que ya tomaste. En créditos está la informacón de los creadores de la página. Para poder ingresar a administración se necesita tener una cuenta especial, la           razón es que en este apartado se encuentra información importante y de mucho cuidado.
  
  4. Comentarios adicionales a su proyecto.
      Para poder usar correctamente la pagina web de CoyoLessons primero tienes que instalar la base de datos, sigue los siguientes pasos:
        * Busca el archivo llamado "coyolessons.sql" y cópialo 
        * Regresa a la carpeta xampp e ingresa a "mysql\bin", una vez dentro, pega el archivo
        * Abre tu consola presionando la tecla Windows y la tecla R, escribe cmd y da click en aceptar
        * Una vez en tu consola copia y pega la siguiente ruta: "C:\xampp\mysql\bin", después, presiona enter
        * Copiay pega: "mysql -u root" en la consola para entrar a las bases de datos y presiona enter
        * Después copia y pega la siguiente sentencia: "USE mysql", presiona enter
        * Copia y pega "CREATE USER 'coyolessons'@'localhost' IDENTIFIED BY 'c0yol3$$0nS?';", nuevamente presiona enter
        * Luego copia y pega "GRANT ALL PRIVILEGES ON coyolessons.* TO 'coyolessons'@'localhost';"
        * Presiona las teclas "ctrl" y "c" al mismo tiempo, debe aparecer un mensaje diciendo "Bye"
        * Estando en la ruta "C:\xampp\mysql\bin" escribe mysql -u coyolessons -p, te pedirá una contraseña, escribirás manualmente lo siguiente: "c0yol3$$0nS?" y darás enter             (esto es para verificar que el usuario esté creado)
        * Una vez hecha la verificación copia y pega lo siguiente: "CREATE DATABASE coyolessons CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci" para crear tu base de datos
        * Presiona nuevamente "ctrl" y "c" para salir de las bases de datos
        * Ahora copia y pega la sentencia: "mysql -u coyolessons -p coyolessons<coyolessons.sql" para pasar los datos del archivo sql a la base de datos que recién creaste (te             volverá a pedir la contraseña, escribela manualmente)
        * Ahora copia y pega "mysql -u coyolessons -p" para volver a entrar a las bases de datos
        * Una vez ahí escribe "SHOW DATABASES;", debe aparecer una tabla y dentro de debe de estar tu base de datos llamada "coyolessons"
      
      
      ¡Listo! Ya tienes tu base de datos y lo necesario para utilizar correctamente la página web
