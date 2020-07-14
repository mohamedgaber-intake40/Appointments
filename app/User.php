<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'password', 'profileable_type', 'profileable_id','type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
	 * One-to-one relationship to the profile.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 *
	 */
	public function profileable()
	{
		return $this->morphTo();
    }

    /**
	 * One-to-many relationship to the doctorAppointments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

    public function doctorAppointments()
	{
		return $this->hasMany(Appointment::class,'doctor_id');
    }

    /**
	 * One-to-many relationship to the doctorAppointments.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 *
	 */

    public function patientAppointments()
	{
		return $this->hasMany(Appointment::class,'patient_id');
    }

     /**
	 * Has-One-Through relationship to the specialty.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\hasOneThrough
	 *
	 */

    public function specialty()
	{
		return $this->hasOneThrough(Specialty::class,DoctorProfile::class);
    }

}
