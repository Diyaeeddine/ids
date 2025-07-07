<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGardiensTable extends Migration
{
    public function up()
    {
        Schema::create('gardiens', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('cin_pass')->nullable();
            $table->string('tel')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gardiens');
    }
}
?>