<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{   

    public function index() {
        return view('admin.users.login', ['title' => 'Đăng Nhập']);
    }

    public function store(Request $request) {

        // kiểm tra thông tin input
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required'
        ]);

        // kiểm tra độ chính xác của tài khoản và kiểm tra remember me có check hay k
        if(Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {
            // nếu đúng thông tin thì chuyển trang
            return redirect()->route('admin');
        }

        // nếu sai thông tin thì hiện thông báo & trở lại
        Session::flash('error', 'Email hoặc Password không đúng!');
        return redirect()->back();

    }
}

