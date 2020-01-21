<?php

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;

  $app->map(['GET','POST'],'/', function (Request $request, Response $response, $args) {

    $params = $request->getQueryParams();
    
    require_once(APP_SRC.'/core/head.inc.php');
    require_once(APP_SRC.'/app/controllers/hello.php');
    
    return $renderer->render($response, 'hello.html', $render_parameters);
    
  });
