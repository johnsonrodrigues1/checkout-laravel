<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    @vite('resources/css/app.css')
    <title>CHECKOUT - LARAVEL</title>
</head>
<body class="bg-gray-900">
<div class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-5xl w-full bg-white rounded-lg shadow p-6">
        <h1 class="mb-4 text-2xl text-center text-blue-900 font-bold">CHECKOUT - LARAVEL</h1>
        <div class="flex flex-col gap-6">
            <div class="bg-gray-50 p-4 rounded-lg">
                <h2 class="text-xl font-bold">{{$product->name}}</h2>
                <p class="text-sm text-gray-400">{{$product->description}}</p>
                <span class="block mt-4 text-lg font-semibold text-gray-800">R$ {{$product->price}}</span>
            </div>
            <div>
                <h3 class="text-xl font-semibold mb-4">Dados Pessoais</h3>
                <form id="checkoutForm" action="{{route('checkout.processPayment')}}" class="space-y-4" method="post">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="flex gap-4 mt-4">
                        <div class="flex-1">
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" id="name" value="{{old('name')}}" name="name" placeholder="James Bond"
                                   required
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>

                        <div class="flex-1">
                            <label for="document" class="block text-sm font-medium text-gray-700">CPF/CNPJ</label>
                            <input type="text" id="document" value="{{old('document')}}" name="document"
                                   placeholder="informe seu cpf/cnpj" required
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <div class="flex-1">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" value="{{old('email')}}" name="email"
                                   placeholder="exemplo@mail.com" required
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                        <div class="flex-1">
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                            <input type="text" id="phone" name="phone" value="{{old('phone')}}"
                                   placeholder="(99) 9 9999-9999" required
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <div class="flex-1">
                            <label for="address" class="block text-sm font-medium text-gray-700">Endereço</label>
                            <input type="text" id="address" name="address" placeholder="Seu endereço"
                                   value="{{old('address')}}"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                        <div class="flex-1">
                            <label for="address_number" class="block text-sm font-medium text-gray-700">Número</label>
                            <input type="text" id="address_number" name="address_number" placeholder="Número"
                                   value="{{old('address_number')}}"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                    </div>
                    <div class="flex gap-4 mt-4">
                        <div class="flex-1">
                            <label for="address_complement"
                                   class="block text-sm font-medium text-gray-700">Complemento</label>
                            <input type="text" id="address_complement" name="address_complement"
                                   placeholder="Complemento"
                                   value="{{old('address_complement')}}"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                        <div class="flex-1">
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">CEP</label>
                            <input type="text" id="postal_code" name="postal_code" placeholder="CEP"
                                   value="{{old('postal_code')}}"
                                   class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                        </div>
                    </div>


                    <hr class="my-4"/>
                    <h3 class="text-xl font-semibold mb-2">Selecione a forma de pagamento</h3>
                    <input type="hidden" name="payment_method" id="payment_method" value="">
                    <div class="flex flex-wrap gap-4">
                        <button id="btnCreditCard" type="button"
                                class="{{old('payment_method')==2 ? 'bg-indigo-600 text-white' :'' }} flex items-center justify-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:ring-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cartão de Crédito
                        </button>
                        <button id="btnBillet" type="button"
                                class="{{old('payment_method')==3 ? 'bg-indigo-600 text-white' :'' }}  flex items-center justify-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:ring-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Boleto
                        </button>
                        <button id="btnPix" type="button"
                                class="{{old('payment_method')==1 ? 'bg-indigo-600 text-white' :'' }} flex items-center justify-center bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:ring-blue-500 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            PIX
                        </button>
                    </div>
                    <div id="creditCardFields" style="{{old('payment_method')!=2 ?'display:none' :' ' }}">
                        <div class="flex gap-4 mt-4">
                            <div class="flex-1">
                                <label for="holder_name" class="block text-sm font-medium text-gray-700">Nome impresso
                                    no cartão</label>
                                <input type="text" id="holder_name" name="holder_name"
                                       placeholder="Nome impresso no cartão"
                                       value="{{old('holder_name')}}"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                            </div>
                            <div class="flex-1">
                                <label for="card_number" class="block text-sm font-medium text-gray-700">Número do
                                    cartão</label>
                                <input type="text" id="card_number" name="card_number" placeholder="1234 1234 1234 1234"
                                       value="{{old('card_number')}}"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-4">
                            <div class="w-1/3">
                                <label for="expiration_month" class="block text-sm font-medium text-gray-700">Mês de
                                    expiração</label>
                                <input type="text" id="expiration_month" name="expiration_month" placeholder="MM"
                                       value="{{old('expiration_month')}}"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                            </div>
                            <div class="w-1/3">
                                <label for="expiration_year" class="block text-sm font-medium text-gray-700">Ano de
                                    expiração</label>
                                <input type="text" id="expiration_year" name="expiration_year" placeholder="YY"
                                       value="{{old('expiration_year')}}"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                            </div>
                            <div class="w-1/3">
                                <label for="security_code" class="block text-sm font-medium text-gray-700">CVV</label>
                                <input type="text" id="security_code" name="security_code" placeholder="123"
                                       value="{{old('security_code')}}"
                                       class="mt-1 p-2 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-indigo-500"/>
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                            class="mt-4 w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Realizar o pagamento
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="errorModal" class="fixed inset-0 flex items-center justify-center bg-black/80 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
        <h3 class="text-xl font-bold mb-4 text-red-600">Ooops...</h3>
        <p id="errorMessage" class="mb-4 text-gray-700"></p>
        <button id="closeModal"
                class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none">
            Fechar
        </button>
    </div>
</div>

<script>
    function maskDocument(value) {
        let digits = value.replace(/\D/g, '');
        if (digits.length <= 11) {
            digits = digits.substring(0, 11);
            const part1 = digits.substring(0, 3);
            const part2 = digits.substring(3, 6);
            const part3 = digits.substring(6, 9);
            const part4 = digits.substring(9, 11);
            return part1 + (part2 ? '.' + part2 : '') + (part3 ? '.' + part3 : '') + (part4 ? '-' + part4 : '');
        } else {
            digits = digits.substring(0, 14);
            const part1 = digits.substring(0, 2);
            const part2 = digits.substring(2, 5);
            const part3 = digits.substring(5, 8);
            const part4 = digits.substring(8, 12);
            const part5 = digits.substring(12, 14);
            return part1 + (part2 ? '.' + part2 : '') + (part3 ? '.' + part3 : '') +
                (part4 ? '/' + part4 : '') + (part5 ? '-' + part5 : '');
        }
    }

    function maskPhone(value) {
        let digits = value.replace(/\D/g, '');
        digits = digits.substring(0, 11);
        const part1 = digits.substring(0, 2);
        const part2 = digits.substring(2, 3);
        const part3 = digits.substring(3, 7);
        const part4 = digits.substring(7, 11);
        let masked = "";
        if (part1) masked += "(" + part1 + ") ";
        if (part2) masked += part2 + " ";
        if (part3) masked += part3;
        if (part4) masked += "-" + part4;
        return masked;
    }

    function maskCardNumber(value) {
        let digits = value.replace(/\D/g, '');
        digits = digits.substring(0, 16);
        let parts = [];
        for (let i = 0; i < digits.length; i += 4) {
            parts.push(digits.substring(i, i + 4));
        }
        return parts.join(" ");
    }

    function maskExpiration(value) {
        let digits = value.replace(/\D/g, '');
        return digits.substring(0, 2);
    }

    function maskSecurityCode(value) {
        let digits = value.replace(/\D/g, '');
        return digits.substring(0, 3);
    }

    document.getElementById("document").addEventListener("input", function () {
        this.value = maskDocument(this.value);
    });
    document.getElementById("phone").addEventListener("input", function () {
        this.value = maskPhone(this.value);
    });
    document.getElementById("card_number").addEventListener("input", function () {
        this.value = maskCardNumber(this.value);
    });
    document.getElementById("expiration_month").addEventListener("input", function () {
        this.value = maskExpiration(this.value);
    });
    document.getElementById("expiration_year").addEventListener("input", function () {
        this.value = maskExpiration(this.value);
    });
    document.getElementById("security_code").addEventListener("input", function () {
        this.value = maskSecurityCode(this.value);
    });

    document.addEventListener("DOMContentLoaded", function () {
        const btnCreditCard = document.getElementById("btnCreditCard");
        const btnBillet = document.getElementById("btnBillet");
        const btnPix = document.getElementById("btnPix");
        const creditCardFields = document.getElementById("creditCardFields");
        const inputPaymentMethod = document.getElementById("payment_method");

        function removeActive() {
            btnCreditCard.classList.remove("bg-indigo-600", "text-white");
            btnBillet.classList.remove("bg-indigo-600", "text-white");
            btnPix.classList.remove("bg-indigo-600", "text-white");
            btnCreditCard.classList.add("bg-gray-200", "text-gray-700");
            btnBillet.classList.add("bg-gray-200", "text-gray-700");
            btnPix.classList.add("bg-gray-200", "text-gray-700");
            inputPaymentMethod.value = "";
        }

        btnCreditCard.addEventListener("click", function () {
            removeActive();
            btnCreditCard.classList.add("bg-indigo-600", "text-white");
            creditCardFields.style.display = "block";
            inputPaymentMethod.value = 2;
        });

        btnBillet.addEventListener("click", function () {
            removeActive();
            btnBillet.classList.add("bg-indigo-600", "text-white");
            creditCardFields.style.display = "none";
            inputPaymentMethod.value = 3;
        });

        btnPix.addEventListener("click", function () {
            removeActive();
            btnPix.classList.add("bg-indigo-600", "text-white");
            creditCardFields.style.display = "none";
            inputPaymentMethod.value = 1;
        });

        function showError(message) {
            const modal = document.getElementById("errorModal");
            const errorMessage = document.getElementById("errorMessage");
            errorMessage.textContent = message;
            modal.classList.remove("hidden");
        }

        document.getElementById("closeModal").addEventListener("click", function () {
            document.getElementById("errorModal").classList.add("hidden");
        });

        const form = document.getElementById("checkoutForm");
        form.addEventListener("submit", function (event) {
            const name = document.getElementById("name").value.trim();
            const email = document.getElementById("email").value.trim();
            const documentField = document.getElementById("document").value.replace(/\D/g, '');
            const phone = document.getElementById("phone").value.replace(/\D/g, '');
            const paymentMethod = inputPaymentMethod.value;

            if (paymentMethod === "") {
                showError("Por favor, selecione uma forma de pagamento.");
                event.preventDefault();
                return;
            }


            if (!name || !email || !documentField || !phone) {
                showError("Por favor, preencha todos os campos obrigatórios.");
                event.preventDefault();
                return;
            }
            if (documentField.length !== 11 && documentField.length !== 14) {
                showError("CPF/CNPJ inválido. Informe 11 dígitos para CPF ou 14 para CNPJ.");
                event.preventDefault();
                return;
            }
            if (phone.length !== 11) {
                showError("Telefone inválido. Informe 11 dígitos.");
                event.preventDefault();
                return;
            }
            if (creditCardFields.style.display === "block") {
                const address = document.getElementById("address").value.trim();
                const addressNumber = document.getElementById("address_number").value.trim();
                const addressComplement = document.getElementById("address_complement").value.trim();
                const postalCode = document.getElementById("postal_code").value.replace(/\D/g, '');
                if (!address || !addressNumber || !addressComplement || !postalCode) {
                    showError("Por favor, preencha todos os campos de endereço obrigatórios.");
                    event.preventDefault();
                    return;
                }
                if (postalCode.length !== 8) {
                    showError("CEP inválido. Informe 8 dígitos.");
                    event.preventDefault();
                    return;
                }
                const holderName = document.getElementById("holder_name").value.trim();
                const cardNumber = document.getElementById("card_number").value.replace(/\D/g, '');
                const expMonth = document.getElementById("expiration_month").value.replace(/\D/g, '');
                const expYear = document.getElementById("expiration_year").value.replace(/\D/g, '');
                const securityCode = document.getElementById("security_code").value.replace(/\D/g, '');
                if (!holderName) {
                    showError("Por favor, preencha o nome impresso no cartão.");
                    event.preventDefault();
                    return;
                }
                if (cardNumber.length !== 16) {
                    showError("Número do cartão inválido. Informe 16 dígitos.");
                    event.preventDefault();
                    return;
                }
                if (expMonth.length !== 2 || parseInt(expMonth, 10) < 1 || parseInt(expMonth, 10) > 12) {
                    showError("Mês de expiração inválido.");
                    event.preventDefault();
                    return;
                }
                if (expYear.length !== 2) {
                    showError("Ano de expiração inválido.");
                    event.preventDefault();
                    return;
                }
                if (securityCode.length !== 3) {
                    showError("Código de segurança inválido.");
                    event.preventDefault();
                }
            }
        });
    });
</script>

@if ($errors->any())
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("errorModal");
            const errorMessage = document.getElementById("errorMessage");
            errorMessage.innerHTML = "{!! implode('<br>', $errors->all()) !!}";
            modal.classList.remove("hidden");
        });
    </script>
@endif
</body>
</html>
