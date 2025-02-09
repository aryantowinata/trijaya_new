<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**  
     * Run the migrations.  
     *  
     * @return void  
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('foto_profile')->nullable()->comment('URL atau path ke foto profil pengguna');
        });
    }

    /**  
     * Reverse the migrations.  
     *  
     * @return void  
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('foto_profile');
        });
    }
};
