<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\LogRecord;
use MongoDB\Client;

class MongoHandler extends AbstractProcessingHandler
{
    protected $collection;

    public function __construct($level = \Monolog\Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        // Conexión usando las variables de entorno
        try {
            $client = new Client(env('MONGODB_URI'));
            $database = env('MONGODB_DATABASE', 'sendio_logs');
            $this->collection = $client->selectCollection($database, 'activity_logs');
        } catch (\Exception $e) {
            error_log("MongoHandler constructor error: " . $e->getMessage());
            throw $e;
        }
    }

    protected function write(LogRecord $record): void
    {
        try {
            if (!$this->collection) {
                error_log("MongoHandler: collection not initialized");
                return;
            }

            $this->collection->insertOne([
                'level' => $record->level->name,
                'level_code' => $record->level->value,
                'channel' => $record->channel,
                'message' => $record->message,
                'context' => $record->context,
                'extra' => $record->extra,
                'datetime' => $record->datetime->getTimestamp(),
            ]);
        } catch (\Exception $e) {
            // Log fallback si hay error
            error_log("MongoHandler Error: " . $e->getMessage());
        }
    }
}
