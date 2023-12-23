<x-admins.common>
  <x-slot name="title">
    上映スケジュール一覧
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">上映スケジュール一覧</h1>
  </section>

  <!-- スケジュール登録完了のフラッシュメッセージ -->
  <section>
    @if (session('screen_flash_message'))
    <div class="px-5 pt-3">
      <div class="border border-green-400 rounded bg-green-100 px-4 py-3 text-green-700">
        <p>{{ session('screen_flash_message') }}</p>
      </div>
    </div>
    @endif
  </section>
  <!-- /スケジュール登録完了のフラッシュメッセージ -->

  <x-calendar auth="admin"></x-calendar>

</x-admins.common>