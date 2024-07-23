<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Platform_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('platform_name');
            $table->string('ign');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Platform_connections');
    }
};
