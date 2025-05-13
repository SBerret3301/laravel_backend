<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameMotDePasseToPasswordInUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            // تغيير اسم العمود من "mot_de_passe" إلى "password"
            $table->renameColumn('mot_de_passe', 'password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('utilisateurs', function (Blueprint $table) {
            // إعادة الاسم إلى "mot_de_passe" في حال أردنا التراجع
            $table->renameColumn('password', 'mot_de_passe');
        });
    }
}
