# API Rest con Lumen

Servicio web que hace uso de la API pública [Go REST](https://gorest.co.in/)

## Instalación
Instalar las dependencia de composer


```bash
composer install
```

Copiar el archivo .env.example a .env

Registrarse en [Go REST](https://gorest.co.in/) y obtener su "Access Tokens"

En el archivo .env creado anteriormente, se dede ingresar las variables de entorno respectivas:
```PHP
API_KEY = YOUR_API_KEY
URL_API_USER = URL_API_GO_REST
```

Estando en el proyecto clonado, podemos levantar el entorno con el siguiente comando:
```bach
php -S localhost:8000 -t public
```


## Endpoints (Usamos Postman)
1. [GET]
   * /usuarios - Lista todos los usuarios
   * /usuarios?nombre="" - Obtiene usuario por nombre
   * /usuarios?email="" - Obtiene usuario por email
   * /usuarios?activos=true/false - Obtiene los usuarios activos o inactivos

2. [POST]
   * /usuarios - Crear usuarios (Recibe como parámetro un json)
```json
{
  "nombre": "",
  "email": "",
  "genero": female or male,
  "activo": true or false
}
``` 

3. [PUT]
   * /usuarios{id} - Actualiza todos los datos de un usuario  (Recibe como parámetro el id del usuarios a actualizar y un json con todos los valores del registro modificados)
```json
{
   "nombre": "",
   "email": "",
   "genero": female or male,
   "activo": true or false
}
```

4. [PATCH]
   * /usuarios/{id} - Actualiza parcialmente los datos de un usuario (Recibe como parámetros el id del usuario a actualizar y un json con los datos que se quieran modificar)
```json
{
   "nombre": "",
   "email": "",
   "genero": female or male,
   "activo": true or false
}
```