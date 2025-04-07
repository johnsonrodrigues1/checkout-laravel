<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @vite('resources/css/app.css')
    <title>Pagamento com Sucesso - LARAVEL</title>
</head>
<body class="bg-gray-900">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full bg-white rounded-lg shadow p-10 text-center">
        <h1 class="text-3xl font-bold text-green-600 mb-4">Pagamento Realizado com Sucesso!</h1>
        <p class="text-lg text-gray-700 mb-6">
            Obrigado por sua compra. Seu pagamento foi processado com sucesso.
        </p>
        <a href="{{ $routeHome }}"
           class="inline-block  bg-indigo-600 text-white p-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Voltar para o Início
        </a>
    </div>
</div>
</body>
</html>
