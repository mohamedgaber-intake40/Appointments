<?php

namespace App\Enums;

class UserType
{
	const ADMIN = 0;
	const DOCTOR = 1;
	const PATIENT = 2;

	/**
	 * The user available genders.
	 *
	 * @var array
	 */
	public static $genders = [
		'Admin',
        'Doctor',
        'Patient'
	];


}

