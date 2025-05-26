@props(['status'])

@php
    $colors = [
        'pending' => 'bg-secondary',
        'diproses' => 'bg-warning text-dark',
        'selesai' => 'bg-success',
        'ditolak' => 'bg-danger'
    ];
@endphp

<span class="badge {{ $colors[$status] ?? 'bg-primary' }}">
    {{ ucfirst($status) }}
</span>