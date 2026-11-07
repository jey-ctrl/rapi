
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Menambahkan status approved dan rejected,
        // serta mempertahankan status lama over.
        DB::statement("
            ALTER TABLE events
            MODIFY status ENUM(
                'pending',
                'approved',
                'rejected',
                'over'
            ) NOT NULL
        ");

        // Admin belum tentu menyetujui saat pengajuan dibuat.
        DB::statement("
            ALTER TABLE events
            MODIFY approve_by BIGINT UNSIGNED NULL
        ");

        // Alasan pemindahan hanya diisi ketika ruangan dipindahkan.
        DB::statement("
            ALTER TABLE events
            MODIFY move_reason TEXT NULL
        ");
    }

    public function down(): void
    {
        // Periksa apakah data masih memungkinkan rollback.
        $hasNewStatus = DB::table('events')
            ->whereIn('status', ['approved', 'rejected'])
            ->exists();

        $hasNullApproval = DB::table('events')
            ->whereNull('approve_by')
            ->exists();

        $hasNullMoveReason = DB::table('events')
            ->whereNull('move_reason')
            ->exists();

        if ($hasNewStatus || $hasNullApproval || $hasNullMoveReason) {
            throw new RuntimeException(
                'Rollback dibatalkan agar data peminjaman tidak hilang.'
            );
        }

        DB::statement("
            ALTER TABLE events
            MODIFY status ENUM('pending', 'over') NOT NULL
        ");

        DB::statement("
            ALTER TABLE events
            MODIFY approve_by BIGINT UNSIGNED NOT NULL
        ");

        DB::statement("
            ALTER TABLE events
            MODIFY move_reason TEXT NOT NULL
        ");
    }
};
