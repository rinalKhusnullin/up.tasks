<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) 
{

	$routes->get('/', new PublicPageController('/local/modules/up.tasks/views/tasks-list.php'));
	$routes->get('/tasks/', new PublicPageController('/local/modules/up.tasks/views/tasks-list.php'));
	$routes->get('/tasks', new PublicPageController('/local/modules/up.tasks/views/tasks-list.php'));

	$routes->get('/task/{taskId}/', new PublicPageController('/local/modules/up.tasks/views/tasks-detailed.php'))->where('taskId', '[0-9]+');
	$routes->post('/task/{taskId}/', new PublicPageController('/local/modules/up.tasks/views/tasks-detailed.php'))->where('taskId', '[0-9]+');
};