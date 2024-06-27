<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('is_highlighted')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('is_highlighted');
        });
    }
    
};
