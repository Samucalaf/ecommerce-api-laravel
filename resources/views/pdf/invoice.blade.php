<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nota Fiscal do Pedido</title>
</head>
<body>
    <p>Olá, {{ $order->user->name }}.</p>
    <p>Obrigado por sua compra! A nota fiscal referente ao seu pedido <strong>#{{ $order->id }}</strong> está anexa neste e-mail.</p>
    <p>Atenciosamente,</p>
    <p><strong>{{ config('app.name') }}</strong></p>
</body>
</html>
