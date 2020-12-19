<?php

Class DbConnection{
	private $pdo;
    function __construct() {

	}
	
	public function connect(){
		       //This file will connect to the database and contain common queries
$host = '';
$db   = '';
$user = '';
$pass = '';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

 $this->$pdo = new PDO($dsn, $user, $pass, $opt);
	}
	
public function getdbconnect(){
        return $this->$pdo;
    }

}
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
function translate_roomforrentprice($price,$beds,$rfr){
	if($rfr == 1) {
		return $price;
	} else{
		return number_format((float) $price/$beds, 2, '.', '');
	}
}
?>