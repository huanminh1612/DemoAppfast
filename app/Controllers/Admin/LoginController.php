<?php

namespace App\Controllers\Admin;

use App\Common\ResultUtils;
use App\Controllers\BaseController;
use App\Services\LoginService;

// Tiếp tục sử dụng lớp 'LoginService' trong mã nguồn của bạn

class LoginController extends BaseController
{
    
    private $service;
    public function __construct()
    {
        $this->service = new LoginService();
    }
    public function index()
    {
        if(session()->has('user_login'))
        {
            return redirect('admin/home');    
        }
        
        return view('admin/pages/login');
    }
    public function login()
    {
        $result = $this->service->hasLoginInfo($this->request);

        if($result['status'] === ResultUtils::STATUS_CODE_OK)
        {
            return redirect('admin/home');
        }
        else if($result['status'] === ResultUtils::STATUS_CODE_ERR)
        {
            return redirect('login')->with($result['messageCode'], $result['messages']);
        }
        return redirect('home');
    }
    public function logout()
    {
        $this->service->logoutUser();
        return redirect('login');
    }
}