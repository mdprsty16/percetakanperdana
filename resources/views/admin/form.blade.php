<div class="mb-4">
    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Produk</label>
    <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400 sm:text-sm"
           required>
    @error('name')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
    <textarea name="description" id="description" rows="5"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                     dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400 sm:text-sm"
    >{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Harga</label>
    <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" step="0.01"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500
                  dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:border-blue-400 dark:focus:ring-blue-400 sm:text-sm"
           required>
    @error('price')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gambar Produk</label>
    <input type="file" name="image" id="image"
           class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                  file:rounded-full file:border-0 file:text-sm file:font-semibold
                  file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                  dark:file:bg-blue-900 dark:file:text-blue-200 dark:hover:file:bg-blue-800">
    @error('image')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
    @if (isset($product) && $product->image)
        <div class="mt-2">
            <p class="text-sm text-gray-600 dark:text-gray-400">Gambar saat ini:</p>
            <img src="{{ asset($product->image) }}" alt="Current Product Image" class="mt-2 w-32 h-32 object-cover rounded-md shadow-md">
        </div>
    @endif
</div>