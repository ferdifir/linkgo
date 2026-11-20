<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('admin:link-whatsapp {username} {phone_number}')]
#[Description('Tautkan nomor WhatsApp privat ke akun admin aktif.')]
class LinkAdminWhatsApp extends Command
{
    public function handle(): int
    {
        $phoneNumber = preg_replace('/\D/', '', (string) $this->argument('phone_number'));

        if (! is_string($phoneNumber) || preg_match('/^\d{8,15}$/', $phoneNumber) !== 1) {
            $this->error('Nomor WhatsApp harus ditulis dengan kode negara, 8 sampai 15 digit.');

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

        if (DB::table('users')->where('whatsapp_user_id', $phoneNumber)->where('id', '<>', $admin->id)->exists()) {
            $this->error('Nomor WhatsApp tersebut sudah ditautkan ke akun lain.');

            return self::FAILURE;
        }

        $admin->whatsapp_user_id = $phoneNumber;
        $admin->save();

        $this->info('Nomor WhatsApp berhasil ditautkan ke akun '.$admin->username.'.');

        return self::SUCCESS;
    }
}
