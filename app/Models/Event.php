<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Event as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\User;
class Event extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'title',
        'is_event',
        'start_date',
        'end_date',
        'color',
        'description',
    ];
    public function event(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
       return $this->hasOne(User::class, 'id' ,'user_id');

    }

}
