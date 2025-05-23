<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('cassie_id')->nullable()->after('id');
            $table->string('cassie_access_token')->nullable()->after('cassie_id');
        });
    }
};
