<?php

namespace App\Http\Controllers;
//input library
use Illuminate\Http\Request;
use Auth;
use App\User;
//end input library

class UserController extends Controller
{
    function login(Request $request){
        $email = $request->input('email');
        $password = $request->input('password');

        //return $email . " " . $password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            // Authentication passed...
            return redirect()->intended('/dashboard');
        }else{
            return 'username atau password salah';
        }
    }

    function register(Request $request){
        //dd($request);

        //Cek Email
        $email = $request->email;//ambil request email , buatkan variabel email
        if($email == null){
            return 'email kosong';
        }
        //Cek Nama
        $nama = $request->nama;//ambil request nama , buatkan variabel nama
        if($nama == null){
            return 'nama kosong';
        }
        //Cek Password 
        $password = $request->password;//ambil request password , buatkan variabel password
        if($password == null){
            return 'Password kosong';
        }
        //Cek Password Confirm 
        $password_confirm = $request->password_confirm;//ambil request password confirm , buatkan variabel  passord confirm
        if($password_confirm == null){
            return 'Password Confirm kosong';
        }
        //Cek Validasi Password 
        //tidak dibuat lagi karena sudah dibuat di variabel global password dan password confirm
        if($password != $password_confirm){
            return 'Password tidak sama';
        }
        

        $data = User::where('email',$email)->first();
        if($data != null){
            return 'email sudah ada';
        }
        $user = new User();
        $user->email = $email;
        $user->name = $nama;
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $id = $user->id;
        Auth::loginUsingId($id);

        return redirect('dashboard');
    }


}
