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
        'password', 
        'email_verified',
        'magic_link_token',
        'token_expires',
        'created_at',
        'updated_at'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $dateFormat = 'datetime';
    
    public function generateMagicLinkToken()
    {
        return bin2hex(random_bytes(32));
    }
    
    public function isTokenValid($token)
    {
        $user = $this->where('magic_link_token', $token)
                    ->where('token_expires >', date('Y-m-d H:i:s'))
                    ->first();
        
        return $user ? $user : false;
    }
    
    public function verifyEmail($userId)
    {
        return $this->update($userId, [
            'email_verified' => 1,
            'magic_link_token' => null,
            'token_expires' => null
        ]);
    }
}