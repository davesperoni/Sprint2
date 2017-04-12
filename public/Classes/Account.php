<?php

/**
 * Created by PhpStorm.
 * User: David Speroni
 * Date: 3/24/2017
 * Time: 1:37 PM
 */
class Account
{
    public function __construct($email, $password) {
        $this->name = $email;
        $this->password = $password;
        $this->lastUpdatedBy = "System";
        $this->lastUpdated = "CURRENT_TIMESTAMP";
    }

    public function getEmail() {
        return $this->name;
    }

    public function getPassword() {
        //$this->password = (password_hash( $this->password, PASSWORD_BCRYPT ));
        return $this->password;
    }

    public function getLastUpdatedBy() {
        return $this->lastUpdatedBy;
    }

    public function getLastUpdated() {
        return $this->lastUpdated;
    }
}