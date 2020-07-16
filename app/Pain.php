<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pain extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','specialty_id'
    ];

    /**
	 * One-to-many relationship to the appointments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

    public function appointments()
	{
		return $this->hasMany(Appointment::class);
    }

    /**
	 * One-to-many relationship to the specialties.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

    public function specialty()
	{
		return $this->belongsTo(Specialty::class);
    }
}
