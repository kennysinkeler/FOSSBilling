<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("aid")->nullable()->comment("Alternative id for foreign systems")->index();
            $table->bigInteger("client_group_id")->nullable()->index();
            $table->string("role")->default("client")->comment("client");
            $table->string("auth_type")->nullable();
            $table->string("email");
            $table->string("password");
            $table->enum("status",['active','suspended','canceled']);
            $table->boolean("email_approved",)->default(0);
            $table->boolean("tax_exempt")->default(0);
            $table->string("type")->nullable();
            $table->string("first_name")->nullable();
            $table->string("last_name")->nullable();
            $table->string("gender")->nullable();
            $table->date("birthday")->nullable();
            $table->string("phone_cc")->nullable();
            $table->string("phone")->nullable();
            $table->string("company")->nullable();
            $table->string("company_vat")->nullable();
            $table->string("company_number")->nullable();
            $table->string("address_1")->nullable();
            $table->string("address_2")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zipcode")->nullable();
            $table->string("country")->nullable();
            $table->string("document_type")->nullable();
            $table->string("document_nr")->nullable();
            $table->text("notes")->nullable();
            $table->string("currency")->nullable();
            $table->string("lang")->nullable();
            $table->ipAddress("ip")->nullable();
            $table->string("api_token")->nullable();
            $table->string("referred_by")->nullable();
            $table->text("custom_1")->nullable();
            $table->text("custom_2")->nullable();
            $table->text("custom_3")->nullable();
            $table->text("custom_4")->nullable();
            $table->text("custom_5")->nullable();
            $table->text("custom_6")->nullable();
            $table->text("custom_7")->nullable();
            $table->text("custom_8")->nullable();
            $table->text("custom_9")->nullable();
            $table->text("custom_10")->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
