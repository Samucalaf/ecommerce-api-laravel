@extends('email.layout.email')

@section('content')
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0;">
        <h1 style="margin: 0; font-size: 28px;">✓ Pedido Confirmado!</h1>
    </div>
    
    <div style="background-color: #f9f9f9; padding: 30px; border: 1px solid #ddd; border-radius: 0 0 5px 5px;">
        <p style="font-size: 16px; color: #333;">Olá, <strong>{{ $order->user->name }}</strong>!</p>
        
        <p style="font-size: 14px; color: #666; line-height: 1.6;">
            Recebemos seu pedido com sucesso e ele já está sendo processado.
        </p>
        
        <div style="background-color: white; padding: 20px; margin: 20px 0; border-radius: 5px; border: 1px solid #ddd;">
            <h2 style="color: #333; font-size: 18px; margin-top: 0;">Detalhes do Pedido</h2>
            <p style="margin: 5px 0;"><strong>Número do Pedido:</strong> #{{ $order->order_number }}</p>
            <p style="margin: 5px 0;"><strong>Data:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
            <p style="margin: 5px 0;"><strong>Status:</strong> <span style="color: #4CAF50;">{{ $order->status }}</span></p>
            <p style="margin: 5px 0;"><strong>Total:</strong> R$ {{ number_format($order->total, 2, ',', '.') }}</p>
        </div>
        
        <div style="background-color: white; padding: 20px; margin: 20px 0; border-radius: 5px; border: 1px solid #ddd;">
            <h3 style="color: #333; font-size: 16px; margin-top: 0;">Itens do Pedido</h3>
            @foreach($order->items as $item)
            <div style="padding: 10px 0; border-bottom: 1px solid #eee;">
                <p style="margin: 5px 0; color: #333;"><strong>{{ $item->product->name }}</strong></p>
                <p style="margin: 5px 0; color: #666; font-size: 14px;">
                    Quantidade: {{ $item->quantity }} x R$ {{ number_format($item->price, 2, ',', '.') }}
                </p>
            </div>
            @endforeach
        </div>
        
        <p style="font-size: 14px; color: #666; text-align: center; margin-top: 30px;">
            Obrigado por comprar conosco!
        </p>
    </div>
</div>
@endsection