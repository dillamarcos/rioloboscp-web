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

Para ejecutar este proyecto en cualquier ordenador, sigue los siguientes pasos.

---

### 1. Requisitos previos

Antes de comenzar, es necesario instalar:

- **XAMPP** (incluye PHP y MySQL de forma sencilla, aunque se puede instalar MySQL Server)  
  https://www.apachefriends.org/

- **Composer** (gestor de dependencias de PHP)  
  https://getcomposer.org/

- **Node.js** (para compilar el frontend)  
  https://nodejs.org/

---

### 2. Iniciar entorno local

Abrir **XAMPP** y arrancar:

- Apache
- MySQL

---

### 3. Obtener el proyecto

#### Opción A: ZIP (entrega del proyecto)
Descomprimir el archivo en una carpeta del equipo.

```bash
cd proyecto_riolobos_cp
```

#### Opción B: GitHub
```bash
git clone https://github.com/dillamarcos/rioloboscp-web.git
cd rioloboscp-web
```

---

### 4. Instalar dependencias del backend

```bash
composer install
```

---

### 5. Instalar dependencias del frontend

```bash
npm install
```

---

### 6. Configurar variables de entorno

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

En entornos locales con XAMPP, el usuario `root` no tiene contraseña por defecto.

---

### 7. Crear la base de datos

Acceder a:

```
http://localhost/phpmyadmin
```

Y crear una base de datos llamada:

```
riolobos_cp
```

---

### 8. Generar clave de la aplicación

```bash
php artisan key:generate
```

---

### 9. Ejecutar migraciones y datos de prueba

```bash
php artisan migrate --seed
```

---

### 10. Compilar assets del frontend

```bash
npm run dev
```

---

### 11. Iniciar servidor Laravel

```bash
php artisan serve
```

---

### 12. Acceder a la aplicación

Abrir en el navegador:

```
http://127.0.0.1:8000
```

---

### 13. Usuario de prueba (administrador)

El sistema incluye datos de prueba generados con seeders.

Usuario administrador:

- **Nombre:** Prueba  
- **Apellidos:** Soy Prueba  
- **Email:** prueba@gmail.com  
- **Contraseña:** 12345678  
- **Rol:** admin  

📌 También es posible registrarse como nuevo usuario desde la aplicación.

---