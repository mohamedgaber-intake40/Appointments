<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'specialty_id','firstname', 'lastname',
    ];

    /**
	 * One-to-one relationship to the user.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphOne
	 *
	 */
	public function user()
	{
		return $this->morphOne(User::class, 'profileable');
	}

}
