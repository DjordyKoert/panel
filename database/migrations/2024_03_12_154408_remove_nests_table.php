<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('eggs', function (Blueprint $table) {
            $table->dropForeign('service_options_nest_id_foreign');
            $table->dropColumn('nest_id');
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->dropForeign('servers_nest_id_foreign');
            $table->dropColumn('nest_id');
        });

        Schema::drop('nests');

        Schema::table('api_keys', function (Blueprint $table) {
            $table->dropColumn('r_nests');
        });
    }

    public function down(): void
    {
        Schema::table('api_keys', function (Blueprint $table) {
            $table->unsignedTinyInteger('r_nests')->default(0);
        });

        Schema::create('nests', function (Blueprint $table) {
            $table->increments('id');
            $table->char('uuid', 36)->unique();
            $table->string('author');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::table('eggs', function (Blueprint $table) {
            $table->mediumInteger('nest_id')->unsigned();
            $table->foreign(['nest_id'], 'service_options_nest_id_foreign');
        });

        Schema::table('servers', function (Blueprint $table) {
            $table->mediumInteger('nest_id')->unsigned();
            $table->foreign(['nest_id'], 'servers_nest_id_foreign');
        });

        if (class_exists('Database\Seeders\NestSeeder')) {
            Artisan::call('db:seed', [
                '--class' => 'NestSeeder',
            ]);
        }
    }
};
