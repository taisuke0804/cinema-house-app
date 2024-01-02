<x-admins.common>
  <x-slot name="title">
    映画情報編集
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">映画情報編集</h1>
  </section>

  <section class="pt-3 pb-10 px-5">
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
      @method('PATCH')
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

      <!-- update完了のフラッシュメッセージ -->
      @if(session('movie_update_message'))
      <div class="bg-green-400 text-white p-1 rounded-lg mb-5">
        {{ session('movie_update_message') }}
      </div>
      @endif
      <!-- /update完了のフラッシュメッセージ -->

      <div class="mb-4">
        <label for="title" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">タイトル</label>
        <input type="text" name="title" id="title"
          class="w-1/2 px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300"
          value="{{ $movie->title }}" />
      </div>

      <div class="grid md:grid-cols-2 gap-6 mb-4">
        <div>
          <label for="production_year" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">
            公開年
          </label>
          <input type="number" name="production_year" id="production_year"
            class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300"
            value="{{ $movie->production_year }}" />
        </div>
        <div>
          <label for="genre" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">
            ジャンル
          </label>
          <select name="genre" id="genre"
            class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300">
            <option value="">選択してください</option>
            @foreach(App\Consts\Genre::GENRE_LIST as $key => $value)
            <option value="{{ $key }}" @if( $movie->genre ==$key) selected @endif>{{ $value }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="mb-4">
        <label for="description" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">説明</label>
        <textarea name="description" id="description" cols="30" rows="8"
          class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300 resize-none">{{ $movie->description }}</textarea>
      </div>

      <!-- ポスター画像 upload -->
      <div class="mb-4" x-data="imageUpload('{{ $poster_image_path }}')">
        <label for="poster_image" class="block mb-2 text-sm text-gray-600 dark:text-gray-400 font-medium">ポスター画像</label>
        <input type="file" name="poster_image" id="poster_image"
          class="w-full px-3 py-2 border rounded shadow-sm focus:outline-none focus:shadow-outline text-gray-600 dark:text-gray-300"
          x-ref="fileInput" @change="previewImage" />

        <!-- 既存画像の削除ボタン -->
        <button type="button" class="w-36 px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded shadow-sm focus:outline-none focus:shadow-outline my-2 text-sm" @click="removeImage">
          登録画像の削除
        </button>
        <input type="hidden" name="image_removed" x-model="imageRemoved" />
        <!-- /既存画像の削除ボタン -->

        <!-- 画像プレビュー表示 -->
        <img x-show="imageUrl" :src="imageUrl" alt="Image Preview" class="w-52 h-52">
      </div>
      <!-- /ポスター画像 upload -->

      <div class="mb-4">
        <button type="button" data-modal-target="movieEditModal" data-modal-toggle="movieEditModal"
          class="w-28 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded shadow-sm focus:outline-none focus:shadow-outline">
          登録
        </button>
      </div>

      <!-- モーダル -->
      <x-submit-modal :modalId="'movieEditModal'" >
        <x-slot name="modalTitle">
          映画情報の編集更新
        </x-slot>
      </x-submit-modal>
      <!-- /モーダル -->

    </form>
  </section>

  <!-- 画像プレビューのメソッド -->
  <script>
    function imageUpload(savedImageUrl = '') {
      return {
        imageUrl: savedImageUrl,
        imageRemoved: '', // hidden inputをバインドするための変数

        previewImage() {
          const fileInput = this.$refs.fileInput;
          if (fileInput.files && fileInput.files[0]) {
            const reader = new FileReader();

            reader.onload = (e) => {
              this.imageUrl = e.target.result;
              this.imageRemoved = ''; // 画像が選択されたら、hidden inputの値をリセット
            }

            reader.readAsDataURL(fileInput.files[0]);
          }
        },

        removeImage() {
          this.imageUrl = '';
          this.$refs.fileInput.value = ''; // inputファイルの選択をクリア
          this.imageRemoved = '1'; // 画像削除ボタンが押されたら、hidden inputの値を設定
        }
      }
    }

  </script>
  <!-- /画像プレビューのメソッド -->
</x-admins.common>