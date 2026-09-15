<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conn = DB::connection(config('database.default', 'odbc'));
        $now = date('Y-m-d H:i:s');
        $hashedPassword = Hash::make('Admin#2019');

        try {
            // 1. Insert Role 1 (Admin) if not exists
            $role = $conn->select("SELECT FIRST * FROM t_roles_bphtb WHERE id = 1");
            if (empty($role)) {
                $conn->statement("INSERT INTO t_roles_bphtb (id, name, description) VALUES (1, 'Admin', 'Administrator Sistem BPHTB')");
                $this->command->info("Role 1 (Admin) berhasil ditambahkan ke t_roles_bphtb.");
            } else {
                $this->command->info("Role 1 (Admin) sudah ada di t_roles_bphtb.");
            }

            // 2. Insert User admin if not exists, or update password
            $user = $conn->select("SELECT FIRST * FROM t_users_bphtb WHERE username = 'admin'");
            $userId = '1';

            if (empty($user)) {
                $conn->statement(
                    "INSERT INTO t_users_bphtb (id, email, username, password_hash, is_active, is_verified, created_at, updated_at) VALUES (?, ?, ?, ?, 1, 1, ?, ?)",
                    [$userId, 'admin@bphtb.go.id', 'admin', $hashedPassword, $now, $now]
                );
                $this->command->info("User 'admin' berhasil ditambahkan ke t_users_bphtb.");
            } else {
                $userId = $user[0]->id;
                $conn->statement(
                    "UPDATE t_users_bphtb SET password_hash = ?, is_active = 1, is_verified = 1, updated_at = ? WHERE username = 'admin'",
                    [$hashedPassword, $now]
                );
                $this->command->info("User 'admin' berhasil diperbarui dengan password Admin#2019.");
            }

            // 3. Mapping user_id <-> role_id
            $userRole = $conn->select("SELECT FIRST * FROM t_user_roles_bphtb WHERE user_id = ? AND role_id = 1", [$userId]);
            if (empty($userRole)) {
                $conn->statement(
                    "INSERT INTO t_user_roles_bphtb (user_id, role_id, created_at) VALUES (?, 1, ?)",
                    [$userId, $now]
                );
                $this->command->info("Mapping Role 1 untuk user 'admin' berhasil ditambahkan ke t_user_roles_bphtb.");
            } else {
                $this->command->info("Mapping Role 1 untuk user 'admin' sudah ada di t_user_roles_bphtb.");
            }
        } catch (\Exception $e) {
            $this->command->error("Gagal melakukan seeding user admin: " . $e->getMessage());
        }
    }
}
