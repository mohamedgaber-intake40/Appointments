<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
	 * One-to-Many relationship to the Doctor Profiles.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasMany
	 *
	 */

    public function doctorProfiles()
	{
		return $this->hasMany(DoctorProfile::class);
    }

     /**
	 * One-to-many relationship to the pains.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

    public function pains()
	{
		return $this->hasMany(Pain::class);
	}
}
