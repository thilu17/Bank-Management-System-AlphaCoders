<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (empty($arguments)) {
            return;
        }

        $userRole = session()->get('role');

        if (!in_array($userRole, $arguments)) {
            if ($request->is('json') || strpos($request->getPath(), 'api/') === 0) {
                return service('response')
                    ->setJSON(['error' => 'Forbidden - Insufficient permissions'])
                    ->setStatusCode(ResponseInterface::HTTP_FORBIDDEN);
            }
            return redirect()->to('/dashboard')->with('error', 'You do not have permission to access that page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
