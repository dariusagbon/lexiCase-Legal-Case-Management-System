{{-- resources/views/partials/status-badge.blade.php --}}
@php
    $statusClasses = [
        'open' => 'bg-blue-100 text-blue-800',
        'pending' => 'bg-yellow-100 text-yellow-800',
        'closed' => 'bg-green-100 text-green-800',
    ];
    
    $statusClass = $statusClasses[$status] ?? 'bg-gray-100 text-gray-800';
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $statusClass }}">
    {{ ucfirst($status) }}
</span>
