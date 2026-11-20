<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('admin:link-telegram {username} {telegram_user_id}')]
#[Description('Tautkan ID Telegram privat ke akun admin aktif.')]
class LinkAdminTelegram extends Command
{
    public function handle(): int
    {
        $telegramUserId = filter_var($this->argument('telegram_user_id'), FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]);

        if ($telegramUserId === false) {
            $this->error('ID Telegram harus berupa bilangan bulat positif.');

            return self::FAILURE;
        }

        $admin = User::query()
            ->where('username', $this->argument('username'))
            ->where('is_admin', true)
            ->where('is_active', true)
            ->first();

        if (! $admin) {
            $this->error('Akun admin aktif tidak ditemukan.');

            return self::FAILURE;
        }

        if (DB::table('users')->where('telegram_user_id', $telegramUserId)->where('id', '<>', $admin->id)->exists()) {
            $this->error('ID Telegram tersebut sudah ditautkan ke akun lain.');

            return self::FAILURE;
        }

        $admin->telegram_user_id = $telegramUserId;
        $admin->save();

        $this->info('ID Telegram berhasil ditautkan ke akun '.$admin->username.'.');

        return self::SUCCESS;
    }
}
