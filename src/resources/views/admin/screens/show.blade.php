<x-admins.common>
  <x-slot name="title">
    上映スケジュール詳細
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">上映スケジュール詳細</h1>
  </section>

  <!-- $screenの詳細情報 -->
  <section class="pt-3 px-5 mb-10">
    <!-- タイトル -->
    <div class="flex justify-start my-5">
      <h2 class="text-4xl font-extrabold text-gray-700">{{ $screen->movie->title }}</h2>
    </div>
    <!-- /タイトル -->
    <!-- 上映日 -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">上映日</p>
      <p class="text-xl font-bold text-gray-700">{{ $screening_date }}</p>
    </div>
    <!-- /上映日 -->
    <!-- 上映時間 -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">上映時間</p>
      <p class="text-xl font-bold text-gray-700">
        {{ Carbon\Carbon::parse($screen->start_time)->format('H時i分') }} ~ {{
        Carbon\Carbon::parse($screen->end_time)->format('H時i分') }}
      </p>
    </div>
    <!-- /上映時間 -->
  </section>
  <!-- /$screenの詳細情報 -->

  <!-- 座席の予約状況 -->
  <section class="pt-3 px-5 mb-10">
    <h2 class="text-3xl font-bold text-gray-500 mb-3">座席の予約状況</h2>
    <div class="flex w-1/12 justify-between mb-2">
      <span class="text-sm">予約済み</span>
      <div class="border w-10 h-5 bg-red-500"></div>
    </div>
    <div class="flex w-1/12 justify-between">
      <span class="text-sm">空きあり</span>
      <div class="border w-10 h-5 bg-blue-500"></div>
    </div>

    <div class="mx-auto bg-purple-300 w-2/5 text-center font-bold h-10 leading-10 tracking-widest	mt-8 rounded-sm">
      画面
    </div>

    <table class="min-w-full divide-y divide-gray-200 mt-6 border-4">
      <tbody class="bg-white divide-y divide-gray-200" x-data="{ isActive: false }">
        <!-- Aの行 -->
        <tr>
          @foreach ($seat_num as $num => $value)
            @if( substr($num, 0, 1) == 'A' )
            <td class="px-6 py-4 border-4 {{ $value['reserved'] ? 'bg-red-500' : 'bg-blue-500' }} h-20 w-20" >
              <div class="mb-1">
                {{ $num }}
              </div>
              @if( $value['user'] )
              <span class="text-xs">予約者: {{ $value['user']['user']['name'] }}</span>
              @endif
            </td>
            @endif
          @endforeach
        </tr>
        <!-- Bの行 -->
        <tr>
          @foreach ($seat_num as $num => $value)
            @if( substr($num, 0, 1) == 'B' )
            <td class="px-6 py-4 border-4 {{ $value['reserved'] ? 'bg-red-500' : 'bg-blue-500' }} h-20 w-20" >
              <div class="mb-1">
                {{ $num }}
              </div>
              @if( $value['user'] )
              <span class="text-xs">予約者: {{ $value['user']['user']['name'] }}</span>
              @endif
            </td>
            @endif
          @endforeach
        </tr>
      </tbody>
    </table>

  </section>
  <!-- /座席の予約状況 -->
</x-admins.common>