# Info Cliente

Aplicación realizada con Slim 3 Framework

## Instalación de la Aplicación

Clonamos el proyecto del repositorio
    git clone https://github.com/cristhianbarros/infoCliente.git
    
Una vez ubicados en la raiz del proyecto ejecutamos el comando para descargar todas las dependencias del proyecto
    composer install

Dentro de la raiz del proyecto ejecutamos el sigiuiente comando para inicializar el servidor local
    php -S localhost:8080 -t public public/index.php
    
Recuerda importar la base de datos unicada en la carpeta src/Model/customer_info.sql
