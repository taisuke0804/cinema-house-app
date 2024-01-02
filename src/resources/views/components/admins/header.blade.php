<header class="text-gray-600 body-font bg-sky-100">
  <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
    <a class="flex title-font font-medium items-center text-gray-900 mb-4 md:mb-0" href="{{ route('admin.dashboard') }}">
      <img class="w-10 h-10" src="{{ asset('images/icon.svg') }}" alt="">
      <span class="ml-3 text-xl">CINEMA HOUSE</span>
    </a>
    <span class="ps-2 text-xs font-semibold text-red-500">管理画面</span>
    <nav class="md:mr-auto md:ml-4 md:py-1 md:pl-4 md:border-l md:border-gray-400	flex flex-wrap items-center text-base justify-center">
      <a href="{{ route('admin.dashboard') }}" class="mr-5 hover:text-gray-900">HOME</a>
      <a href="{{ route('admin.movies.index') }}" class="mr-5 hover:text-purple-600">映画一覧</a>
      <a href="{{ route('admin.screens.index') }}" class="mr-5 hover:text-gray-900">上映情報</a>
    </nav>
    <form action="{{ route('admin.logout') }}" method="post">
      @csrf
      <button class="inline-flex items-center bg-gray-100 border-0 py-1 px-3 focus:outline-none hover:bg-gray-200 rounded text-base mt-4 md:mt-0">ログアウト
        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-1" viewBox="0 0 24 24">
          <path d="M5 12h14M12 5l7 7-7 7"></path>
        </svg>
      </button>
    </form>
  </div>
</header>

