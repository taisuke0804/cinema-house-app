<x-users.common>
  <x-slot name="title">
    予約完了
  </x-slot>

  <section class="px-5 pt-3">
    <h1 class="text-3xl font-bold text-gray-500">予約完了</h1>
  </section>

  
  <section class="mt-5 p-5 bg-purple-200 mx-5 rounded">
    <h2 class="text-center text-3xl font-bold">作品名： {{ $title }}</h2>
    <h2 class="text-center text-3xl font-semibold">{{ $reserve_flash_message }}</h2>

    <div class="mt-4 w-2/5 mx-auto">
      <p class="text-lg font-medium">マイページの予約詳細画面をご確認ください。</p>
      <p class="text-lg font-medium">上映日当日、予約詳細画面を提示して入場の確認とさせていただきます。</p>
    </div>
  </section>
  

</x-users.common>