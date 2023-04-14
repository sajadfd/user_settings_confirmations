<div class="container">
    <div class="child">
        <h1>Add Setting</h1>

        <p>User: {{ $user->name }}</p>

        <form action="{{ route('settings.store', $user) }}" method="post">
            @csrf
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div>
                <label for="value">Value:</label>
                <input type="text" id="value" name="value" value="{{ old('value') }}" required>
            </div>
            <div>
                <label for="method">Confirmation Method:</label>
                <select id="method" name="method" required>
                    <option value="sms">SMS</option>
                    <option value="email">Email</option>
                    <option value="telegram">Telegram</option>
                </select>
            </div>
            <button type="submit">Add Setting</button>
        </form>
    </div>
</div>
