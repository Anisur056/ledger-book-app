<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voucher_transections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ledger_book_id')->constrained()->onDelete('cascade');
            $table->foreignId('accounts_head_id')->constrained()->onDelete('cascade');
            $table->enum('transaction_type', ['debit', 'credit']);
            $table->date('transaction_date');
            $table->time('transaction_time');
            $table->decimal('amount', 15, 2);
            $table->text('description');
            $table->string('voucher_number')->unique();
            $table->string('reference_number')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('voucher_transections');
    }
};