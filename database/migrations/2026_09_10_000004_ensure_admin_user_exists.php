<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'phone_number' => '1234567890',
                'role' => 'admin',
                'password' => 'admin123',
            ]
        );
    }

    public function down(): void
    {
        User::where('email', 'admin@example.com')->delete();
    }
};