<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @vite('resources/css/app.css')
    <title>Pagamento PIX - Sucesso</title>
</head>
<body class="bg-gray-900 flex items-center justify-center min-h-screen">
<div class="bg-white rounded-lg shadow p-8 max-w-md text-center">
    <h1 class="text-2xl font-bold text-green-600 mb-4">Pagamento PIX</h1>
    <p class="text-gray-700 p-2 mb-4">Escaneie o QR Code abaixo para efetuar o pagamento:</p>
    <div class="mb-4">
        <img src="data:image/png;base64,{!! $encodedImage !!}" alt="QR Code PIX" class="mx-auto">
    </div>
    <p class="text-gray-700 mb-2">Expira em:</p>
    <div id="countdown" class="text-xl font-bold text-red-600 mb-6"></div>
    <div class="p-5 mb-4">
        <a href="{{ $routeHome }}"
           class="inline-block  bg-indigo-600 text-white p-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Voltar para o Início
        </a>
    </div>
</div>

<script>
    const expirationDateStr = "{{ $expirationDate }}";
    const expirationDate = new Date(expirationDateStr);

    function updateCountdown() {
        const now = new Date();
        const diff = expirationDate - now;

        if (diff <= 0) {
            document.getElementById("countdown").textContent = "Expirado";
            clearInterval(interval);
            return;
        }

        const hours = Math.floor(diff / (1000 * 60 * 60));
        const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((diff % (1000 * 60)) / 1000);

        const formattedHours = hours.toString().padStart(2, '0');
        const formattedMinutes = minutes.toString().padStart(2, '0');
        const formattedSeconds = seconds.toString().padStart(2, '0');

        document.getElementById("countdown").textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
    }

    const interval = setInterval(updateCountdown, 1000);
</script>
</body>
</html>
