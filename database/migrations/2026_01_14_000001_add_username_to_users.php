<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add username column if it doesn't exist
        if (!Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('username')->nullable()->after('name');
            });
        }

        // For existing users without username, generate one
        $users = User::all();
        foreach ($users as $user) {
            if (empty($user->username)) {
                $user->username = $this->generateUniqueUsername($user->name);
                $user->save();
            }
        }

        // Make username unique and not nullable
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('users', 'username')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('username');
            });
        }
    }

    private function generateUniqueUsername($name)
    {
        $username = Str::slug($name, '');
        $original = $username;
        $count = 1;

        while (User::where('username', $username)->exists()) {
            $username = $original . $count;
            $count++;
        }

        return $username;
    }
};
