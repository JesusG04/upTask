<?php

require_once __DIR__ . '/../includes/app.php';

use Controllers\LoginController;
use Controllers\DashboardController;
use Controllers\TareaController;
use MVC\Router;

$router = new Router();

//Login
$router->get('/', [LoginController::class, 'login']);
$router->post('/', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);
$router->get('/logout', [LoginController::class, 'logout']);

//Crear Cuenta
$router->get('/create-account', [LoginController::class, 'create']);
$router->post('/create-account', [LoginController::class, 'create']);

// Recuperar password
$router->get('/forget', [LoginController::class, 'forget']);
$router->post('/forget', [LoginController::class, 'forget']);

//Colocar el nuevo password
$router->get('/recover', [LoginController::class, 'recover']);
$router->post('/recover', [LoginController::class, 'recover']);

//Confirmacion de cuenta
$router->get('/message', [LoginController::class, 'message']);
$router->get('/confirm', [LoginController::class, 'confirm']);

//Zona de proyectos
$router->get('/dashboard', [DashboardController::class, 'index']);
$router->get('/new-project', [DashboardController::class, 'new_project']);
$router->post('/new-project', [DashboardController::class, 'new_project']);
$router->get('/project', [DashboardController::class, 'project']);
$router->get('/profile', [DashboardController::class, 'profile']);
$router->post('/profile', [DashboardController::class, 'profile']);
$router->get('/change-password', [DashboardController::class, 'change_password']);
$router->post('/change-password', [DashboardController::class, 'change_password']);

//Api para las tareas
$router->get('/api/tasks', [TareaController::class, 'index']);
$router->post('/api/task', [TareaController::class, 'create']);
$router->post('/api/task/update', [TareaController::class, 'update']);
$router->post('/api/task/delete', [TareaController::class, 'delete']);



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();
