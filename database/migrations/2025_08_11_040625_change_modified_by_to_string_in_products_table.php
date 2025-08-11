<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeModifiedByToStringInProductsTable extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop foreign key constraint dulu
            $table->dropForeign(['modified_by']);
            // Ubah kolom modified_by jadi string
            $table->string('modified_by')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Ubah kolom modified_by balik ke foreignId
            $table->unsignedBigInteger('modified_by')->change();
            // Tambahkan foreign key constraint lagi
            $table->foreign('modified_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
