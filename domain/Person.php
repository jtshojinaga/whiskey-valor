<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHC-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>, Sam Roberts, Allen Tucker
 * @version 3/28/2008, revised 7/1/2015
 */


class Person {

	private $id; // (username)
	private $start_date; // (dete of account creation)
	private $first_name;
	private $last_name;
	private $street_address;
	private $city;
	private $state;
	private $zip_code;
	private $phone1;
	private $age; // if they're over or under 21
	private $phone1type;
	private $emergency_contact_phone;
	private $emergency_contact_phone_type;
	private $birthday;
	private $email;
	private $email_prefs;
	private $emergency_contact_first_name;
	private $contact_num;
	private $emergency_contact_relation;
	private $contact_method;
	private $type;
	private $status;
	private $notes;
	private $password;
	private $affiliation;
	private $branch;
	private $archived;
	private $emergency_contact_last_name;
	private $access_level;

	function __construct(
        $id, $start_date, $first_name, $last_name, $street_address, $city, $state,
		$zip_code, $phone1, $age, $phone1type, $emergency_contact_phone,
		$emergency_contact_phone_type, $birthday, $email, $email_prefs,
		$emergency_contact_first_name, $contact_num, $emergency_contact_relation,
		$contact_method, $type, $status, $notes, $password, $affiliation, $branch, $archived,
		$emergency_contact_last_name) {
        $this->id = $id;
		$this->start_date = $start_date;
		$this->first_name = $first_name;
		$this->last_name = $last_name;
		$this->street_address = $street_address;
		$this->city = $city;
		$this->state = $state;
		$this->zip_code = $zip_code;
		$this->phone1 = $phone1;
		$this->age = $age;
		$this->phone1type = $phone1type;
		$this->emergency_contact_phone = $emergency_contact_phone;
		$this->emergency_contact_phone_type = $emergency_contact_phone_type;
		$this->birthday = $birthday;
		$this->email = $email;
		$this->email_prefs = $email_prefs;
		$this->emergency_contact_first_name = $emergency_contact_first_name;
		$this->contact_num = $contact_num;
		$this->emergency_contact_relation = $emergency_contact_relation;
		$this->contact_method = $contact_method;
		$this->type = $type;
		$this->status = $status;
		$this->notes = $notes;
		$this->password = $password;
		$this->affiliation = $affiliation;
		$this->branch = $branch;
		$this->archived = $archived;
		$this->emergency_contact_last_name = $emergency_contact_last_name;

        #$this->access_level = ($id == 'vmsroot') ? 3 : 1;

    }

    /*function get_is_new_volunteer() {
        return $this->is_new_volunteer;
    }

    function get_is_community_service_volunteer() {
        return $this->is_community_service_volunteer;
    }

    //YALDA DID THIS.
    function get_total_hours_volunteered() {
    	return $this->total_hours_volunteered;
   }*/

	function get_id() {
		return $this->id;
	}

	function get_start_date() {
		return $this->start_date;
	}

	function get_first_name() {
		return $this->first_name;
	}

	function get_last_name() {
		return $this->last_name;
	}

	function get_over_21() {
		return $this->age;
	}


	function get_street_address() {
		return $this->street_address;
	}

	function get_city() {
		return $this->city;
	}

	function get_state() {
		return $this->state;
	}

	function get_zip_code() {
		return $this->zip_code;
	}

	function get_phone1() {
		return $this->phone1;
	}

	function get_phone1type() {
		return $this->phone1type;
	}

	function get_email() {
		return $this->email;
	}

	function get_email_prefs() {
		return $this->email_prefs;
	}

	function get_affiliation() {
		return $this->affiliation;
	}

	function get_branch() {
		return $this->branch;
	}

	function get_emergency_contact_first_name() {
		return $this->emergency_contact_first_name;
	}

	function get_emergency_contact_last_name() {
		return $this->emergency_contact_last_name;
	}

	function get_emergency_contact_phone() {
		return $this->emergency_contact_phone;
	}

	function get_emergency_contact_phone_type() {
		return $this->emergency_contact_phone_type;
	}

	function get_birthday() {
		return $this->birthday;
	}


	function get_contact_num() {
		return $this->contact_num;
	}

	function get_emergency_contact_relation() {
		return $this->emergency_contact_relation;
	}

	function get_contact_method() {
		return $this->contact_method;
	}

	//function get_photo_release_notes() {
	//	return $this->photo_release_notes;
	//}

	function get_type() {
		return $this->type;
	}

	function get_status() {
		return $this->status;
	}

	function get_notes() {
		return $this->notes;
	}

	function get_password() {
		return $this->password;
	}

	function get_archived() {
		return $this->archived;
	}

	function get_access_level() {
		$access = ($this->id == 'vmsroot') ? 3 : 1;
		return $access;
	}

}