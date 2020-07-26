<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','username','email','password','last_login_at','status','log_ip'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * delete expire user.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request)
    {
      $allUser = UserStatus::all();
      $currentTime = Carbon::now();
      foreach ($allUser as $key => $value) {
        self::find($value->user_id)->where(['expire_time','=<',$currentTime])->delete();
         }    
    }
}
  