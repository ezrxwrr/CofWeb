<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->bigIncrements('id_menu');        // bigint(20) primary
            $table->string('nama_item', 100);         // varchar(100)
            $table->text('deskripsi')->nullable();    // text
            $table->bigInteger('harga');              // bigint
            $table->decimal('pax', 5, 2);            // decimal(5,2)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};