<x-layout>    
    <h1 class="title">Register a new account</h1>

    <div class="mx-auto max-w-screen-sm bg-white p-6 rounded-xl">
        <form action="{{ route('register') }}" method="POST">
            {{-- untuk keamanan setiap form dengan method post harus menyertakan csrf --}}
            @csrf 

            {{-- username --}}
            <div class="mb-4">
                <label for="username">Username</label>                
                <input type="text" name="username" class="@error('username') ring ring-red-500 @enderror" value="{{ old('username') }}"> {{-- harusnya berfungsi cmn gara2 cssnya aneh jd kaga --}}
                {{-- utnuk memanggil error mesage dari controller(tidak perlu try catch),  --}}
                @error('username') 
                    <p class="error">{{$message}}</p>
                @enderror
            </div>

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

            {{-- confirm password --}}
            <div class="mb-8">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input">                
            </div>
            
            {{-- submit button --}}
            <button class=" w-full text-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Register</button>
        </form>
    </div>
</x-layout>