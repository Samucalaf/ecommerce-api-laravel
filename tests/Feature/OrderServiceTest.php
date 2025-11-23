<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\OrderService;
use App\Repositories\OrderRepository;
use App\Models\Cart;
use App\Models\Order;
use Mockery;

class OrderServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    protected OrderService $orderService;
    protected $orderRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->orderRepositoryMock = Mockery::mock(OrderRepository::class);
        $this->orderService = new OrderService($this->orderRepositoryMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_deve_criar_pedido_com_sucesso()
    {
        $cart = Mockery::mock(Cart::class);
        $addressId = 1;
        $expectedOrder = Mockery::mock(Order::class);

        $this->orderRepositoryMock
            ->shouldReceive('createOrder')
            ->once()
            ->with($cart, $addressId)
            ->andReturn($expectedOrder);

        $result = $this->orderService->createUserOrder($cart, $addressId);

        $this->assertSame($expectedOrder, $result);
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

    public function test_deve_obter_pedido_por_id()
    {
        $userId = 1;
        $orderId = 10;
        $expectedOrder = Mockery::mock(Order::class);

        $this->orderRepositoryMock
            ->shouldReceive('findOrderById')
            ->once()
            ->with($userId, $orderId)
            ->andReturn($expectedOrder);

        $result = $this->orderService->getUserOrderById($userId, $orderId);

        $this->assertSame($expectedOrder, $result);
    }

    public function test_deve_atualizar_status_do_pedido()
    {
        $order = Mockery::mock(Order::class);
        $status = 'shipped';
        $expectedOrder = Mockery::mock(Order::class);

        $this->orderRepositoryMock
            ->shouldReceive('updateOrderStatus')
            ->once()
            ->with($order, $status)
            ->andReturn($expectedOrder);

        $result = $this->orderService->updateUserOrderStatus($order, $status);

        $this->assertSame($expectedOrder, $result);
    }

}
