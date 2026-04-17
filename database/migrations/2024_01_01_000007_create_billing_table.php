<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('invoice_number', 20)->unique();    // INV-2024-00001
            $table->foreignUlid('patient_id')->constrained()->restrictOnDelete();
            $table->foreignUlid('appointment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignUlid('created_by')->constrained('users')->restrictOnDelete();

            $table->enum('status', ['draft', 'sent', 'partial', 'paid', 'overdue', 'void'])
                  ->default('draft');
            $table->enum('type', ['treatment', 'consultation', 'product', 'mixed'])
                  ->default('treatment');

            $table->date('issue_date');
            $table->date('due_date')->nullable();

            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->enum('discount_type', ['fixed', 'percentage'])->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->decimal('balance_due', 10, 2)->default(0);

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['patient_id', 'status']);
            $table->index('issue_date');
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('invoice_id')->constrained()->cascadeOnDelete();
            $table->enum('item_type', ['service', 'product', 'consultation', 'custom'])
                  ->default('service');
            $table->foreignId('service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('description');
            $table->decimal('quantity', 10, 3)->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->string('payment_number', 20)->unique();    // PAY-2024-00001
            $table->foreignUlid('invoice_id')->constrained()->restrictOnDelete();
            $table->foreignUlid('patient_id')->constrained()->restrictOnDelete();
            $table->foreignUlid('received_by')->constrained('users')->restrictOnDelete();

            $table->decimal('amount', 10, 2);
            $table->enum('method', [
                'cash', 'credit_card', 'debit_card',
                'gcash', 'maya', 'bank_transfer',
                'insurance', 'check', 'other',
            ])->default('cash');
            $table->string('reference_number')->nullable();
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])
                  ->default('completed');
            $table->text('notes')->nullable();
            $table->timestamp('paid_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
