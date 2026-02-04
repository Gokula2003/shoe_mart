<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate a strong random password
        $password = 'Admin@2026!Secure#' . Str::random(8);
        
        // Update or create admin
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@shoemart.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make($password),
                'failed_attempts' => 0,
                'locked_until' => null,
            ]
        );
        
        // Display the generated password (only during seeding)
        echo "\n========================================\n";
        echo "Admin Account Created/Updated Successfully!\n";
        echo "========================================\n";
        echo "Email: admin@shoemart.com\n";
        echo "Password: {$password}\n";
        echo "========================================\n";
        echo "IMPORTANT: Save this password securely!\n";
        echo "========================================\n\n";
    }
}
