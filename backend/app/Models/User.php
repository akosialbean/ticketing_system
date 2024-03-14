<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'u_fname',
        'u_lname',
        'u_mname',
        'u_department',
        'u_role',
        'u_username',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function checkAdmin(){
        return User::where('u_username', 'wmcadmin')->count();
    }

    public function createAdminAccount($admin){
        return User::create($admin);
    }

    public function firstLogin($user, $hash){
        return User::where('id', $user['id'])->update([
            'password' => $hash,
            'u_firstlogin' => 2,
            'updated_at' => now()
        ]);
    }

    public function checkUsername($newuser){
        return User::where('u_username', 'LIKE', '%' . $newuser['u_username'] . '%')->count();
    }

    public function addUser($newuser){
        return User::create($newuser);
    }

    public function getUsersList(){
        return User::join('departments', 'users.u_department', '=', 'departments.d_id')
        ->orderby('users.id', 'desc');
    }

    public function viewUser($userid){
        return User::where('id', $userid)
        ->join('departments', 'users.u_department', 'departments.d_id')
        ->first();
    }
    public function checkOldPassword($user){
        return Auth::attempt([
            'id' => $user['id'],
            'password' => $user['old_password'],
        ]);
    }

    public function updatePassword($user, $hashed){
        return User::where('id', $user['id'])
            ->update([
                'password' => $hashed,
                'updated_at' => now()
            ]);
    }

    public function disableUser($user){
        return User::where('id', $user['id'])
        ->update([
            'u_status' => 2,
            'updated_at' => now(),
        ]);
    }

    public function reactivateUser($user){
        return User::where('id', $user['id'])
        ->update([
            'u_status' => 1,
            'updated_at' => now(),
        ]);
    }

    public function resetPassword($user, $hashed){
        return User::where('id', $user['id'])
            ->update([
                'password' => $hashed,
                'u_firstlogin' => 1,
                'updated_at' => now(),
            ]);
    }

    public function updateUserProfile($user){
        return User::where('id', $user['id'])
            ->update([
                'u_fname' => $user['u_fname'],
                'u_lname' => $user['u_lname'],
                'u_mname' => $user['u_mname'],
                // 'u_username' => $user['u_username'],
                'u_email' => $user['u_email'],
                'u_role' => $user['u_role'],
                'u_department' => $user['u_department'],
                'updated_at' => now(),
            ]);
    }

    public function searchUser($searchitem){
        return User::where('users.id', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('users.u_fname', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('users.u_lname', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('users.u_mname', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->orwhere('users.u_username', 'LIKE', '%' . $searchitem['searchitem'] . '%')
            ->join('departments', 'users.u_department', '=', 'departments.d_id')
            ->orderby('users.id', 'desc')->get();
    }

    public function updateUsername($id, $user){
        return User::where('id', $id)
            ->update([
                'u_username' => $user['u_username'],
                'updated_at' => now()
            ]);
    }
}
