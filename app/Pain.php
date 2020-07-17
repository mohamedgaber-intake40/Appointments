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
	 * Many-to-One relationship to the specialty.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 *
	 */

    public function specialty()
	{
		return $this->belongsTo(Specialty::class);
    }
}
