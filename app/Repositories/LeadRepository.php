<?php
use App\Models\Agent;
use App\Models\User;

/**
 * Created by PhpStorm.
 * User: Дима
 * Date: 26.01.2018
 * Time: 10:03
 */
class LeadRepository extends Repo
{
    public function forUser(Agent  $user)
    {
        return $user->leads();


    }
}