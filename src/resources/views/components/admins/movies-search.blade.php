<!-- 検索フォーム -->
<section class="mt-5 px-5">

  <div id="accordion-open" data-accordion="open">
    <h2 id="accordion-open-heading-1">
      <button type="button"
        class="flex items-center justify-between w-full p-3 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
        data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
        <span class="flex items-center">検索</span>
        <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
          xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5 5 1 1 5" />
        </svg>
      </button>
    </h2>
    <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
      <!-- バリデーション -->
      @if($errors->any())
      <div class="bg-red-500 text-white p-1 rounded-lg mb-5">
        <ul>
          @foreach($errors->all() as $message)
          <li>{{ $message }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <!-- /バリデーション -->
      <form action="{{ route('admin.movies.index') }}" method="get">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
          <div class="grid gap-6 mb-6 md:grid-cols-3">
            <div>
              <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                タイトル
              </label>
              <input type="text" id="title" name="title" value="{{ $title }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div>
              <label for="production_year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                公開年(半角数字4桁で入力)
              </label>
              <input type="number" id="production_year" name="production_year" value="{{ $productionYear }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>
            <div>
              <label for="genre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                ジャンル
              </label>
              <!-- selectbox -->
              <select id="genre" name="genre"
                class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="">選択してください</option>
                @foreach(App\Consts\Genre::GENRE_LIST as $key => $value)
                <option value="{{ $key }}" @if($genre == $key) selected @endif>{{ $value }}</option>
                @endforeach
              </select>
              
            </div>
          </div>
          <!-- button -->
          <div class="flex justify-start space-x-20">
            <button type="submit"
              class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:bg-gray-700 dark:focus:ring-gray-600 dark:focus:border-gray-600 dark:active:bg-gray-900 dark:hover:border-gray-600 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              検索
            </button>

            <a href="{{ route('admin.movies.index') }}"
              class="inline-flex items-center justify-center px-4 py-2 ml-2 text-sm font-medium text-white bg-gray-500 border border-transparent rounded-md dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:bg-gray-700 dark:focus:ring-gray-600 dark:focus:border-gray-600 dark:active:bg-gray-900 dark:hover:border-gray-600 dark:hover:text-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              クリア
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>

</section>