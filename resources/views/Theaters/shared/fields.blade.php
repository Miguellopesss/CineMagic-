@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="nome" label="Nome" width="md"
                :readonly="$readonly"
                value="{{ old('nome', $theater->name) }}"/>
<x-field.input name="num_rows" label="Número de Filas" width="md" :readonly="$readonly"
                value="{{ old('num_rows') }}"/>
 <x-field.input name="num_seats_per_row" label="Número de Lugares por Fila" width="md" :readonly="$readonly"
                value="{{ old('num_seats_per_row') }}"/>
