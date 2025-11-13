<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan setelah kolom id, nullable sementara supaya seeding/registrasi tidak error
            $table->foreignId('role_id')->nullable()->after('id')->constrained('roles')->nullOnDelete();
            // buat index untuk pencarian cepat jika perlu
            $table->index('role_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // drop fk dan kolom
            $table->dropForeign([$table->getTable().'_role_id_foreign'] ?? ['role_id_foreign']);
            $table->dropIndex([$table->getTable().'_role_id_index'] ?? ['role_id_index']);
            $table->dropColumn('role_id');
        });
    }
};
