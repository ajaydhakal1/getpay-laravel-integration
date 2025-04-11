<x-app-layout>
    <div class="px-10 py-5 flex flex-wrap gap-6 justify-center">
        @foreach ($products as $product)
            <div
                class="w-[300px] h-[380px] flex flex-col justify-between p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-xl transition-transform transform hover:scale-105">
                <div class="flex flex-col gap-3">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                        class="w-full h-[220px] object-cover rounded-xl" />
                    <h2 class="text-xl font-bold text-black dark:text-white">{{ $product->name }}</h2>
                    <p class="text-lg font-semibold text-green-300">${{ $product->price }}</p>
                </div>
                <form action="/add-to-cart" method="POST">
                  @csrf
                  <input type="hidden" name="product_id" value="{{$product->id}}">
                    <button id="addToCart"
                        class="mt-3 w-full bg-white/20 dark:text-white text-black border border-gray-400/30 backdrop-blur-md py-2 rounded-full hover:bg-white/30 transition-colors">
                        ➕ Add To Cart
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-app-layout>
