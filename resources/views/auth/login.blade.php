<x-layout>    
    <h1 class="title">Login to your account</h1>

    <div class="mx-auto max-w-screen-sm bg-white p-6 rounded-xl">
        <form action="{{ route('login') }}" method="POST">
            {{-- untuk keamanan setiap form dengan method post harus menyertakan csrf --}}
            @csrf 

            {{-- email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" class="input" value="{{old('email')}}">
                @error('email') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            {{-- password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="input">
                @error('password') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

            <div class="mb-4 flex gap-1">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">remember me</label>
            </div>
            
            @error('failed') {{-- namanya sesuain sm yg di controller --}}
                    <p class="error">{{$message}}</p>
            @enderror
            
            {{-- submit button --}}
            <button class=" w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Login</button>
        </form>
    </div>
</x-layout>