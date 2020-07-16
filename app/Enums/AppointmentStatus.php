<?php

namespace App\Enums;

class AppointmentStatus
{
	const WAITING = 0;
	const DOCTOR_REFUSE = 1;
	const PATIENT_REFUSE = 2;
	const BOTH_REFUSE = 3;
	const ACCEPTED = 4;

	/**
	 * The user available status.
	 *
	 * @var array
	 */
	public static $statuses = [
		'Waiting for Schedule',
        'Doctor Refuse',
        'Patient Refuse',
        'Both Refuse',
        'Accepted'
	];


}

