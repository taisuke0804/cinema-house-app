<x-admins.common>
  <x-slot name="title">
    映画一覧
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">映画一覧</h1>
  </section>

  <section class="pt-3 ps-5">
    <a href="{{ route('admin.movies.create') }}" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded inline-block">
      映画登録
    </a>
  </section>

  <!-- フラッシュメッセージ -->
  <section>
    @if (session('movie_flash_message'))
    <div class="px-5 pt-3">
      <div class="border border-green-400 rounded bg-green-100 px-4 py-3 text-green-700">
        <p>{{ session('movie_flash_message') }}</p>
      </div>
    </div>
    @endif
  </section>
  <!-- /フラッシュメッセージ -->

  <!-- 検索フォーム -->
  <x-admins.movies-search :title="$title" :production-year="$production_year" :genre="$genre" />
  <!-- /検索フォーム -->

  <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead class="text-xs text-gray-700 uppercase bg-purple-200 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">
            タイトル
          </th>
          <th scope="col" class="px-6 py-3">
            公開年
          </th>
          <th scope="col" class="px-6 py-3">
            カテゴリー
          </th>
          <th scope="col" class="px-6 py-3">
            <span class="sr-only">Edit</span>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($movies as $movie)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
            {{ $movie->title }}
          </th>
          <td class="px-6 py-4">
            {{ $movie->production_year }}
          </td>
          <td class="px-6 py-4">
            {{ App\Consts\Genre::GENRE_LIST[$movie->genre] }}
          </td>
          <td class="px-6 py-4 text-right">
            <a href="{{ route('admin.movies.show', $movie->id) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">詳細</a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="mt-4">
      {{ $movies->links() }}
    </div>
  </div>



</x-admins.common>