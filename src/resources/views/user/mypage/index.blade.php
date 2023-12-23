<x-users.common>
  <x-slot name="title">
    マイページ
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">マイページ</h1>
  </section>

  <!-- 予約キャンセルのフラッシュメッセージ -->
  <section>
    @if (session('mypage_flash_message'))
    <div class="px-32 pt-3">
      <div class="border border-green-400 rounded bg-green-100 px-4 py-3 text-green-700">
        <p>
          {{ session('mypage_flash_message') }}
        </p>
      </div>
    </div>
    @endif
  </section>
  <!-- /予約キャンセルのフラッシュメッセージ -->

  <section class="mt-5">
    <h2 class="text-2xl font-semibold text-center mb-5 text-gray-700">予約一覧</h2>

    @foreach($reserves as $reserve)
    <div class="max-w-5xl p-6 border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 xl:mx-auto bg-purple-100 mb-32 sm:mx-3">

      <div class="flex items-center mb-3">
        <span class="text-lg font-bold w-24 text-sky-500">
          タイトル
        </span>
        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
          {{ $reserve['screen']['movie']['title'] }}
        </h5>
      </div>
      <div class="flex items-center mb-3">
        <span class="text-lg font-bold w-24 text-sky-500">上映日</span>
        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
          {{ \Carbon\Carbon::parse($reserve['screen']['screening_date'])->format('Y年m月d日') }}
        </h5>
      </div>
      <div class="flex items-center mb-3">
        <span class="text-lg font-bold w-24 text-sky-500">上映時間</span>
        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
          {{ \Carbon\Carbon::parse($reserve['screen']['start_time'])->format('H時i分') }} ~ {{ \Carbon\Carbon::parse($reserve['screen']['end_time'])->format('H時i分') }}
        </h5>
      </div>
      <div class="flex items-center mb-3">
        <span class="text-lg font-bold w-24 text-sky-500">座席</span>
        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
          {{ $reserve['seat_number'] }}
        </h5>
      </div>

      <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
        当日こちらの画面をご提示ください。
      </p>

      <form action="{{ route('user.mypage.reserve_cancel') }}" method="post">
        @csrf
        <input type="hidden" name="seat_id" value="{{ $reserve['id'] }}">
        <button type="button"
          class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" data-modal-target="reserveCancelModal-{{ $reserve['id'] }}" data-modal-toggle="reserveCancelModal-{{ $reserve['id'] }}">
          キャンセル
      </button>
      @php
      $modalId = 'reserveCancelModal-' . $reserve['id'];
      @endphp

      <!-- モーダル -->
      <x-submit-modal :modalId="$modalId" >
        <x-slot name="modalTitle">
          予約をキャンセルしてもよろしいですか？
        </x-slot>
      </x-submit-modal>
      <!-- /モーダル -->
      </form>
    </div>
    @endforeach


  </section>
</x-users.common>