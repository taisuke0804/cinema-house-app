<div class="max-w-7xl mx-auto mt-8 mb-12">
  <div class="bg-white p-4 rounded shadow-lg">
    <!-- Month Header -->
    <div class="flex justify-between items-center mb-3">
      <span class="text-lg font-semibold">
        {{ $today->year }}年{{ $today->month }}月
      </span>
      @if( $auth === 'user' )
      <div>
        <a href="{{ route('user.index', ['year' => $today->copy()->subMonth()->year, 'month' => $today->copy()->subMonth()->month]) }}"
          class="text-sm px-2 py-1 mr-2">
          先月
        </a>
        <a href="{{ route('user.index', ['year' => $today->copy()->addMonth()->year, 'month' => $today->copy()->addMonth()->month]) }}"
          class="text-sm px-2 py-1">
          翌月
        </a>
      </div>
      @elseif( $auth === 'admin' )
      <div>
        <a href="{{ route('admin.screens.index', ['year' => $today->copy()->subMonth()->year, 'month' => $today->copy()->subMonth()->month]) }}"
          class="text-sm px-2 py-1 mr-2">
          先月
        </a>
        <a href="{{ route('admin.screens.index', ['year' => $today->copy()->addMonth()->year, 'month' => $today->copy()->addMonth()->month]) }}"
          class="text-sm px-2 py-1">
          翌月
        </a>
      </div>
      @endif
    </div>

    <!-- Days of the week -->
    <div class="grid grid-cols-7 gap-2 mb-2">
      <div class="text-center font-semibold">月</div>
      <div class="text-center font-semibold">火</div>
      <div class="text-center font-semibold">水</div>
      <div class="text-center font-semibold">木</div>
      <div class="text-center font-semibold">金</div>
      <div class="text-center font-semibold">土</div>
      <div class="text-center font-semibold">日</div>
    </div>

    <!-- Dates -->
    @foreach($weeks as $index => $week)
    <div class="grid grid-cols-7 gap-2">
      @foreach($week as $key => $days)
      <div class="border border-red-200 p-1 {{ $days['current_month'] ? 'bg-white' : 'bg-slate-700' }}">
        <div class="text-center py-1">{{ $days['day']->day }}日</div>
        @if( !empty($days['screen']) )
        @foreach($days['screen'] as $i => $screen)
        <div class="bg-blue-100 py-2 rounded mb-1">
          <span>
            {{ \Carbon\Carbon::parse($screen['start_time'])->format('H:i') }}~{{ \Carbon\Carbon::parse($screen['end_time'])->format('H:i') }}
          </span>
          @if( $auth === 'user' )
          <a class="break-words block font-bold text-blue-700" href="{{ route('user.reserve.create', $screen['id']) }}">
            『{{ $screen['movie']['title'] }}』
          </a>
          @elseif( $auth === 'admin' )
          <a class="break-words block font-bold text-blue-700" href="{{ route('admin.screens.show', $screen['id']) }}">
            『{{ $screen['movie']['title'] }}』
          </a>
          @endif
        </div>
        @endforeach
        @endif
      </div>
      @endforeach
    </div>
    @endforeach

  </div>
</div>