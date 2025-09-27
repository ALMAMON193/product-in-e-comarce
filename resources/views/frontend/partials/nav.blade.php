 <aside class="w-full lg:w-72 rounded-xl shadow-2xl p-6 lg:sticky lg:top-8 bg-white">
     <h3 class="text-xl font-bold mb-6 tracking-tight text-gray-900">Refine Your Selection</h3>

     <!-- Categories -->
     <div class="mb-8">
         <h4 class="font-semibold text-gray-600 mb-4">Categories</h4>
         <div class="space-y-3">
             <label class="flex items-center cursor-pointer group">
                 <input type="radio" name="category" value="all" wire:model="category"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">All
                     Products</span>
             </label>

             @foreach ($categories as $cat)
                 <label class="flex items-center cursor-pointer group">
                     <input type="radio" name="category" value="{{ $cat->id }}" wire:model="category"
                         class="text-amber-400 focus:ring-amber-400 transition duration-200">
                     <span
                         class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">{{ $cat->name }}</span>
                 </label>
             @endforeach
         </div>
     </div>

     <!-- Price Ranges -->
     <div class="mb-8">
         <h4 class="font-semibold text-gray-600 mb-4">Price Range</h4>
         <div class="space-y-3">
             <label class="flex items-center cursor-pointer group">
                 <input type="checkbox" value="under_25" wire:model="priceRanges"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">Under
                     $25</span>
             </label>
             <label class="flex items-center cursor-pointer group">
                 <input type="checkbox" value="25_50" wire:model="priceRanges"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">$25 -
                     $50</span>
             </label>
             <label class="flex items-center cursor-pointer group">
                 <input type="checkbox" value="50_100" wire:model="priceRanges"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">$50 -
                     $100</span>
             </label>
             <label class="flex items-center cursor-pointer group">
                 <input type="checkbox" value="100_200" wire:model="priceRanges"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">$100 -
                     $200</span>
             </label>
             <label class="flex items-center cursor-pointer group">
                 <input type="checkbox" value="over_200" wire:model="priceRanges"
                     class="text-amber-400 focus:ring-amber-400 transition duration-200">
                 <span class="ml-3 text-sm group-hover:text-amber-500 transition duration-200">Over
                     $200</span>
             </label>
         </div>
     </div>
 </aside>
