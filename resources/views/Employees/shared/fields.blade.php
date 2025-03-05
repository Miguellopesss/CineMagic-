@php
    $mode = $mode ?? 'edit';
    $readonly = $mode == 'show';
@endphp
<div class="flex flex-wrap justify-between">
    <div class="flex flex-col space-y-4">
        <x-field.input
            name="name"
            label="Nome"
            width="lg"
            :readonly="$readonly"
            value="{{ old('name', $employee->name) }}"
        />
        <x-field.input
            name="email"
            label="Email"
            width="lg"
            :readonly="$readonly"
            value="{{ old('email', $employee->email) }}"
        />
        <x-field.check-box
            name="blocked"
            label="Bloqueado"
            width=""
            :readonly="$readonly"
            value="{{ old('blocked', $employee->blocked) }}"
        />
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_filename"
            label="Foto"
            width="md"
            :readonly="$readonly"
            deleteTitle="Eliminar foto"
            :deleteAllow="true"
            deleteForm="form_to_delete_photo"
            :imageUrl="$employee->getPhotoFullUrlAttribute()"
        />
    </div>
</div>
