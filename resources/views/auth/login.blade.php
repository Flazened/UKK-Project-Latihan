<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"> 
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="flex justify-center p-20">
        <div class="bg-gray-200 h-200 w-150 rounded-3xl shadow-2xl">
            <form action="{{ route('login-post') }}">
                @csrf
                <div class="flex flex-col p-10">
                    <label for=""></label>
                </div>
            </form>
        </div>
    </div>
</body>
</html>