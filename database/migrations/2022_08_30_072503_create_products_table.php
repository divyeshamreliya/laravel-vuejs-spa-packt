<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('products')){
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('packt_id')->nullable();
                $table->string('isbn13')->nullable();
                $table->string('title')->nullable()->index();
                $table->string('product_type')->nullable()->index();
                $table->string('category')->nullable()->index();
                $table->string('tagline')->nullable();
                $table->integer('pages')->nullable();
                $table->string('length')->nullable();
                $table->string('url')->nullable();
                $table->string('image')->nullable();
                $table->timestamp('publication_date')->nullable()->index();
                $table->string('concept')->nullable()->index();
                $table->string('language')->nullable()->index();
                $table->string('tool')->nullable()->index();
                $table->string('vendor')->nullable();
                $table->string('authors')->nullable()->comment("comma seperated Multiple Authoer name");
                $table->timestamps();
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
        Schema::dropIfExists('products');
    }
}
