// database/migrations/xxxx_xx_xx_create_demandeurs_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandeursTable extends Migration
{
    public function up()
    {
        Schema::create('demandeurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('cin_pass', 20)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('passeport', 50)->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('demandeurs');
    }
}
?>