<?php

  use Slim\Factory\AppFactory;

  /* Composer Autoload */
  require_once(APP_ROOT . '/vendor/autoload.php');

  /* Settings */
  if(file_exists(APP_ROOT . '/settings.yaml')) {
    $_settings = Symfony\Component\Yaml\Yaml::parseFile(APP_ROOT . '/settings.yaml');
    if(!is_array($_settings)) {
      throw new Exception('Invalid settings.yaml');
    }
  } else {
    throw new Exception('Unable to find settings.yaml');
  }

  /* Locales */
  date_default_timezone_set($_settings['geo']['timezone']);
  setlocale(LC_ALL, $_settings['geo']['locale']);

  /* Autoload Classes */
  spl_autoload_register(function ($resource) {

    $traits_path  = APP_SRC . '/traits/trait.' . strtolower($resource) . '.php';
    $classes_path = APP_SRC . '/classes/class.' . strtolower($resource) . '.php';

    if (file_exists($traits_path)) {
      require_once ($traits_path);
    } elseif (file_exists($classes_path)) {
      require_once ($classes_path);
    } else {
      return false;
    }

  });

  /* Dependencies */
  require_once(APP_SRC.'/core/dependencies.inc.php');

  /* Create the app */
  $app = AppFactory::create();

  /* Middlewares */
  require_once(APP_SRC.'/core/middlewares.inc.php');

  /* Enable error reporting */
  $_errorMiddleware = $app->addErrorMiddleware($_settings['debug'],$_settings['debug'],$_settings['debug']);

  /* Routes */
  require_once(APP_SRC.'/core/routes.inc.php');

  /* Run the app */
  $app->run();