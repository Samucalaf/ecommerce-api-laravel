@extends('email.layout.email')

@section('content')
<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="color: #333; text-align: center;">Bem-vindo ao nosso E-commerce!</h1>

    <p style="color: #555; font-size: 16px; line-height: 1.6;">
        Olá, <strong>{{ $user->name ?? 'Cliente' }}</strong>!
    </p>

    <p style="color: #555; font-size: 16px; line-height: 1.6;">
        Estamos muito felizes em tê-lo(a) conosco! Seu cadastro foi realizado com sucesso.
    </p>

    <p style="color: #555; font-size: 16px; line-height: 1.6;">
        Agora você pode aproveitar todas as vantagens da nossa plataforma:
    </p>

    <ul style="color: #555; font-size: 16px; line-height: 1.8;">
        <li>Acesso a produtos exclusivos</li>
        <li>Ofertas especiais</li>
        <li>Acompanhamento de pedidos</li>
        <li>Suporte dedicado</li>
    </ul>

    {{-- Botão de call-to-action para direcionar o usuário à loja --}}
    {{-- <div style="text-align: center; margin: 30px 0;">
        <a href="{{ config('app.url') }}"
           style="background-color: #4CAF50; color: white; padding: 12px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
            Começar a Comprar
        </a>
    </div> --}}

    <p style="color: #777; font-size: 14px; text-align: center; margin-top: 30px;">
        Se você tiver alguma dúvida, entre em contato conosco.
    </p>
</div>
@endsection
