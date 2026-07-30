<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel lama jika ada, lalu buat ulang dari bersih
        Schema::dropIfExists('organizers');

        Schema::create('organizers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('logo')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved');
            $table->timestamps();
        });

        // Tambahkan relasi organizer_id ke tabel Users jika belum ada
        if (!Schema::hasColumn('users', 'organizer_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('organizer_id')->nullable()->constrained('organizers')->onDelete('cascade');
            });
        }

        // Tambahkan relasi organizer_id ke tabel Events jika belum ada
        if (!Schema::hasColumn('events', 'organizer_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignId('organizer_id')->nullable()->constrained('organizers')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn('organizer_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['organizer_id']);
            $table->dropColumn('organizer_id');
        });

        Schema::dropIfExists('organizers');
    }
};