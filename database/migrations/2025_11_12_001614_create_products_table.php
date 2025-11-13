<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sku')->nullable()->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->integer('stock')->default(0)->unsigned();
            $table->decimal('price', 12, 2)->default(0.00);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // index untuk pencarian
            $table->index(['name','sku']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}

