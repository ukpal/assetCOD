<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $table = 'subscription_master';

    protected $fillable=['title','description','status'];

    public function charges(){
        return $this->hasMany(SubscriptionCharges::class);
    }
}
