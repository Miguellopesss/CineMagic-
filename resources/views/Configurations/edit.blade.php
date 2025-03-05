<!-- resources/views/configurations/edit.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar Configurações</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('configuration.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="ticket_price">Preço do Bilhete:</label>
                                <input type="number" id="ticket_price" name="ticket_price" class="form-control" value="{{ $configuration->ticket_price }}" required>
                            </div>

                            <div class="form-group">
                                <label for="registered_customer_ticket_discount">Desconto para Clientes Registrados (%):</label>
                                <input type="number" id="registered_customer_ticket_discount" name="registered_customer_ticket_discount" class="form-control" value="{{ $configuration->registered_customer_ticket_discount }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
