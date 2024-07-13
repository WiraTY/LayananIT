<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgrammerModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password_hash', 'active', 'created_at', 'updated_at'];
    protected $returnType = 'array';

    public function getProgrammers()
    {
        $builder = $this->db->table($this->table)
                            ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
                            ->where('auth_groups_users.group_id', 2)
                            ->select('users.*');

        return $builder->get()->getResultArray();
    }
}
