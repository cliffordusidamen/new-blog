<x-layouts.default>
    <h4>Registration</h4>
    <form action="{{ route('register') }}" method="post">
        @csrf
        <div>
            <label for="name">Your name</label><br />
            <input type="text" name="name" id="name" value="{{ old('name') }}" required />
            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email">Email</label><br />
            <input type="email" name="email" id="email" value="{{ old('email') }}" required />
            @error('email')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password">Password</label><br />
            <input type="password" name="password" id="password" value="{{ old('password') }}" required />
            @error('password')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label><br />
            <input type="password" name="password_confirmation" id="password_confirmation" required />
        </div>

        <div>
            <button type="submit">SUBMIT</button>
        </div>
    </form>
</x-layouts.default>