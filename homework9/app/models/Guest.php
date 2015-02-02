<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Guest extends Eloquent
{

    protected $table = 'guests';

    protected $hidden = array('joined_party');
    protected $fillable = array('name', 'age', 'gender', 'email');

}
