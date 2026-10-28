<?php

namespace Database\Factories;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtotalAmount = fake()->numberBetween(2_500, 250_000);
        $taxAmount = (int) round($subtotalAmount * 0.21);
        $issuedAt = fake()->dateTimeBetween('-1 year', 'now');

        return [
            'number' => 'INV-'.fake()->unique()->numerify('######'),
            'status' => fake()->randomElement(InvoiceStatus::cases()),
            'subtotal_amount' => $subtotalAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $subtotalAmount + $taxAmount,
            'issued_at' => $issuedAt,
            'due_at' => (clone $issuedAt)->modify('+30 days'),
        ];
    }

    /**
     * Indicate that the invoice is in draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InvoiceStatus::Draft,
        ]);
    }

    /**
     * Indicate that the invoice has been sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InvoiceStatus::Sent,
        ]);
    }

    /**
     * Indicate that the invoice has been paid.
     */
    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InvoiceStatus::Paid,
        ]);
    }

    /**
     * Indicate that the invoice is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InvoiceStatus::Overdue,
        ]);
    }

    /**
     * Indicate that the invoice has been cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => InvoiceStatus::Cancelled,
        ]);
    }
}
