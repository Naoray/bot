<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TravelCard extends Model
{
	/**
	 * @var array
	 */
    protected $guarded = [];

    /**
     * [user description]
     * @return [type] [description]
     */
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
