<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('packing_lists', function (Blueprint $table) {
            $table->foreignId('customer_id')->after('id')->nullable()->constrained('customers')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('packing_lists', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
        });
    }
};
