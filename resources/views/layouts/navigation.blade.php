<nav class="bg-white border-b border-gray-200 px-4 py-3">
    <div class="flex justify-between items-center">
        <div>
            <a href="{{ route('dashboard') }}" class="text-xl font-semibold text-gray-800">Dashboard</a>
        </div>
        <div>
            <span class="mr-4 text-gray-700">{{ Auth::user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">Sair</button>
            </form>
        </div>
    </div>
</nav>
