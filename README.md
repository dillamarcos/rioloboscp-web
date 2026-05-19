# Riolobos CP - Web de gestión deportiva
Proyecto TFG desarrollado con Laravel para la gestión y difusión del club Riolobos C.P.

## Tecnologías utilizadas
- Laravel PHP
- Blade
- HTML
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

Para ejecutar este proyecto en cualquier ordenador, sigue los siguientes pasos.

---

### 1. Requisitos previos

Antes de comenzar, es necesario instalar:

- **Composer** (gestor de dependencias de PHP)  
  https://getcomposer.org/

- **Node.js** (para compilar el frontend)  
  https://nodejs.org/

- **MySQL Server** o un entorno como **XAMPP**  
  https://www.mysql.com/  
  https://www.apachefriends.org/


### 2. Obtener el proyecto

```bash
git clone https://github.com/dillamarcos/rioloboscp-web.git
cd rioloboscp-web
```

Una vez clonado el repositorio, abrir el proyecto en VS Code. (Puedes ejecutar los próximos comandos desde su consola).

---

### 3. Instalar dependencias del backend

```bash
composer install
```

---

### 4. Instalar dependencias del frontend

```bash
npm install
```

---

### 5. Configurar variables de entorno

Copiar el archivo de ejemplo:

```bash
copy .env.example .env
```

Editar el archivo `.env`:

```env
DB_DATABASE=riolobos_cp
DB_USERNAME=root
DB_PASSWORD=
```

En entornos locales, el usuario `root` no suele tener contraseña.

---

### 6. Crear la base de datos

Crear una base de datos llamada:

```
riolobos_cp
```

Esto puede hacerse desde herramientas como phpMyAdmin, DBeaver o MySQL Workbench

---

### 7. Generar clave de la aplicación

```bash
php artisan key:generate
```

---

### 8. Ejecutar migraciones y datos de prueba

#### Opción A:

Si se quieren rellenar las tablas con datos de ejemplo:

```bash
php artisan migrate --seed
```

#### Opción B:

En caso de no utilizar migraciones, se puede importar directamente el archivo `.sql` incluido en el proyecto.

Este archivo se encuentra en la carpeta:

`scriptsql_riolobos/riolobos_cp.sql`

---

### 9. Compilar assets del frontend

```bash
npm run dev
```

---

### 10. Iniciar servidor Laravel

```bash
php artisan serve
```

---

### 11. Acceder a la aplicación

Abrir en el navegador:

```
http://127.0.0.1:8000
```

---

### 12. Usuario de prueba (administrador)

El sistema incluye datos de prueba generados con seeders.

Usuario administrador:

- **Nombre:** Prueba  
- **Apellidos:** Soy Prueba  
- **Email:** prueba@gmail.com  
- **Contraseña:** 12345678  
- **Rol:** admin  

📌 También es posible registrarse como nuevo usuario desde la aplicación.

---

### 13. Permisos (si falla la carga de assets)

En algunos entornos puede ser necesario ejecutar:

```bash
php artisan storage:link