<?php

namespace App\Http\Controllers\Admin;

use App\EnumHelpers\EnumRoles;
use App\EnumHelpers\EnumViewPageAdmin;
use App\Enums\EnumViewPage;
use App\Helpers\CustomHelper;
use App\Http\Controllers\BaseAdminController;
use App\Models\HistLoginLog;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseAdminController
{

    public function __construct()
    {
    }

    public function index(){
        try {
            if(Auth::check()){
                $this->clearLogout();
            }
            
            $result = [];
            return view(EnumViewPageAdmin::LOGIN)->with($result);
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(EnumViewPageAdmin::ERROR, $th);
        }
    }

    public function actionLogin(Request $request){
        try {
            if(Auth::check()){
                return redirect()->route('admin.dashboard.index');
                die();
            }

            $rules = [
                'email' => 'required',
                'password' => 'required|min:8'
            ];

            $messages = [];
            $customAtrributes = [];

            $validator = Validator::make($request->all(),$rules, $messages, $customAtrributes);

            if(count($validator->errors()) > 0){
                $sts_msg = [
                    'status' => 0,
                    'message' => 'Mohon isi data'
                ];
                return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
                die();
            }

            $user = User::where('email', $request->input('email'))->first();
            if(!$user){
                $sts_msg = [
                    'status' => 0,
                    'message' => 'silakan isi data dengan benar'
                ];
                return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
                die();
            }

            if(!$user->is_active){
                $sts_msg = [
                    'status' => 0,
                    'message' => 'Data tidak aktif'
                ];
                return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
                die();
            }

            $salt_password = CustomHelper::saltPassword($request->password);
            $check = [
                'email' => $request->email,
                'password' => $salt_password,
                'is_active' => true
            ];
        
            $isSuccessLoginArr = HistLoginLog::where('user_id', $user->id)->select('is_success_login','login_date_php', 'login_time_php')->orderBy('login_date_php', 'desc')->limit(3)->get();
            $falseCount = 0;
            foreach ($isSuccessLoginArr ?? [] as $item) {
                if($item['is_success_login'] == false) $falseCount = $falseCount + 1;
            }

            if($falseCount == 3){
                $marginTime = time() - $isSuccessLoginArr[0]['login_time_php'];
                if($marginTime <= 300){
                    $sts_msg = [
                        'status' => 0,
                        'message' => 'Password gagal 3x, silakan menunggu '.$marginTime.' detik lagi'
                    ];
                    return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
                    die();
                }
            }

            // $ip = $_SERVER['REMOTE_ADDR'];      
            $ip = $request->getClientIps()[0];        

            if(Auth::attempt($check)){                                  

                //save to history
                $sesi = [
                    'id' => Str::uuid(),
                    'user_id' => $user->id,
                    'login_date_php' => now(),
                    'login_time_php' => time(),
                    'ip_address' => $ip,
                    'is_success_login' => true,
                    'created_by' => $user->id
                ];
                $sesiAdmin = HistLoginLog::create($sesi);

                $user['last_login_date'] = now();
                $user['last_access_date'] = now();
                $user->save();
                
                Auth::login($user);
                $request->session()->regenerate();
                session(['time_session' => time()]);
                session(['login_for_page' => CustomHelper::_LOGIN_FOR_PAGE_ADMIN]);
                session(['sesi_login_id' => $sesiAdmin->id]);
                session(['using_role_id' => $user->default_role_id]);

                return redirect()->route('admin.dashboard.index');
                exit();
            }            

            $sesi = [
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'login_date_php' => now(),
                'login_time_php' => time(),
                'ip_address' => $ip,
                'is_success_login' => false,
                'created_by' => $user->id
            ];
            $sesiAdmin = HistLoginLog::create($sesi);

            $sts_msg = [
                'status' => 0,
                'message' => 'silakan isi data dengan benar'
            ];
            return redirect()->route('admin.login.index')->with(['sts_msg' => $sts_msg])->send();
            die();
        } catch (\Throwable $th) {
            return CustomHelper::returnViewWithErrorException(EnumViewPageAdmin::ERROR, $th);
        }
    }


}
