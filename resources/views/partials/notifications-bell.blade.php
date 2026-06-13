{{-- Notification Bell with Dropdown --}}
<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
            class="relative p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        @php $unread = auth()->user()->notifications()->whereNull('read_at')->count() @endphp
        @if($unread > 0)
            <span class="absolute top-1 right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                {{ $unread > 9 ? '9+' : $unread }}
            </span>
        @endif
    </button>

    {{-- Dropdown --}}
    <div x-show="open"
         @click.outside="open = false"
         x-cloak
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute right-0 top-10 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden z-50">

        {{-- Header --}}
        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
            <h3 class="font-semibold text-gray-900 text-sm">Notifications</h3>
            @if($unread > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button type="submit" class="text-xs text-primary-600 hover:underline">
                    Mark all as read
                </button>
            </form>
            @endif
        </div>

        {{-- Notifications list --}}
        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
            @php $notifications = auth()->user()->notifications()->latest()->take(10)->get(); @endphp
            @forelse($notifications as $notification)
            @php $data = $notification->data; @endphp
            <a href="{{ $data['url'] ?? '#' }}"
               onclick="markRead('{{ $notification->id }}')"
               class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition-colors {{ is_null($notification->read_at) ? 'bg-primary-50/30' : '' }}">
                <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5
                    {{ is_null($notification->read_at) ? 'bg-primary-100 text-primary-600' : 'bg-gray-100 text-gray-400' }}">
                    @if(($data['icon'] ?? '') === 'check')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    @elseif(($data['icon'] ?? '') === 'x')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    @elseif(($data['icon'] ?? '') === 'receipt')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 {{ is_null($notification->read_at) ? '' : 'text-gray-600' }}">
                        {{ $data['title'] ?? 'Notification' }}
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5 line-clamp-2">{{ $data['message'] ?? '' }}</p>
                    <p class="text-xs text-gray-300 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>
                @if(is_null($notification->read_at))
                <div class="w-2 h-2 bg-primary-500 rounded-full flex-shrink-0 mt-2"></div>
                @endif
            </a>
            @empty
            <div class="text-center py-10 text-gray-400">
                <svg class="w-8 h-8 mx-auto mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p class="text-sm">No notifications yet</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
function markRead(id) {
    fetch(`/notifications/${id}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    });
}
</script>