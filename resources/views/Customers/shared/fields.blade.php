@php
    $mode = $mode ?? 'edit';
    $readonly = true;
    $checkboxReadonly = $mode == 'show';
@endphp

<div class="flex flex-wrap justify-between">
    <div class="flex flex-col space-y-4">
        <x-field.input
            name="name"
            label="Nome"
            width="lg"
            :readonly="$readonly"
            value="{{ old('name', $customer->name) }}"
        />
        <x-field.input
            name="email"
            label="Email"
            width="lg"
            :readonly="$readonly"
            value="{{ old('email', $customer->email) }}"
        />
        <x-field.check-box
            name="blocked"
            label="Bloqueado"
            width=""
            :readonly="$checkboxReadonly"
            value="{{ old('blocked', $customer->blocked) }}"
        />
    </div>
    <div class="pb-6">
        <x-field.image
            name="photo_file"
            label="Foto"
            width="md"
            :readonly="$readonly"
            deleteTitle="Delete Photo"
            :deleteAllow="($mode == 'edit') && ($customer->imageExists)"
            deleteForm="form_to_delete_photo"
            :imageUrl="$customer->getPhotoFullUrlAttribute()"
        />
    </div>
</div>
