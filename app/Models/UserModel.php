<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'username',
        'full_name',
        'email',
        'company',
        'password',
        'email_verified',
        'magic_link_token',
        'token_expires',
        'status',
        'last_login',
        'login_count',
        'timezone',
        'profile_image',
        'role',
        'preferences',
        'created_at',
        'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    protected $useSoftDeletes = true;
    
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
        'full_name' => 'required|min_length[2]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'company' => 'permit_empty|max_length[255]',
        'status' => 'permit_empty|in_list[active,inactive,suspended]',
        'role' => 'permit_empty|in_list[user,admin,moderator]'
    ];
    
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
    
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }
    
    public function verifyMagicLink($token)
    {
        $user = $this->where('magic_link_token', $token)
                    ->where('token_expires >', date('Y-m-d H:i:s'))
                    ->first();
        
        if ($user) {
            // Clear the token after verification
            $this->update($user['id'], [
                'magic_link_token' => null,
                'token_expires' => null,
                'email_verified' => 1,
                'status' => 'active',
                'last_login' => date('Y-m-d H:i:s')
            ]);
            
            return $user;
        }
        
        return null;
    }

    public function isTokenValid($token)
    {
        $user = $this->where('magic_link_token', $token)
                    ->where('token_expires >', date('Y-m-d H:i:s'))
                    ->first();
        
        return $user ? $user : false;
    }

}