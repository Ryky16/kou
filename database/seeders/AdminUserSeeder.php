<?php

use App\Models\User;

User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'role_id' => 1, // 1 = Administrateur
]);

User::create([
    'name' => 'Secrétaire Municipal',
    'email' => 'secretaire@example.com',
    'password' => bcrypt('password'),
    'role_id' => 2, // 2 = Secrétaire Municipal
]);

User::create([
    'name' => 'Agent',
    'email' => 'agent@example.com',
    'password' => bcrypt('password'),
    'role_id' => 3, // 3 = Agent
]);
