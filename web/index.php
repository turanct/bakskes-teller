<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
ErrorHandler::register();
ExceptionHandler::register();

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Teller\Web\ContainerConfiguration());

$app->get('/register', 'RegistrationController:registerForm');
$app->post('/register', 'RegistrationController:register');
$app->get('/register/confirm/{email}/{secret}', 'RegistrationController:confirm');

$app->run();
