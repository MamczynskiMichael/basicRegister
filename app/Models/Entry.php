<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Entry extends Model
{
    public function checkAllowedEntry($userID) {
        $lastEntry = DB::table('entries')
            ->where('users_id', '=', $userID)
            ->pluck('timestamp')
            ->last();
        if ($lastEntry == null) {
            return true;
        }
        $lastEntryTime = strtotime($lastEntry);
        $currentTime = time();
        if(($currentTime-$lastEntryTime) > 86400) { //24 hours in seconds 
            return true;
        } else {
            return false;
        }
    }
    public function addEntry($userID) {
        try {
            DB::table('entries')->insert(
                array('users_id' => $userID));
        } catch (\Illuminate\Database\QueryException $ex) {
            dd($ex->getMessage());
        }
    }
}
