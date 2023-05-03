<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('image')->nullable();
                $table->string('mobile')->nullable();
                $table->string('password');
                $table->string('remember_token')->nullable();
                $table->enum('type',['1','2'])->comment('2->restaurant , 3->truck');
                $table->string('latitude')->nullable();
                $table->string('longitude')->nullable();
                $table->enum('opening_status',['1','2','3'])->default('1')->comment('1->open , 2->crowded , 3->closed');
                $table->string('branch_name')->nullable();
                $table->enum('status',['active','not_active']);
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
