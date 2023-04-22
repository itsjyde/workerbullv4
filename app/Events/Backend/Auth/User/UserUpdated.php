<?php

namespace App\Events\Backend\Auth\User;

use Illuminate\Queue\SerializesModels;

/**
 * Class UserUpdated.
 */
class UserUpdated
{
    use SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }
}
