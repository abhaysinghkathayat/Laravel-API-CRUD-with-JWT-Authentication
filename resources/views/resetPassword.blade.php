
@if($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
    </ul>
@endif

<h1>Reset Your Password</h1>

<form method="POST">
    @csrf
    <input type="hidden" name="id" value="{{ $user[0]['id'] }}">
    <label for="">Password: </label>
    <input type="password" name="password" placeholder="Enter new password"><br><br>
    <label for="">Confirm Password: </label>
    <input type="password" name="password_confirmation" placeholder="Confirm Password"><br><br>
    <input type="submit">
</form>


