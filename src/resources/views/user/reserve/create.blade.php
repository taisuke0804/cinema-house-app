<x-users.common>
  <x-slot name="title">
    座席の予約
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">座席の予約</h1>
  </section>

  <!-- $screenの詳細情報 -->
  <section class="pt-3 px-5 mb-10">
    <!-- タイトル -->
    <div class="flex justify-start my-5">
      <h2 class="text-4xl font-extrabold text-gray-700">{{ $screen->movie->title }}</h2>
    </div>
    <!-- /タイトル -->

    <!-- ポスター画像 -->
    <div class="flex justify-start mb-5">
      @if($screen->movie->poster_image_path)
      <img src="{{ asset('storage/posters/' . $screen->movie->poster_image_path) }}" alt="{{ $screen->movie->title }}"
        class="w-52 h-52">
      @else
      <img src="{{ asset('images/poster_noimage.jpg') }}" alt="{{ $screen->movie->title }}" class="w-52 h-52">
      @endif
    </div>
    <!-- /ポスター画像 -->

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
    <!-- 制作年 -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">制作年</p>
      <p class="text-xl font-bold text-gray-700">{{ $screen->movie->production_year }}年</p>
    </div>
    <!-- /制作年 -->
    <!-- ジャンル -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">ジャンル</p>
      <p class="text-xl font-bold text-gray-700">{{ \App\Consts\Genre::GENRE_LIST[$screen->movie->genre] }}</p>
    </div>
    <!-- /ジャンル -->
    <!-- 説明文 -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">説明文</p>
      <p class="text-lg font-bold text-gray-700	w-3/4	">
        {!! nl2br(e($screen->movie->description)) !!}
      </p>
    </div>
    <!-- /説明文 -->
  </section>
  <!-- /$screenの詳細情報 -->

  <!-- 座席の予約状況 -->
  <section class="pt-3 px-5 mb-10">
    <h2 class="text-3xl font-bold text-gray-500 mb-3">座席の予約状況</h2>

    @if(isset($user_seat))
    <p class="mb-3 text-3xl text-red-600 font-semibold bg-slate-300 rounded px-3">
      {{ $user_seat->seat_number }}番の座席を予約済みのため、新たに予約することはできません。
    </p>
    @endif

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
          <td class="px-6 py-4 border-4 {{ $value['reserved'] ? 'bg-red-500' : 'bg-blue-500' }} h-20 w-20">
            <div class="mb-1">
              {{ $num }}
            </div>
            
          </td>
          @endif
          @endforeach
        </tr>
        <!-- Bの行 -->
        <tr>
          @foreach ($seat_num as $num => $value)
          @if( substr($num, 0, 1) == 'B' )
          <td class="px-6 py-4 border-4 {{ $value['reserved'] ? 'bg-red-500' : 'bg-blue-500' }} h-20 w-20">
            <div class="mb-1">
              {{ $num }}
            </div>
          </td>
          @endif
          @endforeach
        </tr>
      </tbody>
    </table>

  </section>
  <!-- /座席の予約状況 -->

  @if(!isset($user_seat))
  <!-- 予約されてない座席をセレクトボックスで選択する形式のフォーム -->
  <section class="mb-10 px-10">
    <!-- ↓バリエーションエラー -->
    @if($errors->any())
    <div class="bg-red-400 text-white p-1 rounded-lg mb-5">
      <ul>
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <!-- /バリデーション -->

    <form action="{{ route('user.reserve.store') }}" method="post">
      @csrf
      <input type="hidden" name="screen_id" value="{{ $screen->id }}">
      <select name="reserve_seat" id="seat" class="block w-1/4 mt-5 mx-auto">
        @foreach ($not_reserved_seats as $seat)
        <option value="{{ $seat }}">{{ $seat }}</option>
        @endforeach
      </select>
      <input type="button" value="予約する" class="block w-1/4 mt-5 mx-auto bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" data-modal-target="reserveCreateModal" data-modal-toggle="reserveCreateModal">
      
      <!-- モーダル -->
      <x-submit-modal :modalId="'reserveCreateModal'" >
        <x-slot name="modalTitle">
          予約してもよろしいですか？
        </x-slot>
      </x-submit-modal>
      <!-- /モーダル -->
    </form>
  </section>
  <!-- /予約されてない座席をセレクトボックスで選択する形式のフォーム -->
  @endif

</x-users.common>