<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstalacionController;
use App\Http\Controllers\Instructor\ProductoInstructorController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocioController;
use App\Http\Controllers\SolicitudSocioController;
use App\Http\Controllers\TiendaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoritoController;
use App\Http\Controllers\Instructor\EquipoInstructorController;
use App\Http\Controllers\Instructor\JugadorInstructorController;
use App\Http\Controllers\Instructor\SocioInstructorController;
use App\Http\Controllers\Instructor\TemporadaInstructorController;
use App\Http\Controllers\Instructor\NoticiaInstructorController;
use App\Http\Controllers\Instructor\PartidoInstructorController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
});

Route::middleware('auth')->group(function () {
    Route::get('/mi-equipo', [SocioController::class, 'show'])->name('socio.show');
    Route::post('/socio/cancelar', [SocioController::class, 'cancelar'])->name('socio.cancelar');
    Route::post('/socio/reactivar', [SocioController::class, 'reactivar'])->name('socio.reactivar');
    // Route::post('/socio', [SocioController::class, 'store'])->name('socio.store');
});

Route::get('/socio', [SocioController::class, 'index'])
    ->name('socio.index');

Route::get('/socio/create', [SocioController::class, 'create'])
    ->name('socio.create');

Route::post('/socio/solicitud', [SolicitudSocioController::class, 'store'])
    ->name('socio.solicitud.store');

Route::get('/contacto', function () {
    return view('layouts.contacto');
})->name('contacto');

Route::post('/contacto/email', [ContactoController::class, 'enviarEmail'])
    ->name('contacto.email');

Route::get('/contacto/email', function () {
    return redirect()->route('contacto');
});

Route::post('/contacto/whatsapp', [ContactoController::class, 'enviarWhatsapp'])
    ->name('contacto.whatsapp');

Route::get('/clasificacion', [ClasificacionController::class, 'index'])
    ->name('clasificacion.index');

Route::get('/calendario', [CalendarioController::class, 'index'])
    ->name('calendario.index');

Route::get('/equipo', [EquipoController::class, 'index'])
    ->name('equipo.index');

Route::get('/instalaciones', [InstalacionController::class, 'index'])
    ->name('instalaciones.index');

Route::get('/noticias', [NoticiaController::class, 'index'])
    ->name('noticias.index');

Route::get('/noticias/{id}', [NoticiaController::class, 'show'])
    ->name('noticias.show');

Route::get('/tienda', [TiendaController::class, 'index'])
    ->name('tienda.index');

Route::get('/tienda/{producto}', [TiendaController::class, 'show'])
    ->name('tienda.show');

Route::middleware('auth')->group(function () {

    Route::post('/favoritos/{id}', [FavoritoController::class, 'toggle'])
        ->name('favoritos.toggle');

    Route::get('/favoritos', [FavoritoController::class, 'index'])
        ->name('favoritos.index');

    Route::get('/carrito', [CarritoController::class, 'index'])
        ->name('carrito.index');

    Route::post('/carrito/solicitar', [CarritoController::class, 'solicitarCompra'])
        ->name('carrito.solicitar');

    Route::post('/carrito/{id}', [CarritoController::class, 'toggle'])
        ->name('carrito.toggle');

    Route::post('/carrito/increase/{id}', [CarritoController::class, 'increase'])
        ->name('carrito.increase');

    Route::post('/carrito/decrease/{id}', [CarritoController::class, 'decrease'])
        ->name('carrito.decrease');

    Route::post('/carrito/remove/{id}', [CarritoController::class, 'remove'])
        ->name('carrito.remove');
});

// PANEL INSTRUCTOR (admin + instructor)
Route::middleware(['auth', 'role:admin,instructor'])->group(function () {

    // Route::get('/panel/instructor', function () {
    //     return view('panel.instructor.dashboard');
    // })->name('panel.instructor');

    // RUTAS SOLICITUDES SOCIO
    Route::get('/panel/instructor/solicitudes', [SolicitudSocioController::class, 'index'])
        ->name('panel.instructor.solicitudes');

    Route::post('/panel/instructor/solicitudes/{id}/aceptar', [SolicitudSocioController::class, 'aceptar'])
        ->name('panel.instructor.solicitudes.aceptar');

    Route::post('/panel/instructor/solicitudes/{id}/rechazar', [SolicitudSocioController::class, 'rechazar'])
        ->name('panel.instructor.solicitudes.rechazar');

    // RUTAS SOCIOS
    Route::get('/panel/instructor/socios', [SocioInstructorController::class, 'index'])
        ->name('panel.instructor.socios');

    Route::put('/panel/instructor/socios/{id}', [SocioInstructorController::class, 'update'])
        ->name('panel.instructor.socios.update');

    Route::delete('/panel/instructor/socios/{id}', [SocioInstructorController::class, 'destroy'])
        ->name('panel.instructor.socios.destroy');

    Route::post('/panel/instructor/socios', [SocioInstructorController::class, 'store'])
        ->name('panel.instructor.socios.store');

    // RUTAS PRODUCTOS
    Route::get('/panel/instructor/productos', [ProductoInstructorController::class, 'index'])
        ->name('panel.instructor.productos');

    Route::post('/panel/instructor/productos', [ProductoInstructorController::class, 'store'])
        ->name('panel.instructor.productos.store');

    Route::put('/panel/instructor/productos/{producto}', [ProductoInstructorController::class, 'update'])
        ->name('panel.instructor.productos.update');

    Route::delete('/panel/instructor/productos/{producto}', [ProductoInstructorController::class, 'destroy'])
        ->name('panel.instructor.productos.destroy');

    // RUTAS EQUIPOS
    Route::get('/panel/instructor/equipos', [EquipoInstructorController::class, 'index'])
        ->name('panel.instructor.equipos');

    Route::post('/panel/instructor/equipos', [EquipoInstructorController::class, 'store'])
        ->name('panel.instructor.equipos.store');

    Route::put('/panel/instructor/equipos/{equipo}', [EquipoInstructorController::class, 'update'])
        ->name('panel.instructor.equipos.update');

    Route::delete('/panel/instructor/equipos/{equipo}/{temporada}', [EquipoInstructorController::class, 'removeFromSeason'])
        ->name('panel.instructor.equipos.remove');

    Route::post('/panel/instructor/temporadas', [TemporadaInstructorController::class, 'store'])
        ->name('panel.instructor.temporadas.store');

    Route::put('/panel/instructor/temporadas/{temporada}', [TemporadaInstructorController::class, 'update'])
        ->name('panel.instructor.temporadas.update');

    Route::delete('/panel/instructor/temporadas/{temporada}', [TemporadaInstructorController::class, 'destroy'])
        ->name('panel.instructor.temporadas.destroy');

    // RUTAS NOTICIAS
    Route::get('/panel/instructor/noticias', [NoticiaInstructorController::class, 'index'])
        ->name('panel.instructor.noticias');

    Route::post('/panel/instructor/noticias', [NoticiaInstructorController::class, 'store'])
        ->name('panel.instructor.noticias.store');

    Route::put('/panel/instructor/noticias/{noticia}', [NoticiaInstructorController::class, 'update'])
        ->name('panel.instructor.noticias.update');

    Route::delete('/panel/instructor/noticias/{noticia}', [NoticiaInstructorController::class, 'destroy'])
        ->name('panel.instructor.noticias.destroy');

    // RUTAS JUGADORES
    Route::get('/panel/instructor/jugadores', [JugadorInstructorController::class, 'index'])
        ->name('panel.instructor.jugadores');

    Route::post('/panel/instructor/jugadores', [JugadorInstructorController::class, 'store'])
        ->name('panel.instructor.jugadores.store');

    Route::put('/panel/instructor/jugadores/{jugador}', [JugadorInstructorController::class, 'update'])
        ->name('panel.instructor.jugadores.update');

    Route::delete('/panel/instructor/jugadores/{jugador}', [JugadorInstructorController::class, 'destroy'])
        ->name('panel.instructor.jugadores.destroy');

    // RUTAS PARTIDOS
    Route::get('/panel/instructor/partidos', [PartidoInstructorController::class, 'index'])
        ->name('panel.instructor.partidos');

    Route::post('/panel/instructor/partidos', [PartidoInstructorController::class, 'store'])
        ->name('panel.instructor.partidos.store');

    Route::put('/panel/instructor/partidos/{partido}', [PartidoInstructorController::class, 'update'])
        ->name('panel.instructor.partidos.update');

    Route::delete('/panel/instructor/partidos/{partido}', [PartidoInstructorController::class, 'destroy'])
        ->name('panel.instructor.partidos.destroy');

});

// PANEL ADMIN (solo admin)
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Route::get('/panel/admin', function () {
    //     return view('panel.admin.dashboard');
    // })->name('panel.admin');

    Route::get('/panel/admin/usuarios', [UserController::class, 'index'])
        ->name('panel.admin.usuarios');

    Route::put('/panel/admin/usuarios/{user}', [UserController::class, 'update'])
        ->name('usuarios.update');

    Route::delete('/panel/admin/usuarios/{user}', [UserController::class, 'destroy'])
        ->name('usuarios.destroy');
});

require __DIR__ . '/auth.php';
