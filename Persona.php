<?php
class Persona {

  public $name;
  public $username;
  public $password;

  public function __construct($name,$username, $password){
    $this->name=$name;
    $this->username=$username;
    $this->password=$password;
  }
}