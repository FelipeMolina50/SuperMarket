<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductUniqueSkuTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    public function test_two_different_users_can_register_same_sku()
    {
        // Crear dos usuarios
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        // 1. Registrar SKU en cuenta de usuario A
        $responseA = $this->actingAs($userA)->post(route('inventory.store'), [
            'name' => 'Producto User A',
            'sku' => 'COMPARTIDO_SKU_123',
            'cat' => 'Categoría A',
            'stock' => 10,
            'price' => 50.00,
        ]);

        $responseA->assertRedirect();
        $this->assertDatabaseHas('products', [
            'user_id' => $userA->id,
            'sku' => 'COMPARTIDO_SKU_123'
        ]);

        // 2. Registrar el mismo SKU en cuenta de usuario B (debe funcionar)
        $responseB = $this->actingAs($userB)->post(route('inventory.store'), [
            'name' => 'Producto User B',
            'sku' => 'COMPARTIDO_SKU_123',
            'cat' => 'Categoría B',
            'stock' => 5,
            'price' => 100.00,
        ]);

        $responseB->assertRedirect();
        $this->assertDatabaseHas('products', [
            'user_id' => $userB->id,
            'sku' => 'COMPARTIDO_SKU_123'
        ]);
    }

    public function test_same_user_cannot_register_duplicate_sku()
    {
        $user = User::factory()->create();

        // Registrar primer producto
        $this->actingAs($user)->post(route('inventory.store'), [
            'name' => 'Producto Original',
            'sku' => 'UNICO_SKU_456',
            'cat' => 'Categoría',
            'stock' => 10,
            'price' => 50.00,
        ]);

        // Intentar registrar duplicado en el mismo usuario (debe fallar la validación)
        $response = $this->actingAs($user)->post(route('inventory.store'), [
            'name' => 'Producto Duplicado',
            'sku' => 'UNICO_SKU_456',
            'cat' => 'Categoría',
            'stock' => 15,
            'price' => 60.00,
        ]);

        $response->assertSessionHasErrors('sku');
    }
}
