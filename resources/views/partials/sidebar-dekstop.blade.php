{{-- KOLOM KANAN (25% / md:col-span-3) --}}
            <div class="hidden md:block md:w-1/4 flex-shrink-0 p-4 border-t border-l" style="width: 25%; min-width: 25%; max-width: 25%; flex: 0 0 25%;">
                <div class="sticky top-4">
                    <div class="flex items-center justify-between mb-2">
                    <h1 class="border-l-4 border-double border-sky-500 pl-4 italic leading-tight">
                        <span class="block text-sm md:text-lg text-gray-800 font-bold">Navigation</span>
                        <span class="block text-xs md:text-sm text-gray-400 italic">explore cultivID</span>
                    </h1>
                </div>
                    
                <div class="bg-white p-4 rounded shadow-sm border border-gray-200">
                        <p class="flex text-xs text-gray-500 italic text-left">
                            <ul class="my-6 space-y-3">
                                    <a href="{{ route('plant-submissions.create') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Plants & Hybrid</span>  
                                        
                                    </a>
                            </ul>
                            <ul class="my-6 space-y-3">
                                    <a href="{{ route('products.create') ?? '#' }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Product</span>  
                                        
                                    </a>
                            </ul>
                             <ul class="my-6 space-y-3">
                                    <a href="{{ route('post.create') ?? '#' }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Add Post</span>  
                                        
                                    </a>
                                </ul>
                        </p>
                    </div> 

                @auth
                    
                    <div class="bg-white p-4 rounded shadow-sm border border-gray-200 mt-3">
                        <p class="flex text-xs text-gray-500 italic text-left">
                            <ul class="my-6 space-y-3">
                                <a href="{{ route('wallet.index') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 12v6a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2h11l5 5z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 12h.01" />
                                    </svg>

                                    <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My Wallet</span>  
                                    
                                    <span class="text-heading text-xs font-medium px-1.5 py-0.5 text-gray-700 dark:text-gray-400">
                                      
                                            Rp {{ number_format(auth()->user()->balance, 0, ',', '.') }}
                                        
                                    </span>
                                    
                                </a>
                            </ul>
                            <ul class="my-6 space-y-3">
                                    <a href="{{ route('profile.edit') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 3.487a2.1 2.1 0 013.003 3.003L7.5 18.855 3 21l2.145-4.5L16.862 3.487z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Edit profile</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('plant-submissions.index') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 20V10m0 0c-3 0-6-2-6-5 3 0 6 2 6 5zm0 0c3 0 6-2 6-5-3 0-6 2-6 5z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My submissions</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('posts.by.username', auth()->user()->username) }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 4h6m-6 4h6m-6 4h6M5 20h14a1 1 0 001-1V7l-5-5H6a1 1 0 00-1 1v16a1 1 0 001 1z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My posts</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('products.by.username', auth()->user()->username) }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">My products</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <div class="flex dark:text-gray-400 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50  hover:bg-green-50  group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-700 dark:text-gray-400" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Dark mode</span>
                                        <span class="text-heading text-xs font-medium px-1.5 py-0.5"> 
                                            <button id="dark-mode-toggle" class="text-gray-700 dark:text-gray-400 text-sm">
                                            <i class="fas fa-toggle-on"></i>
                                            </button>
                                    </span>
                                    </div>
                                </ul>
                                 <ul class="my-6 space-y-3 bg-red-100">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf

                                        <button type="submit"
                                            class="group flex w-full items-center gap-3 rounded-base p-2
                                            text-sm font-semibold
                                            bg-red-100 hover:bg-red-50
                                            transition-colors rounded-full">

                                            <!-- Icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 shrink-0 text-gray-700"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8">
                                            <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h1a3 3 0 013 3v1" />
                                            </svg>

                                            <!-- Text -->
                                            <span class="flex-1 text-left whitespace-nowrap text-gray-700">
                                                Logout
                                            </span>
                                        </button>
                                    </form>
                                </ul>
                        </p>
                    </div>  
                   
                          
                    @else
                            
                    


                    <div class="bg-white p-4 rounded shadow-sm border border-gray-200 mt-3">
                        <p class="flex text-xs text-gray-500 italic text-left">
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('home') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10.5L12 3l9 7.5M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"/>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Home</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('login') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 17l5-5m0 0l-5-5m5 5H3"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Login / Register</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('all.products') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Market</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('index.sosmed') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <circle cx="9" cy="7" r="3"></circle>
                                            <circle cx="17" cy="7" r="3"></circle>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2
                                                    M13 15h4a4 4 0 014 4v2"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Community</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('admin.settings.about') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                            <circle cx="12" cy="12" r="9"></circle>
                                            <path d="M12 10v5"></path>
                                            <path d="M12 7h.01"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">About us</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('admin.settings.contact') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                            <path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Contact us</span>  
                                        
                                    </a>
                                </ul>
                                <ul class="my-6 space-y-3">
                                    <a href="{{ route('admin.settings.privacy') }}" class="flex dark:text-gray-50 dark:bg-gray-700 items-center p-2 gap-2 text-sm font-semibold text-heading rounded-base bg-gray-50 hover:bg-green-50 group" disabled>
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                            <path d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z"></path>
                                            <path d="M9 12l2 2 4-4"></path>
                                        </svg>

                                        <span class="flex-1 text-left whitespace-nowrap text-gray-700 dark:text-gray-400">Privacy policy</span>  
                                        
                                    </a>
                                </ul>


                        </p>
                    </div>  
                    
                 
                @endauth
                     
                </div>
            </div> 