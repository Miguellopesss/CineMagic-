@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<x-field.input name="code" label="Código" width="md"
                :readonly="$readonly || ($mode == 'edit')"
                value="{{ old('code', $genre->code) }}"/>
<x-field.input name="name" label="Nome" width="md" :readonly="$readonly"
                value="{{ old('name', $genre->name) }}"/>
