<header>
    
    <div class="bg-black h-20 w-full p-6">
        @if (@auth()->user()->role === 'supervisor')
        <div class="px-20 text-white font-bold text-xl flex justify-between relative">
            <div class="">
                <a class="mr-20" href="{{ route('dealers.index') }}">Dealer</a>
                <a class="mr-20" href="{{ route('departments.index') }}">Department</a>
                <a class="mr-20" href="{{ route('areas.index') }}">Area</a>
                <a class="mr-20" href="{{ route('tasks.index') }}">Tugas</a>
            </div>    
        @endif   
            <form action="{{ route('logout') }}" method="POST">
                <div class="text-white font-black">
                    <button type="submit">
                        Logout
                    </button>
                </div>
            </form>
         </div> 
    </div>
        
    
</header>