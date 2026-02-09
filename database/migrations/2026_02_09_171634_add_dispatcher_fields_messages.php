<?php


    use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            $table->foreignId('dispatcher_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('openphone_message_id')->unique();

            $table->string('direction'); // inbound/outbound

            $table->timestamp('sent_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {

            $table->dropForeign(['dispatcher_id']);
            $table->dropColumn([
                'dispatcher_id',
                'openphone_message_id',
                'direction',
                'sent_at'
            ]);

        });
    }
};
