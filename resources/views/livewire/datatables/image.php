<div>
@if($value)
    <img src="{{ Config::get('livewire-datatables.image_url_prefix') }}{{ $value }}" class="shadow-lg rounded max-w-full h-auto align-middle border-none" style="max-width: 25px;" />
@else
    <img src="{{ Config::get('livewire-datatables.default_image_url') }}" class="shadow-lg rounded max-w-full h-auto align-middle border-none" style="max-width: 25px;" />
@endif
</div>