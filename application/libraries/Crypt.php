<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crypt {

    public function salt()
    {
        return substr(sha1(mt_rand()), 0, 22);
    }

    public function generate_password($password, $salt)
    {
        return crypt($password, '$2a$10$' . $salt);
    }

    public function check_password($hash, $password)
    {
        $new_hash  = crypt($password, $hash);

        return ($hash == $new_hash);
    }

}
?>