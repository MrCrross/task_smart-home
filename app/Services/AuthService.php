<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param $data
     * @return array
     */
    public function login($data){
        $user = User::checkName($data->name);
        if(!$user || !Hash::check($data->password,$user->password)){
            return [
                'success'=>false,
                'message'=>'Не верный логин или пароль.'
            ];
        }
        $token = $user->createToken('qweqwe123')->plainTextToken;
        return [
            'success'=>true,
            'user'=>$user,
            'token'=>$token
        ];
    }
}
