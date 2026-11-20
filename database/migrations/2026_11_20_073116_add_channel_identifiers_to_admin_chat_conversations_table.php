<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('admin_chat_conversations', function (Blueprint $table) {
            $table->string('channel', 20)->default('web');
            $table->string('channel_key', 100)->nullable();
            $table->unique(['user_id', 'channel', 'channel_key'], 'admin_chat_channel_identity_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admin_chat_conversations', function (Blueprint $table) {
            $table->dropUnique('admin_chat_channel_identity_unique');
            $table->dropColumn(['channel', 'channel_key']);
        });
    }
};
