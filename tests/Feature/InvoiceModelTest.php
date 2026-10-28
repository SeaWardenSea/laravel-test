<?php

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

it('stores an invoice created through the factory', function () {
    $invoice = Invoice::factory()->paid()->create();

    $this->assertDatabaseHas('invoices', [
        'id' => $invoice->id,
        'number' => $invoice->number,
        'status' => InvoiceStatus::Paid->value,
        'total_amount' => $invoice->total_amount,
    ]);
});

it('casts status, amounts and dates on the model', function () {
    $invoice = new Invoice([
        'status' => 'overdue',
        'subtotal_amount' => '10000',
        'tax_amount' => '2100',
        'total_amount' => '12100',
        'issued_at' => '2026-01-15',
        'due_at' => '2026-02-14',
    ]);

    expect($invoice->status)->toBe(InvoiceStatus::Overdue)
        ->and($invoice->subtotal_amount)->toBeInt()->toBe(10000)
        ->and($invoice->tax_amount)->toBeInt()->toBe(2100)
        ->and($invoice->total_amount)->toBeInt()->toBe(12100)
        ->and($invoice->issued_at)->toBeInstanceOf(Carbon::class)
        ->and($invoice->issued_at->toDateString())->toBe('2026-01-15')
        ->and($invoice->due_at->toDateString())->toBe('2026-02-14');
});

it('builds an invoice for every status through the factory states', function (string $state, InvoiceStatus $expectedStatus) {
    $invoice = Invoice::factory()->{$state}()->make();

    expect($invoice->status)->toBe($expectedStatus);
})->with([
    ['draft', InvoiceStatus::Draft],
    ['sent', InvoiceStatus::Sent],
    ['paid', InvoiceStatus::Paid],
    ['overdue', InvoiceStatus::Overdue],
    ['cancelled', InvoiceStatus::Cancelled],
]);

it('calculates the total as subtotal plus tax in cents', function () {
    $invoice = Invoice::factory()->make();

    expect($invoice->total_amount)->toBe($invoice->subtotal_amount + $invoice->tax_amount)
        ->and($invoice->due_at->toDateString())->toBe($invoice->issued_at->addDays(30)->toDateString());
});
