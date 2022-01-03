<?php

require __DIR__ .'/../../../../../logic/bootstrap.php';

use App\App;
use DI\Container;

$container = new Container();
$app = $container->get(App::class);
$app->route('stats');
