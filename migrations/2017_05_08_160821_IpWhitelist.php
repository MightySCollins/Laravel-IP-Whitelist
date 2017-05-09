<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IpWhitelist extends Migration
{
    public function up()
    {
        Schema::create('whitelisted_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('team_id');
            $table->ipAddress('address');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams');
        });
    }

    public function down()
    {
        Schema::table('whitelisted_ips', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });

        Schema::drop('whitelisted_ips');
    }
}
