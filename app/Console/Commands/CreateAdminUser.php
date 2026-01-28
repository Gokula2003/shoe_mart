<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--name= : The name of the admin user}
                            {--email= : The email of the admin user}
                            {--password= : The password for the admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new admin user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating Admin User...');
        $this->newLine();

        // Get name
        $name = $this->option('name') ?? $this->ask('Enter admin name');

        // Get email
        $email = $this->option('email') ?? $this->ask('Enter admin email');

        // Validate email
        $validator = Validator::make(['email' => $email], [
            'email' => 'required|email|unique:admins,email'
        ]);

        if ($validator->fails()) {
            $this->error('Validation Error:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('- ' . $error);
            }
            return Command::FAILURE;
        }

        // Get password
        $password = $this->option('password') ?? $this->secret('Enter admin password (min 8 characters)');

        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return Command::FAILURE;
        }

        // Confirm password
        if (!$this->option('password')) {
            $passwordConfirmation = $this->secret('Confirm password');
            if ($password !== $passwordConfirmation) {
                $this->error('Passwords do not match.');
                return Command::FAILURE;
            }
        }

        // Create admin
        try {
            $admin = Admin::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->newLine();
            $this->info('✓ Admin user created successfully!');
            $this->newLine();
            $this->table(
                ['Field', 'Value'],
                [
                    ['ID', $admin->id],
                    ['Name', $admin->name],
                    ['Email', $admin->email],
                    ['Created At', $admin->created_at],
                ]
            );

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to create admin user: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
