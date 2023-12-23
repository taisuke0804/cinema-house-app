<x-admins.common>
  <x-slot name="title">
    ダッシュボード
  </x-slot>

  <section class="bg-violet-200 mx-5 py-3 mt-10 rounded-md">
    <h1 class="ms-10 text-3xl font-bold text-slate-700">現在の登録状況</h1>
  
    <div class="pt-10 px-10">
      <div class="flex flex-row mb-3">
        <p class="text-2xl font-bold text-gray-700 w-80">映画登録本数</p>
        <p class="text-2xl font-bold text-gray-700">{{ $movies_count }}本</p>
      </div>
      <div class="flex flex-row mb-3">
        <p class="text-2xl font-bold text-gray-700 w-80">今後の上映スケジュール件数</p>
        <p class="text-2xl font-bold text-gray-700">{{ $screens_count }}件</p>
      </div>
      <div class="flex flex-row mb-3">
        <p class="text-2xl font-bold text-gray-700 w-80">座席予約の件数</p>
        <p class="text-2xl font-bold text-gray-700">{{ $seats_count }}件</p>
      </div>
    </div>
  </section>
</x-admins.common>