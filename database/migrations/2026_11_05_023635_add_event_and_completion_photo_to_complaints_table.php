
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')
                ->nullable()
                ->after('reporter_id');

            $table->string('completion_photo_path')
                ->nullable()
                ->after('photo_path');

            $table->index('event_id');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropIndex(['event_id']);
            $table->dropColumn([
                'event_id',
                'completion_photo_path',
            ]);
        });
    }
};
