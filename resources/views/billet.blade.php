<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @vite('resources/css/app.css')
    <title>Boleto - Pagamento com Sucesso</title>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
<div class="bg-white rounded-lg shadow p-10 max-w-5xl w-full text-center">
    <h1 class="text-2xl font-bold text-green-600 mb-4">Pagamento com Boleto</h1>
    <p class="text-gray-700 mb-4">Visualize o boleto abaixo e faça o download para pagamento.</p>
    <div class="mb-4 p-2">
        <iframe src="{{ $billetUrl }}" class="w-full" height="500px" frameborder="0"></iframe>
    </div>
    <div class="p-5 mb-4">
        <a href="{{ $billetUrl }}" download="boleto.pdf"
           class="inline-block  bg-gray-600 text-white p-2 rounded-md font-semibold hover:bg-gray-700 focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
            Baixar Boleto
        </a>
        <a href="{{ $routeHome }}"
           class="inline-block  bg-indigo-600 text-white p-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Voltar para o Início
        </a>
    </div>
</div>
</body>
</html>
