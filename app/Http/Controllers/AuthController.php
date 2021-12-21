<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\MailSend;
use App\Mail\PaswordSend;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    }

    public function loginPost(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        if ($user) {
            if (Auth::user()->status == 1) {
                return redirect('/');
            } else {
                return redirect('/login')->with('error','Akun Belum Di Aktivasi');
            }
        } else {
           return redirect('/login')->with('error','Email Atau Pasword Salah');
        }
    

    }

    public function regist(){
        return view('auth.regist');
    }

    public function registPost(Request $request){
        // dd($request->all());
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|same:konfirmasipassword',
            'konfirmasipassword' => 'required|min:6|same:password'
        ]);

        $user = new User;
        $user->name = $request->nama;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->token = Str::random(60);
        $user->status = 0;
        $user->save();

        // dd($user);

        Mail::to($request->email)->send(new MailSend($user));

        return redirect('login')->with('login','Selamat Akun Berhasil Di Tambahkan Silahkan Cek Email Anda Untuk Aktivasi');
    }

    public function aktivasiAkun($token){
        $user = User::where('token', $token)->first();
        // dd($user);die;

        if ($user->status == 1) {
            return redirect('login')->with('login','Akun Sudah Di Aktivasi');
        } else {
           if ($user) {
            DB::table('users')->where('token', $token)->update([
                'status' => 1,
            ]);
                return redirect('login')->with('login','Akun Berhasil Di Aktivasi');
            } else {
                return redirect('login')->with('error','Ini Bukan Akun Anda');
            }
        }        
    }

    public function lupaPassword(){
        return view('auth.lupapassword');
    }

    public function lupaPasswordPost(Request $request){
        $users = User::where('email', $request->email)->first();
        // dd($user->id);die;

        if ($users) {

            $user = [
                'id' => $users['id'],
                'nama' => $users->name,
                'token' => Str::random(60),
            ];
            // $id = $user->id;
            // dd($id);
            Mail::to($request->email)->send(new PaswordSend($user));
            Cache::put($users->id . ':forgot_password', Str::random(60));
            // $value = Cache::put($id.':forgot_password' => Str::random(60));

            return redirect('lupapassword')->with('login','Silahkan Cek Emial Anda Untuk Merubah Password');
        } else {
            return redirect('lupapassword')->with('error','Email Belum Terdaftar');
        }
    }

    public function passwordBaru(){
        return view('auth.passwordbaru');
    }

    public function ubahPassword($id, $token){
        // dd($id, $token);die;
        if (Cache::has($id. ':forgot_password')) {
            $user = User::find($id);
            // dd($user);die;
            return view('auth.passwordbaru', compact('user'))->with('password','Silahkan Masukan Password Baru');
        }
        else{
            return redirect('login')->with('error','Token Sudah Pernah Di Gunakan');
        }
    }

    public function updatePassword(Request $request, $id){
        $request->validate([
            'password' => 'required|min:6|same:konfirmasipassword',
            'konfirmasipassword' => 'required|min:6|same:password'
        ]);

        DB::table('users')->where('id', $id)->update([
            'password' => bcrypt($request->password),
        ]);

        Cache::forget($id . ':forgot_password', Str::random(60));
        return redirect('/login')->with('login','Password Berhasil Di Ubah');
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/login');
    }
}
