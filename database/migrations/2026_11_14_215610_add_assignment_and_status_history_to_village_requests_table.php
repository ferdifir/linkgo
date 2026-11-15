<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('village_requests', function (Blueprint $table): void {
            $table->foreignId('assigned_to_user_id')->nullable()->after('target_at')->constrained('users')->nullOnDelete();
        });

        Schema::create('village_request_status_history', function (Blueprint $table): void {
            $table->id();
            $table->string('village_slug')->index();
            $table->foreignId('request_id')->constrained('village_requests')->cascadeOnDelete();
            $table->string('status', 20);
            $table->foreignId('changed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at');
            $table->index(['village_slug', 'request_id', 'created_at']);
        });

        DB::table('village_requests')->orderBy('id')->chunkById(500, function (Collection $requests): void {
            DB::table('village_request_status_history')->insert($requests->map(fn (object $request): array => [
                'village_slug' => $request->village_slug,
                'request_id' => $request->id,
                'status' => $request->status,
                'changed_by_user_id' => null,
                'created_at' => $request->created_at ?? now()->utc()->toDateTimeString(),
            ])->all());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('village_request_status_history');

        Schema::table('village_requests', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('assigned_to_user_id');
        });
    }
};
