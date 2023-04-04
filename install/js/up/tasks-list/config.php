<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

return [
	'css' => 'dist/tasks-list.bundle.css',
	'js' => 'dist/tasks-list.bundle.js',
	'rel' => [
		'main.core',
	],
	'skip_core' => false,
];