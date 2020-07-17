<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class DoctorProfile extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'specialty_id','firstname', 'lastname','email'
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

     /**
	 * One-to-One- relationship to the specialty.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\belongsTo
	 *
	 */

    public function specialty()
	{
		return $this->belongsTo(Specialty::class);
    }

}
