<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class ActivityLog extends Model
{
    use HasFactory;



    protected $fillable = [
        'msg',
        'user_id',
        'ip_address',
    ];

    public static function Log($msg, $request)
    {
        $modelActivity = new ActivityLog();
        $modelActivity->user_id = Auth::id();
        $modelActivity->msg = $msg;
        $modelActivity->ip_address = $request->ip(); 
        $modelActivity->save();

        return true;
    }

    
}
