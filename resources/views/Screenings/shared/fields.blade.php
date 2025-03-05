@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="movie_id" label="Id do Filme" width="md" :readonly="$readonly"
                value="{{ old('movie_id', $screening->movie_id) }}"/>
<x-field.select name="theater_id" label="Teatro" width="md" :readonly="$readonly"
                :options="$theaters" value="{{ old('theater_id', $screening->theater_id) }}"/>
<x-field.input name="date" label="Data" width="md" :readonly="$readonly"
                value="{{ old('date', $screening->date) }}"/>
<x-field.input name="start_time" label="Hora de Inicio" width="md" :readonly="$readonly"
                value="{{ old('start_time', $screening->start_time) }}"/>
