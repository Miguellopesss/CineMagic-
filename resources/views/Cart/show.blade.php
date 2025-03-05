@extends('layouts.main')

@section('header-title', 'Shopping Cart')

@section('main')
<div class="flex justify-center">
    <div class="my-4 p-6 bg-white dark:bg-gray-900 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-50">

        @if(empty($cart))
            <h3 class="text-xl w-96 text-center">Seu carrinho está vazio.</h3>
        @else
            <div class="font-base text-sm text-gray-700 dark:text-gray-300">
                <x-cart.table :cart="$cart" :showView="false" :showDelete="true" />
            </div>
            <div class="mt-12">
                <div class="flex justify-between space-x-12 items-end">
                    <div>
                        <form action="{{ route('cart.destroy') }}" method="post">
                            @csrf
                            @method('DELETE')
                            <x-button element="submit" type="danger" text="Limpar Carrinho" class="mt-4"/>
                        </form>
                    </div>
                    <div>
                        <form action="{{ route('checkout.show') }}" method="get">
                            @csrf
                            <x-button element="submit" type="success" text="Finalizar Compra" class="mt-4"/>
                        </form>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


