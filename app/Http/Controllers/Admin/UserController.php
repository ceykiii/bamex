<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Permission;
use App\User;
use Illuminate\Http\Request;
use App\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use DataTables;
use Validator;
use Hash;

class UserController extends Controller
{

    public function addUser()
    {
        $allRole = Role::all();
        $allPermission = Permission::all();
        return view("admin.user_add", ["roles" => $allRole , 'permissions' => $allPermission]);
    }

    public function addUserPost(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'required|min:6',
            'roles' =>'required'
        ],
            [
                'name.required' => 'İsim Alanı Zorunludur',
                'name.min' => 'İsim Alanı Minumum 5 Karakter Olmalı',
                'password.required' => 'Şifre Alanı Zorunludur',
                'password.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'password.password_confirmation' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password_confirmation.required' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'password.required_with' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password.same' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password_confirmation.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'roles.required'=> 'Kullanıcı Bir Role Sahip Olmalıdır',
                'email.unique' => 'Bu Mail Adresi Daha Önce Kullanılmıştır'
            ]
        );

        $name = $request->post("name");
        $email = $request->post("email");
        $passsword = $request->post("password");
        $roles  = $request->post("roles");
        $permissions = $request->post("permission");

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = bcrypt($passsword);
        if($user->save()) {
            $lastUserId = $user->id;
            $roleInsert = [];
            foreach ($roles as $role) {
                array_push($roleInsert, [
                    "user_id" => $lastUserId,
                    "role_id" => $role
                ]);
            }

            $addRoles = DB::table('users_roles')->insert($roleInsert);
            if(!$addRoles){
                return Redirect::back()->withErrors(['msg' => 'Sistemsel Bir Hata Oluştu 0001']);
            }

            if(count($permissions) > 0 ) {
                $permissionInsert = [];
                foreach ($permissions as $permission) {
                    array_push($permissionInsert, [
                        "user_id" => $lastUserId,
                        "permission_id" => $permission
                    ]);
                }
                $addPermission = DB::table('users_permissions')->insert($permissionInsert);
                if(!$addPermission){
                    return Redirect::back()->withErrors(['msg' => 'Sistemsel Bir Hata Oluştu 0002']);
                }
            }

            return redirect()->back()->withSuccess('Kullanıcı Başarılı Bir Şekilde Eklendi');
        }else{
            return Redirect::back()->withErrors(['msg' => 'Sistemsel Bir Hata Oluştu 0003']);
        }

    }

    public function userList()
    {
        return view("admin.user_list");
    }

    public function userData(Request $request)
    {
        if($request->ajax()) {
            $data = User::where("id","<>",Auth::user()->id)->latest()->get();
            return DataTables::of($data)
                ->addColumn('action',function ($data){
                    $button = '<a href ="'.route("admin.user.edit" ,["id" => $data->id]).'" type = "button" name="edit" id = "$data->id" class="edit btn btn-primary">Düzenle</a>';
                    return $button;
                })
            ->rawColumns(["action"])->make(true);
        }
    }

    public function userEdit($id)
    {
        $user = User::find($id);
        $userRole = User::find($id)->roles()->get()->pluck('id','name')->toArray();
        $allRole = Role::all()->pluck('id','name')->toArray();
        $diffRole = array_diff($allRole, $userRole);
        $userPermission = User::find($id)->permission()->get()->pluck('id','name')->toArray();
        $allPermission = Permission::all()->pluck('id','name')->toArray();
        $diffPermission = array_diff($allPermission, $userPermission);
        $data = [
            'user' => $user,
            'userRole' => $userRole,
            'diffRole' => $diffRole,
            'userPermission' => $userPermission,
            'diffPermission' => $diffPermission
        ];

        return view("admin.user_edit", $data);
    }

    public function userEditPost(Request $request)
    {

        $userId = $request->post("userId");
        $this->validate($request, [
            'name' => 'required|min:5|max:50',
            'email' => 'required', 'email', \Illuminate\Validation\Rule::unique('users')->ignore($userId),
            'password' => 'required_with:password_confirmation|same:password_confirmation',
            'roles' =>'required'
        ],
            [
                'name.required' => 'İsim Alanı Zorunludur',
                'name.min' => 'İsim Alanı Minumum 5 Karakter Olmalı',
                'password.required' => 'Şifre Alanı Zorunludur',
                'password.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'password.password_confirmation' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password_confirmation.required' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'password.required_with' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password.same' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
                'password_confirmation.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
                'roles.required'=> 'Kullanıcı Bir Role Sahip Olmalıdır',
                'email.unique' => 'Bu Mail Adresi Daha Önce Kullanılmıştır'
            ]
        );


        $user = User::find($userId);
        $user->name = $request->post("name");
        $user->email = $request->post("email");
        if(!is_null($request->post("password"))){
            $user->password = bcrypt($request->post("password"));
        }
        if($user->save()){
            // Delete Roles
            DB::table('users_roles')->where("user_id","=", $userId)->delete();
            $roleInsert = [];
            $roles = $request->post("roles");
            foreach ($roles as $role) {
                array_push($roleInsert, [
                    "user_id" => $userId,
                    "role_id" => $role
                ]);
            }
            DB::table('users_roles')->insert($roleInsert);
            /*--------------------------------------------------------*/
            // Delete Permission
            DB::table('users_permissions')->where("user_id","=", $userId)->delete();
            $permissions = $request->post("permission");
            $permissionInsert = [];
            foreach ($permissions as $permission) {
                array_push($permissionInsert, [
                    "user_id" => $userId,
                    "permission_id" => $permission
                ]);
            }
           DB::table('users_permissions')->insert($permissionInsert);
           return redirect()->back()->withSuccess('Kullanıcı Başarılı Bir Şekilde Güncellendi');
        }else{
            return Redirect::back()->withErrors(['msg' => 'Sistemsel Bir Hata Oluştu 0004']);
        }

    }

    public function userChangePassword()
    {
        return view("admin.user_change_password");
    }

    public function userChangePasswordPost(Request $request)
    {
        if(Auth::Check())
        {
            $request_data = $request->All();
            $validator = $this->admin_credential_rules($request_data);
            if($validator->fails())
            {
                return Redirect::back()->withErrors($validator)->withInput();
            }
            else
            {
                $current_password = Auth::User()->password;
                if(Hash::check($request_data['current-password'], $current_password))
                {
                    $user_id = Auth::User()->id;
                    $obj_user = User::find($user_id);
                    $obj_user->password = Hash::make($request_data['password']);
                    $obj_user->save();
                    return redirect()->back()->withSuccess('Şifre Başarılı Bir Şekilde Değiştirildi');
                }
                else
                {
                    return Redirect::back()->withErrors(['msg' => "Lütfen Doğru Şifre Giriniz"]);
                }
            }
        }
        else
        {
            return redirect()->to('/');
        }
    }

    public function admin_credential_rules(array $data)
    {
        $messages = [
            'current-password.required' => 'Lütfen Mevcut Şifrenizi Giriniz',
            'password.required' => 'Please enter password',
            'password.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
            'password.password_confirmation' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
            'password_confirmation.required' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
            'password.required_with' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
            'password_confirmation.same' => 'Girmiş Olduğunuz Şifreler Aynı Olmalı',
            'password_confirmation.min' => 'Şifre Alanı Minumum 6 Karakter Olmalı',
        ];

        $validator = Validator::make($data, [
            'current-password' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ], $messages);

        return $validator;
    }

}
