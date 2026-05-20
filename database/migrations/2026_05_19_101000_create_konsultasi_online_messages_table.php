<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konsultasi_online_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konsultasi_online_id')->constrained('konsultasi_onlines')->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users')->cascadeOnDelete();
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });

        // Migrate existing chats into the new messages table with zero data loss
        $chats = DB::table('konsultasi_onlines')->get();
        foreach ($chats as $chat) {
            // 1. Save patient's original question
            if (!empty($chat->pesan)) {
                DB::table('konsultasi_online_messages')->insert([
                    'konsultasi_online_id' => $chat->id,
                    'sender_id' => $chat->user_id,
                    'message' => $chat->pesan,
                    'is_read' => !empty($chat->respons),
                    'created_at' => $chat->created_at ?? now(),
                    'updated_at' => $chat->created_at ?? now(),
                ]);
            }

            // 2. Save clinician's original response (if already answered)
            if (!empty($chat->respons)) {
                // Find a clinician belonging to this faskes to attribute the message to
                $nakesUser = DB::table('users')
                    ->where('fasilitas_kesehatan_id', $chat->fasilitas_kesehatan_id)
                    ->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                              ->from('roles')
                              ->whereColumn('roles.id', 'users.roles_id')
                              ->where('roles.nama_role', 'nakes');
                    })
                    ->first();

                $senderId = $nakesUser ? $nakesUser->id : 1; // Fallback to Admin ID 1 if no nakes is registered yet

                DB::table('konsultasi_online_messages')->insert([
                    'konsultasi_online_id' => $chat->id,
                    'sender_id' => $senderId,
                    'message' => $chat->respons,
                    'is_read' => true,
                    'created_at' => $chat->direspons_pada ?? $chat->updated_at ?? now(),
                    'updated_at' => $chat->direspons_pada ?? $chat->updated_at ?? now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasi_online_messages');
    }
};
