<?php 

function check_empty_fields($required_fields_arrey) {
	$form_errors = array();

	// Loop through the required fields array
	foreach ($required_fields_arrey as $name_of_field) {
		if(!isset($_POST[$name_of_field]) || $_POST[$name_of_field] == NULL){
			$form_errors[] = $name_of_field . " is a required field";
		}
	}

	return $form_errors;
}

function check_min_length($fields_to_check_length) {
	$form_errors = array();

	foreach ($fields_to_check_length as $name_of_field => $minimum_length_required) {
		if( strlen(trim($_POST[$name_of_field])) < $minimum_length_required) {
			$form_errors[] = $name_of_field . " is to short, must be {$minimum_length_required} charackters long";
		}
	}

	return $form_errors;
}

function check_email($data) {
	// initialize an array to store error messages
	$form_errors = array();
	$key = "email";
	// check if the key email exists in data array
	if(array_key_exists($key, $data)) {
		// check if the email field has a value
		if($_POST[$key] != null) {
			$key = filter_var($key, FILTER_SANITIZE_EMAIL);

			if(filter_var($_POST[$key], FILTER_VALIDATE_EMAIL) === false) {
				$form_errors[] = $key . " is not valid email address";
			}
		}
	}
	return $form_errors;
}

function show_errors($form_errors_array) {
	$errors = "<ul style='color: red;'>";

	foreach ($form_errors_array as $the_error) {
		$errors .= "<li>{$the_error}</li>";
	}
	$errors .= "</ul></p>";
	return $errors;
}