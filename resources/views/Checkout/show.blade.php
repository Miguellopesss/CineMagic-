@extends('layouts.main')

@section('header-title', 'Confirmar Compra')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50 w-full sm:max-w-lg lg:max-w-2xl">
        <h2 class="text-xl mb-4">Dados da Compra</h2>

        <form action="{{ route('checkout.confirm') }}" method="POST" id="checkout-form">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                <input type="text" id="name" name="name" value="{{ old('name', optional($user)->name) }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', optional($user)->email) }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="nif" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIF</label>
                <input type="text" id="nif" name="nif" value="{{ old('nif', optional($customer)->nif) }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="payment_type"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de Pagamento</label>

                    <select id="payment_type" name="payment_type" class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="VISA" {{ optional($customer)->payment_type == 'VISA' ? 'selected' : '' }}>Visa</option>
                        <option value="PAYPAL" {{ optional($customer)->payment_type == 'PAYPAL' ? 'selected' : '' }}>PayPal</option>
                        <option value="MBWAY" {{ optional($customer)->payment_type == 'MBWAY' ? 'selected' : '' }}>MbWay</option>
                    </select>
            </div>

            <div class="mb-4" id="ccv_field" style="display: none;">
                <label for="ccv"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">CCV</label>
                <input type="text" id="ccv" name="ccv" value="{{ old('ccv') }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="mb-4">
                <label for="payment_reference"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Referência de Pagamento</label>
                <input type="text" id="payment_reference" name="payment_reference" value="{{ old('payment_reference', optional($customer)->payment_ref) }}"
                    class="mt-1 block w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-indigo-300 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-600 rounded-md shadow-sm">
            </div>

            <div class="flex justify-end mt-6">
                <x-button element="submit" type="success" text="Confirmar Compra" class="mt-4"/>
            </div>
        </form>

        <div class="mt-4">
            <h3 class="text-lg">Resumo da Compra</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Filme</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Preço</th>
                    </tr>
                </thead>
                <tbody class=" divide-y divide-gray-200">
                    @foreach ($cart as $item)
                    <tr>
                        <td class="px-6 py-4 ">{{ $item['movie_title'] }}</td>
                        <td class="px-6 py-4 ">{{ $item['seat_row'] }}{{ $item['seat_number'] }}</td>
                        <td class="px-6 py-4 ">€{{ number_format($item['price'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="mt-2">Preço Total: €{{ number_format($totalPrice, 2) }}</p>
        </div>
    </div>
</div>

<script>
    // Script para mostrar ou ocultar o campo CCV dependendo do método de pagamento selecionado
    document.addEventListener('DOMContentLoaded', function () {
        const paymentType = document.getElementById('payment_type');
        const ccvField = document.getElementById('ccv_field');

        // Verifica o valor inicial do select
        toggleCCVField(paymentType.value);

        // Adiciona um listener para mudanças no select
        paymentType.addEventListener('change', function () {
            toggleCCVField(paymentType.value);
        });

        function toggleCCVField(value) {
            if (value === 'VISA') {
                ccvField.style.display = 'block';
            } else {
                ccvField.style.display = 'none';
            }
        }
    });

</script>
@endsection
