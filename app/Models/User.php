<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class User extends Model
{
    public function addUser($param)
    {
        try {
            DB::table('users')->insert([
                'first_name' => $param['first_name'],
                'last_name' => $param['last_name'],
                'email' => $param['email'],
                'password' => $param['password'],
                'phone_number' => $param['phone_number'],
                'news_letter' => $param['news_letter'],

            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }
    public function getUserEmail($email)
    {
            $email = DB::table('users')
                ->where('email', '=', $email)
                ->pluck('email')
                ->first();

            return $email;
    }
    public function getUserPassword($email)
    {
            $password = DB::table('users')
                ->where('email', '=', $email)
                ->pluck('password')
                ->first();

            return $password;
    }
    public function getUserID($email) {
        $userID = DB::table('users')
            ->where('email', '=', $email)
            ->pluck('id')
            ->first();
        return $userID;
    }
    public function verifyUser($email, $password) {
        $user = DB::table('users')
            ->where('email', '=', $email)
            ->where('password', '=', $password)
            ->pluck('id')
            ->first();
        return $user;

    }

}
