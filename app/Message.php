<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /**
     * Fields that are mass assignable.
     *
     * @var $fillable
     */
    protected $fillable = [
        'message'
    ];

    /**
     * Message belongs to user
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
