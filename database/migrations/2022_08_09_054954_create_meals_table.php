<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('meals')) {
            Schema::create('meals', function (Blueprint $table) {
                $table->id();
                $table->integer('user_id')->default(0);
                $table->integer('category_id')->default(0);
                $table->integer('vendor_id')->default(0);
                $table->string('image')->nullable();
                $table->double('price')->default(0);
                $table->double('price_offer')->default(0);
                $table->integer('sort_order')->default(0);
                $table->enum('status',['active','not_active']);
                $table->enum('best_selling',['1','0'])->default('0');
                $table->integer('count_selling')->default(0);
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
        Schema::dropIfExists('meals');
    }
}
