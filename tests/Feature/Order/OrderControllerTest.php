<?php

namespace Tests\Feature\Order;

use App\Models\CartItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\OrderService;
use App\Repositories\OrderRepository;
use App\Models\Cart;
use App\Models\Order;
use Mockery;
use Illuminate\Support\Facades\Event;
use App\Models\User;
use App\Events\OrderCreated;
use App\Models\Address;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    protected OrderService $orderService;
    protected $orderRepositoryMock;

    protected  $cartMock;

    # php artisan test --filter=OrderControllerTest
    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepositoryMock = Mockery::mock(OrderRepository::class);
        $this->orderService = new OrderService($this->orderRepositoryMock);

        $this->cartMock = Mockery::mock(Cart::class);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_deve_criar_pedido_com_sucesso()

    {
        $addressId = 1;


        $cartItem = Mockery::mock(CartItem::class)->makePartial();
        $cartItem->id = 1;
        $cartItem->product_id = 1;
        $cartItem->quantity = 2;
        $cartItem->price = 100.00;


        $items = collect([$cartItem]);


        $this->cartMock->shouldReceive('getAttribute')
            ->with('id')
            ->andReturn(1);

        $this->cartMock->shouldReceive('getAttribute')
            ->with('items')
            ->andReturn($items);


        $this->cartMock->shouldReceive('getAttribute')
            ->with('user_id')
            ->andReturn(1);


        $expectedOrder = Mockery::mock(Order::class)->makePartial();
        $expectedOrder->id = 100;
        $expectedOrder->status = 'pending';

        $this->orderRepositoryMock
            ->shouldReceive('createOrder')
            ->once()
            ->with($this->cartMock, $addressId)
            ->andReturn($expectedOrder);


        $result = $this->orderService->createUserOrder($this->cartMock, $addressId);


        $this->assertInstanceOf(Order::class, $result);
        $this->assertEquals(100, $result->id);
        $this->assertEquals('pending', $result->status);
    }

    public function test_deve_lancar_excecao_ao_criar_pedido_sem_endereco()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Address ID is required to create an order.');

        $cart = Mockery::mock(Cart::class);


        $this->orderService->createUserOrder($cart, 0);
    }

    public function test_deve_listar_pedidos_do_usuario()
    {
        $userId = 1;
        $expectedOrders = collect([Mockery::mock(Order::class)]);

        $this->orderRepositoryMock
            ->shouldReceive('listOrders')
            ->once()
            ->with($userId)
            ->andReturn($expectedOrders);

        $result = $this->orderService->listUserOrders($userId);

        $this->assertSame($expectedOrders, $result);
    }


    public function test_dispara_evento_ao_criar_pedido()
    {
        Event::fake();

        $user = User::factory()->create();
        $address = Address::factory()->create(['user_id' => $user->id]);
        $cart = new Cart();

        $order = Order::create([
            'order_number' => 'ORD123456',
            'user_id' => $user->id,
            'cart_id' => 1,
            'address_id' => $address->id,
            'total' => 200.00,
            'status' => 'pending',
            'payment_method' => 'credit_card',
        ]);

        event(new OrderCreated($order, $cart));

        Event::assertDispatched(OrderCreated::class, function ($event) use ($order) {
            return $event->order->id === $order->id;
        });
}

}
