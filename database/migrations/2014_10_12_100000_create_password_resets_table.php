<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->bigIncrements('password_reset_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id','user_id_fk')
                  ->references('user_id')->on('users')
                  ->onDelete('restrict')
                  ->onUpdate('no action');
            $table->string('token',255)->unique();
            $table->enum('is_expired', ['0', '1'])->default(0)->comment('0 = not expired , 1 = expired');    
            $table->datetime('expiry_date_time');
            $table->datetime('created_at');
            $table->datetime('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
