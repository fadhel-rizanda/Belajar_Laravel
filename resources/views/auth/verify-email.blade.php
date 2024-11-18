<x-layout>

    <h1 class="mb-4">Please verify your email through email we sent</h1>

    <p>Didnt get the email?</p>
    <form action="{{route('verification.send')}}" method="POST">
        @csrf
        <button class="btn">Send again</button>
    </form>

</x-layout>