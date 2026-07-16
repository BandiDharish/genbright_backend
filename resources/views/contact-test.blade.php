<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Test</title>
</head>
<body>

    <h2>Test Contact Form</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <div style="color: red;">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('contact.submit') }}" method="POST">
        @csrf

        <p>
            <label>Full Name</label><br>
            <input type="text" name="name" required>
        </p>

        <p>
            <label>Mobile Number</label><br>
            <input type="text" name="phone" required>
        </p>

        <p>
            <label>Email Address</label><br>
            <input type="email" name="email" required>
        </p>

        <p>
            <label>Message</label><br>
            <textarea name="message"></textarea>
        </p>

        <button type="submit">Submit</button>
    </form>

</body>
</html>