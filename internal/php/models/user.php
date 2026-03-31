<?php
namespace Models;

use Model;

class User extends Model
{
    // Explicitly mapping to 'users' table in SQL
    public static $_table = "users";
}
