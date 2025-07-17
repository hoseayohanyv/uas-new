<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authHeader = $request->getHeaderLine('Authorization');

        if (!$authHeader || !str_contains($authHeader, 'Bearer ')) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Authorization header not found']);
        }

        $token = str_replace('Bearer ', '', $authHeader);

        if (!$token) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Token is missing']);
        }

        try {
            $secretKey = config('JWT')->secretKey;
            $decoded = JWT::decode($token, new Key($secretKey, 'HS256')); 

            
            $request->user = $decoded;

            return; 
        } catch (\Exception $e) {
            return Services::response()
                ->setStatusCode(401)
                ->setJSON(['error' => 'Invalid or expired token', 'details' => $e->getMessage()]); // ✅ Tambah detail error (optional)
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu aksi di after filter untuk auth
    }
}
