<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use MongoDB\Client;
use Symfony\Component\HttpFoundation\Response;

class LogRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request) (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request); // Primero ejecutamos la petición

        try {
            $uri = $_ENV['MONGODB_URI'] ?? env('MONGODB_URI');
            $database = $_ENV['MONGODB_DATABASE'] ?? env('MONGODB_DATABASE', 'sendio_logs');

            // Verificar que la URI existe
            if (! $uri) {
                error_log('MONGODB_URI no está configurada');

                return $response;
            }

            $client = new Client($uri);
            $collection = $client->selectCollection($database, 'activity_logs');

            $collection->insertOne([
                'level' => 'info',
                'channel' => 'http',
                'message' => 'HTTP Request',
                'context' => [
                    'method' => $request->getMethod(),
                    'url' => $request->fullUrl(),
                    'ip' => $request->ip(),
                    'status' => $response->getStatusCode(),
                ],
                'datetime' => time(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (Exception $e) {
            // Si falla el log, que al menos no rompa la app
            error_log('LogRequests error: '.$e->getMessage());
        }

        return $response;
    }
}
