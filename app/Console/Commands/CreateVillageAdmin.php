<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

#[Signature('admin:create-village-admin')]
#[Description('Create an administrator account for one village')]
class CreateVillageAdmin extends Command
{
    public function handle(): int
    {
        $name = trim((string) $this->ask('Administrator name'));
        $username = trim((string) $this->ask('Username'));
        $email = trim((string) $this->ask('Email'));
        $villageSlugs = DB::table('village_pages')->orderBy('name')->pluck('slug')->all();

        if ($name === '' || ! preg_match('/^[a-zA-Z0-9._-]{3,60}$/', $username)
            || ! filter_var($email, FILTER_VALIDATE_EMAIL) || $villageSlugs === []) {
            $this->error('Nama, username, email, atau data desa tidak valid.');

            return self::FAILURE;
        }

        if (User::query()->where('username', $username)->orWhere('email', $email)->exists()) {
            $this->error('Username atau email sudah digunakan.');

            return self::FAILURE;
        }

        $villageSlug = $this->choice('Village', $villageSlugs);
        $password = (string) $this->secret('Password');
        $passwordConfirmation = (string) $this->secret('Confirm password');
        if (strlen($password) < 12 || ! hash_equals($password, $passwordConfirmation)) {
            $this->error('Password harus minimal 12 karakter dan konfirmasinya harus sama.');

            return self::FAILURE;
        }

        User::query()->create([
            'name' => $name,
            'username' => $username,
            'email' => Str::lower($email),
            'password' => $password,
            'is_admin' => true,
            'village_slug' => $villageSlug,
        ]);

        $this->info("Admin $username berhasil dibuat untuk desa $villageSlug.");

        return self::SUCCESS;
    }
}
