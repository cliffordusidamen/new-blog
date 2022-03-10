<x-layouts.default>
    <h4>Login</h4>
    <form action="{{ route('authenticate') }}" method="post">
        @csrf


        @if($errors->any())
            <div class="text-danger small">
                Invalid credentials
            </div>
        @endif

        <div>
            <label for="email">Email</label><br />
            <input type="email" name="email" id="email" value="{{ old('email') }}" required />
        </div>

        <div>
            <label for="password">Password</label><br />
            <input type="password" name="password" id="password" value="{{ old('password') }}" required />
        </div>

        <div>
            <button type="submit">SUBMIT</button>
        </div>
    </form>
</x-layouts.default>