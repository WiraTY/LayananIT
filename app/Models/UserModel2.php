<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel2 extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $allowedFields = ['nama_user', 'password', 'role'];

    public function getUserByUsername($username)
    {
        return $this->where('nama_user', $username)
                    ->first();
    }
}
