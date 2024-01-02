<x-admins.common>
  <x-slot name="title">
    上映スケジュール登録
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">上映スケジュール登録</h1>
  </section>

  <section class="pt-3 ps-5">
    <a href="{{ route('admin.movies.show', $movie->id) }}"
      class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded inline-block">
      この作品の詳細に戻る
    </a>
  </section>

  <!-- 上映スケジュール登録フォーム -->
  <section class="pt-3 pb-10 px-5">
    <form action="{{ route('admin.screens.store', $movie->id) }}" method="post">
      @csrf
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
      <div class="mb-4">
        <label for="title" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">タイトル</label>
        <p class="text-xl font-bold text-gray-700">『{{ $movie->title }}』</p>
      </div>

      <!-- 上映日の登録 -->
      <div class="mb-4">
        <label for="screening_date" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">上映日</label>
        <input type="date" name="screening_date" id="screening_date"
          class="w-1/6 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300"
          value="{{ old('screening_date') }}" />
      </div>
      <!-- /上映日の登録 -->
      <!-- 上映開始時間 -->
      <div class="mb-4">
        <label for="start_time" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">上映開始時間</label>
        <div class="flex gap-5 items-center">
          <select name="start_time_hour" id="start_time_hour"
            class="w-1/6 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300">
            <option value="">時</option>
            @for($i = 0; $i < 24; $i++) <option value="{{ $i }}" @if(old('start_time_hour')==$i) selected @endif>
              {{ $i }}
              </option>
              @endfor
              
          </select>
          <span class="">時</span>
          <select name="start_time_minute" id="start_time_minute"
            class="w-1/6 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300">
            <option value="">分</option>
            @for($i = 0; $i < 60; $i++) <option value="{{ $i }}" @if(old('start_time_minute')==$i) selected @endif>
              {{ $i }}
              </option>
              @endfor
          </select>
          <span class="">分</span>
        </div>
      </div>
      <!-- /上映開始時間 -->
      <!-- 上映終了時間 -->
      <div class="mb-4">
        <label for="end_time" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">上映終了時間</label>
        <div class="flex gap-5 items-center">
          <select name="end_time_hour" id="end_time_hour"
            class="w-1/6 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300">
            <option value="">時</option>
            @for($i = 0; $i < 24; $i++) <option value="{{ $i }}" @if(old('end_time_hour')==$i) selected @endif>
              {{ $i }}
              </option>
              @endfor
          </select>
          <span class="">時</span>
          <select name="end_time_minute" id="end_time_minute"
            class="w-1/6 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300">
            <option value="">分</option>
            @for($i = 0; $i < 60; $i++) <option value="{{ $i }}" @if(old('end_time_minute')==$i) selected @endif>
              {{ $i }}
              </option>
              @endfor
          </select>
          <span class="">分</span>
        </div>
      </div>
      <!-- /上映終了時間 -->
      <div class="mb-4 pt-4">
        <button type="button" data-modal-target="screenCreateModal" data-modal-toggle="screenCreateModal"
          class="w-28 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm focus:outline-none focus:shadow-outline">
          登録
        </button>
      </div>

      <!-- モーダル -->
      <x-submit-modal :modalId="'screenCreateModal'" >
        <x-slot name="modalTitle">
          上映スケジュール新規登録
        </x-slot>
      </x-submit-modal>
      <!-- /モーダル -->

    </form>
  </section>
  <!-- /上映スケジュール登録フォーム -->

</x-admins.common>