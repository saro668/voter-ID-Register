<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

 
class Voter extends Model
{
    use HasFactory;

    const MALE = 1;
    const FEMALE = 2;
    const OTHER = 3;
 
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'mobile',
        'email',
        'address',
        'taluk',
        'district_id',
        'state_id',
        'voter_identification_number',
        'gender',
        
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($voter) {
            $voter->voter_identification_number = str_pad(mt_rand(1, 99999999), 8, '0', STR_PAD_LEFT); // Generates an 8-digit unique ID
        });
    }

    public static function getCountGenderBased($type) {
        return self::where('gender', $type)->count();
    }

    public static function getCount() {
        return self::count();
    }

    public static function getTodayRegisterVoteCount()
    {
        // Get the current date
        $today = Carbon::today();

        // Count votes created today
        $todayVotesCount = self::whereDate('created_at', $today)->count();

        return $todayVotesCount;
    }
}