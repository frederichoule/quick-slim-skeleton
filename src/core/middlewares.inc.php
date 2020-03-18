<?php

  use Psr\Http\Message\ServerRequestInterface as Request;
  use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
  use Slim\Psr7\Response;

  $app->addBodyParsingMiddleware();

  $app->add(function (Request $request, RequestHandler $handler) {
    $uri = $request->getUri();
    $path = $uri->getPath();

    if ($path != '/' && substr($path, -1) == '/') {
        $uri = $uri->withPath(substr($path, 0, -1));

        if ($request->getMethod() == 'GET') {
            $response = new Response();
            return $response
                ->withHeader('Location', (string) $uri)
                ->withStatus(301);
        } else {
            $request = $request->withUri($uri);
        }
    }

    return $handler->handle($request);
  });

  $app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    'path' => [],
    'realm' => 'Private',
    'users' => [
      'root' => 't00r',
    ]
  ]));