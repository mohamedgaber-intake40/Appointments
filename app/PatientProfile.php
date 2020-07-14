<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PatientProfile extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'mobile','birthdate','gender','country','occupation'
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
