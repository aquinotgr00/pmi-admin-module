<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->boolean('active')->default(true);
            $table->unsignedInteger('role_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
        
        Schema::table('admins', function (Blueprint $table) {
            $table->foreign('role_id')
                    ->references('id')->on('roles')
                    ->onDelete('set null');
        });
        
        DB::table('admins')->insert([
            'name'=>'Admin',
            'email'=>'admin@mail.com',
            'password'=>bcrypt('Open1234'),
            'active'=>true,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
