<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->string('status')->default('active')->after('file_url');
            $table->timestamp('revoked_at')->nullable()->after('status');
            $table->text('revoked_reason')->nullable()->after('revoked_at');
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['status', 'revoked_at', 'revoked_reason']);
        });
    }
};