<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <title>CINEMA HOUSE</title>
</head>

<body class="bg-gray-100">

  <header class="text-gray-600 body-font bg-purple-200">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
      <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0"
        href="/">
        <img class="w-10 h-10" src="{{ asset('images/icon.svg') }}" alt="">
        <span class="ml-3 text-xl">CINEMA HOUSE</span>
      </a>
      <span class="ps-2 text-xs font-semibold text-red-500">ユーザーページ</span>

    </div>
  </header>

  <section class="mt-7">
    <p class="ps-24 pb-5 text-xl">上映に参加したい場合は、下記から会員登録 or ログインしてください</p>
    <!-- 会員登録ボタンとログインボタンを表示。ボタンは中央寄せ。 -->
    <div class="flex justify-center gap-36 w-full">
      {{--
      <a href="{{ route('register') }}"
      class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 rounded-lg w-44 h-12 text-center flex items-center justify-center">会員登録</a>
      --}}
      <a href="{{ route('login') }}"
        class="bg-green-500 hover:bg-green-700 text-white font-bold px-4 rounded-lg w-44 h-12 text-center flex items-center justify-center">ログイン</a>
    </div>
  </section>


  <div class="relative py-6 w-11/12 mx-auto px-6">
    <div class="relative px-4 py-10 bg-white shadow rounded-xl sm:p-10">
      <div class="w-full mx-auto">
        <h1 class="text-3xl font-semibold mb-4">今後3か月の上映スケジュール</h1>
        <table class="min-w-full leading-normal">
          <colgroup>
            <col style="width: 25%;">
            <col style="width: 75%;">
          </colgroup>
          <thead>
            <tr>
              <th
                class="px-5 py-3 border-b-2 border-green-100 bg-green-200 text-left text-lg font-semibold text-gray-600 uppercase tracking-wider">
                上映日</th>
              <th
                class="px-5 py-3 border-b-2 border-green-100 bg-green-200 text-left text-lg font-semibold text-gray-600 uppercase tracking-wider">
                作品名</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($screens as $screen)
            <tr class="h-16">
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-base">
                {{ Carbon\Carbon::parse($screen->screening_date)->format('Y年m月d日') }}
              </td>
              <td class="px-5 py-5 border-b border-gray-200 bg-white text-base">
                {{ $screen->movie->title }}
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>


</body>

</html>