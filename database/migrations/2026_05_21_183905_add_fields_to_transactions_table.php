<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('pembeli')->nullable()->after('user_id');
            $table->string('email')->nullable()->after('pembeli');
            $table->string('telepon')->nullable()->after('email');
            $table->string('order_id')->nullable()->after('telepon');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn(['pembeli', 'email', 'telepon', 'order_id']);
        });
    }
};