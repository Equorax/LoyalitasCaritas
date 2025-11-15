<x-app-layout>
    <div class="min-h-screen bg-sky-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <!-- Salam sambutan -->
                <h1 class="text-xl font-bold text-gray-800 mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-600 mb-6">Upload file Excel (.CSV) yang berisi daftar ID Transaksi.</p>

                <!-- Form Upload -->
                <form method="POST" action="{{ route('upload.transaksi.process') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Input File -->
                    <div class="mb-4">
                        <label for="file" class="block text-sm font-medium text-gray-700 mb-1">Pilih File CSV</label>
                        <input type="file" name="file" id="file" accept=".csv" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                    </div>

                    <!-- Tombol Konfirmasi -->
                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Konfirmasi
                        </button>
                    </div>
                </form>

                <!-- Pesan Sukses dan Error -->
                @if(session('success'))
                    <div class="mt-4 p-3 bg-green-100 border-l-4 border-green-500 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mt-4 p-3 bg-red-100 border-l-4 border-red-500 text-red-700">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>