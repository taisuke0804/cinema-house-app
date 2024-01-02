<x-admins.common>
  <x-slot name="title">
    映画詳細
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">映画詳細</h1>
  </section>

  <section class="pt-3 ps-5">
    <a href="{{ route('admin.movies.index') }}"
      class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded inline-block">
      映画一覧に戻る
    </a>
  </section>

  <!-- $movieの詳細情報 -->
  <section class="pt-3 px-5 mb-10">
    <!-- タイトル -->
    <div class="flex justify-start my-5">
      <h2 class="text-4xl font-extrabold text-gray-700">{{ $movie->title }}</h2>
    </div>
    <!-- /タイトル -->
    <!-- ポスター画像 -->
    <div class="flex justify-start mb-5">
      @if($movie->poster_image_path)
      <img src="{{ asset('storage/posters/' . $movie->poster_image_path) }}" alt="{{ $movie->title }}"
        class="w-52 h-52">
      @else
      <img src="{{ asset('images/poster_noimage.jpg') }}" alt="{{ $movie->title }}" class="w-52 h-52">
      @endif
    </div>
    <!-- /ポスター画像 -->

    <div class="py-3">
      <a href="{{ route('admin.screens.create', $movie->id) }}"
        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded inline-block">
        この作品を上映スケジュール登録
      </a>
    </div>

    <div class="py-3">
      <a href="{{ route('admin.movies.edit', $movie->id) }}" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded inline-block mr-10">
        映画情報の編集
      </a>
      <form action="{{ route('admin.movies.destroy', $movie->id) }}" class="inline-block" method="post">
        @csrf
        @method('DELETE')
        <button type="button" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded inline-block" data-modal-target="movieDeleteModal" data-modal-toggle="movieDeleteModal">
          映画情報の削除
        </button>

        <!-- モーダル -->
        <x-submit-modal :modalId="'movieDeleteModal'" >
          <x-slot name="modalTitle">
            映画情報を削除してもよろしいですか？
          </x-slot>
        </x-submit-modal>
        <!-- /モーダル -->
      </form>
    </div>

    <!-- 公開年 -->
    <div class="flex flex-row mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">公開年</p>
      <p class="text-xl font-bold text-gray-700">{{ $movie->production_year }}</p>
    </div>
    <!-- /公開年 -->
    <!-- ジャンル -->
    <div class="flex mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">ジャンル</p>
      <p class="text-xl font-bold text-gray-700">{{ App\Consts\Genre::GENRE_LIST[$movie->genre] }}</p>
    </div>
    <!-- /ジャンル -->
    <!-- 説明文 -->
    <div class="flex mb-3">
      <p class="text-xl font-bold text-gray-700 w-48">説明文</p>
      <p class="text-lg font-bold text-gray-700	w-3/4	">
        {!! nl2br(e($movie->description)) !!}
      </p>
    </div>
    <!-- /説明文 -->
  </section>
  <!-- /$movieの詳細情報 -->

</x-admins.common>