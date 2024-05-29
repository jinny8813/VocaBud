<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class MemberAuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $identity = session()->get('userData')['identity'] ?? null;
        if ($identity === null) {
            return redirect()->to('/login');
        }else if($identity == "manager"){
            return redirect()->to('/backstage');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
