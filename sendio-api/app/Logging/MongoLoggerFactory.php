<?php

namespace App\Logging;

class MongoLoggerFactory
{
    public function __invoke(array $config): MongoHandler
    {
        $level = \Monolog\Logger::toMonologLevel($config['level'] ?? 'debug');
        return new MongoHandler($level);
    }
}
