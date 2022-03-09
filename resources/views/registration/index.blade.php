<x-layouts.default>
    <h4>Registration</h4>
    <form action="{{ route('register') }}" method="post">
        <div>
            <label for="name">Your name</label><br />
            <input type="text" name="name" id="name" />
        </div>

        <div>
            <label for="email">Email</label><br />
            <input type="email" name="email" id="email" />
        </div>

        <div>
            <label for="password">Password</label><br />
            <input type="password" name="password" id="password" />
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label><br />
            <input type="password" name="password_confirmation" id="password_confirmation" />
        </div>

        <div>
            <button type="submit">SUBMIT</button>
        </div>
    </form>
</x-layouts.default>