<?php
function translate_gender($i){
	switch ($i) {
    case "F":
        return "Female";
        break;
    case "M":
        return "Male";
        break;
    case "O":
        return "Other";
        break;
}
}

function translate_occupation($i){
		switch ($i) {
    case "ND":
        return "";
        break;
    case "S":
        return "Student";
        break;
    case "P":
        return "Professional";
        break;
	case "O":
        return "Other";
        break;
}
}

function translate_moveindate(){
	  return date('jS F Y', strtotime($date));
}

function translate_amenities($i){
		switch ($i) {
    case "furnished":
        return "Furnished";
        break;
    case "washing_machine":
        return "Washing machine";
        break;
    case "garden":
        return "Yard/terrace";
        break;
	case "balcony":
        return "Balcony/patio";
        break;
	case "off_street_parking":
        return "Parking";
        break;
	case "garage":
        return "Garage";
        break;
	case "cable and net ready":
        return "Cable and net ready";
        break;
}
}

function translate_smoking($i){
		switch ($i) {
    case 0:
        return "No";
        break;
    case 1:
        return "Yes";
        break;
}
}

function translate_pets($i){
		switch ($i) {
    case 0:
        return "No";
        break;
    case 1:
        return "Yes";
        break;
}
}

function translate_orientation($i){
		switch ($i) {
    case "ND":
        return "";
        break;
    case "S":
        return "Straight";
        break;
    case "G":
        return "Gay/Lesbian";
        break;
	case "B":
        return "Bi-sexual";
        break;
}
}

function translate_genderpref($i){
		switch ($i) {
    case "D":
        return "Don't mind";
        break;
    case "N":
        return "Males or Females";
        break;
    case "M":
        return "Males";
        break;
	case "F":
        return "Females";
        break;
	case "O":
        return "Other";
        break;
}
}

function translate_occupationpref($i){
		switch ($i) {
    case "M":
        return "Don't mind";
        break;
    case "S":
        return "Students";
        break;
    case "P":
        return "Professionals";
        break;
}
}

function translate_smokingpref($i){
		switch ($i) {
    case 1:
        return "Don't mind";
        break;
    case 0:
        return "No thanks";
        break;
}
}

function translate_petspref($i){
		switch ($i) {
    case 1:
        return "Don't mind";
        break;
    case 0:
        return "No thanks";
        break;
}
}

function translate_orientationpref($i){
		switch ($i) {
    case "ND":
        return "Not important";
        break;
    case "S":
        return "Straight";
        break;
    case "G":
        return "Gay/Lesbian";
        break;
	case "B":
        return "Bi-sexual";
        break;
	case "O":
        return "Other";
        break;
}
}

function translate_landlordfee($i){
	$i=explode(',', $i)[0];
		switch ($i) {
    case "None":
        return "Full Fee";
        break;
    case "Half":
        return "Half Fee";
        break;
    case "Full":
        return "No Fee";
        break;
	case "3/4":
        return "Quarter Fee";
        break;
	case "1/4":
        return "3/4 Fee";
        break;
	case "Negotiable":
        return "Negotiable";
        break;
	case "Unknown":
        return "Full Fee";
    break;	
	default:
        return "Full Fee";
			

}
}
function translate_roomforrentprice($price,$beds,$rfr){
	if($rfr == 1) {
		return $price;
	} else{
		return number_format((float) $price/$beds, 2, '.', '');
	}
}
?>