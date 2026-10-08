<header>
    
    <div class="bg-black h-20 w-full p-6">
        <div class="text-white font-bold text-xl flex justify-center gap-20">
            <a href="{{ route('dealers.index') }}">Dealer</a>
            <a href="{{ route('departments.index') }}">Department</a>
            <a href="{{ route('areas.index') }}">Area</a>
            <a href="{{ route('tasks.index') }}">Tugas</a>
        </div> 

        <form action="{{ route('logout') }}" method="POST">
            <div class="flex justify-end text-white font-black -mt-6.5">
                <button type="submit">
                    Logout
                </button>
            </div>
        </form>   
    
    </div>
    
</header>