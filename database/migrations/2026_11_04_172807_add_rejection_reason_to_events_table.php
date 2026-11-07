<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom alasan penolakan pada tabel events.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('rejection_reason')
                  ->nullable()
                  ->after('status');
        });
    }

    /**
     * Menghapus kolom alasan penolakan jika migration di-rollback.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};