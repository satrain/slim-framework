<?php

declare(strict_types=1);

use DI\Container;

return function (Container $container) {
    $container->set('settings', function() {
       return [
           'name' => 'Slim & SWAPI App',
           'displayErrorDetails' => true,
           'logErrorDetails' => true,
           'logErrors' => true,
           'views' => [
             'path' => __DIR__ . '/../src/Views',
             'settings' => ['cache' => false],
           ],
       ];
    });
};
