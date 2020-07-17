<?php

namespace App;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'patient_id','doctor_id', 'date','pain_id','is_patient_refuse','is_doctor_refuse'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
    */
    protected $appends = ['status'];
    protected $casts = [
		'date' => 'datetime'
	];

    /**
	 * Many-to-one relationship to the patient.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function patient()
	{
		return $this->belongsTo(User::class, 'patient_id');
	}

	/**
	 * Many-to-one relationship to the doctor.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function doctor()
	{
		return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
	 * Many-to-one relationship to the doctor.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 *
	 */
	public function pain()
	{
		return $this->belongsTo(Pain::class);
    }

    public function getStatusAttribute()
    {
       $status=AppointmentStatus::ACCEPTED;
        if(!$this->date)
            $status = AppointmentStatus::WAITING;
        else if($this->is_doctor_refuse && $this->is_patient_refuse)
            $status = AppointmentStatus::BOTH_REFUSE;
        else if($this->is_doctor_refuse )
            $status = AppointmentStatus::DOCTOR_REFUSE;
        else if($this->is_patient_refuse)
            $status = AppointmentStatus::PATIENT_REFUSE;

        return $status;
    }


}
