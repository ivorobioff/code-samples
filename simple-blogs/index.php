<?php
session_start();

spl_autoload_register(function($class){
	require_once __DIR__.'/'.$class.'.php';
});

$action_method = isset($_REQUEST['a']) ?  $_REQUEST['a'] : 'index';

unset($_REQUEST['a']);

$controller_object = new Controller();

if (!method_exists($controller_object, $action_method))
{
	return null;
}

call_user_func(array($controller_object, $action_method));