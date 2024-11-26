use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvolucradosTable extends Migration
{
    public function up()
    {
        Schema::create('involucrados', function (Blueprint $table) {
            $table->bigIncrements('id'); // Clave primaria
            $table->unsignedBigInteger('denuncia_id'); // Clave foránea
            $table->string('nombre');
            $table->string('cargo')->nullable();
            $table->string('entidad')->nullable();
            $table->string('dni_ruc')->nullable();
            $table->timestamps(); // Campos created_at y updated_at

            // Definir la clave foránea
            $table->foreign('denuncia_id')->references('id')->on('denuncias')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('involucrados');
    }
}
