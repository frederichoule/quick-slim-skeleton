<?php

  use DI\Container;
  use Slim\Factory\AppFactory;
  use Slim\Views\PhpRenderer;

  $container = new Container();
  AppFactory::setContainer($container);

  /* Settings */
  $container->set('settings', function() use ($_settings){
    return $_settings;
  });

  /* PHP View */
  $container->set('phpview', function(){
    $renderer = new PhpRenderer(APP_SRC.'/app/templates');
    return $renderer;
  });
