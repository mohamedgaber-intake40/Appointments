<?php

namespace App\Enums;

class UserType
{
	const ADMIN = 0;
	const DOCTOR = 1;
	const PATIENT = 2;

	/**
	 * The user available types.
	 *
	 * @var array
	 */
	public static $types = [
		'Admin',
        'Doctor',
        'Patient'
	];


}

