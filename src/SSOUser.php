<?php

namespace ReliQArts\VanillaSSO;

/**
 *  SSOUser.
 */
class SSOUser
{
    public $id;
    public $name;
    public $email;
    public $roles;
    public $profilePicture;

    public function __construct()
    {
        $this->email = null;
        $this->id = null;
        $this->name = null;
        $this->roles = null;
        $this->profilePicture = '';
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'uniqueid' => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
            'roles'    => $this->roles,
            'photourl' => $this->profilePicture,
        ];
    }
}
