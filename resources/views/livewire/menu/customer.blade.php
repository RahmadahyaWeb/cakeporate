<div>
    <x-ui.loading :target="$target" />

    <x-slot name="header">Data Pelanggan</x-slot>

    <div class="flex justify-between mt-5">
        <div></div>
        <x-ui.button wire:click="toggleCrudModal('create', 'true')">Tambah Data</x-ui.button>
    </div>

    <x-ui.modal-form :title="$modalTitle" :modalMethod="$modalMethod">
        <x-form.input id="editing.name" label="Nama Pelanggan" wire:model="editing.name" />
        <x-form.input id="editing.contact" label="Kontak Pelanggan" wire:model="editing.contact" />
        <x-form.input id="editing.address" label="Alamat Pelanggan" wire:model="editing.address" />
    </x-ui.modal-form>

    <x-ui.table :columns="$columns" :rows="$rows" />
</div>
