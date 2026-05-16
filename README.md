# Riolobos CP - Web de gestión deportiva
Proyecto TFG desarrollado con Laravel para la gestión y difusión del club Riolobos C.P.

## Tecnologías utilizadas
- Laravel
- Blade
- Tailwind CSS
- Alpine.js
- MySQL

## Funcionalidades
- Gestión de usuarios
- Calendario de partidos
- Clasificación
- Datos del club
- Tienda de productos del equipo
- Noticias del club
- Socios

## Autor
Proyecto desarrollado por Marcos Dillana Rodríguez
IES Virgern de la Paloma - DAM (Desarrollo de Aplicaciones Multiplataforma)

## Instalación y puesta en marcha del proyecto

Para poder ejecutar este proyecto en cualquier ordenador es necesario seguir los siguientes pasos.

### 1. Instalar programas necesarios y descomprimir ZIP

Antes de empezar, es necesario descomprimir el zip en una carpeta del equipo e instalar:

- **XAMPP** (incluye PHP y MySQL de forma sencilla)
  https://www.apachefriends.org/

- **Composer** (gestor de dependencias de PHP)
  https://getcomposer.org/

- **Node.js** (para compilar el frontend)
  https://nodejs.org/


### 2. Iniciar XAMPP

Abrir XAMPP y arrancar:
- Apache
- MySQL

### 3. Entrar en la carpeta del proyecto o clonarlo (en caso de hacerlo desde GitHub)

Abrir una terminal dentro de la carpeta descomprimida:

cd proyecto_riolobos_cp

En caso de Github:

git clone https://github.com/dillamarcos/rioloboscp-web.git

cd rioloboscp-web


### 4. Instalar dependencias de PHP

composer install

### 5. Instalar dependencias de Node.js

npm install

### 6. Configurar el archivo .env

Copiar el archivo de ejemplo:

copy .env.example .env

Después abrir el archivo `.env` y configurar la base de datos:

DB_DATABASE=riolobos_cp
DB_USERNAME=root
DB_PASSWORD=


### 7. Crear la base de datos

Entrar en:
http://localhost/phpmyadmin

Y crear una base de datos con el nombre:

riolobos_cp


### 8. Generar la clave de la aplicación

php artisan key:generate


### 9. Ejecutar migraciones y datos de prueba

php artisan migrate --seed


### 10. Compilar el frontend

npm run dev


### 11. Iniciar el servidor

php artisan serve


### 12. Acceder a la web

Abrir en el navegador:

http://127.0.0.1:8000

### 13. Navegación dentro de la web

Al ejecutar los seeders se crean campos de prueba en la base de datos, hay un usuario creado en modo admin para poder comprobar el funcionamiento de la web,
cuando inicie sesión tenga en cuenta los siguientes datos:

    'nombre' => 'Prueba',
    'apellidos'=> 'Soy Prueba',
    'email' => 'prueba@gmail.com',
    'telefono' => '111111111',
    'rol' => 'admin',
    'password' => Hash::make('12345678')

O sino puede registrarse como un usuario nuevo.
