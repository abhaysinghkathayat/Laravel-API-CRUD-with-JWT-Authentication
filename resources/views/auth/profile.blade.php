@extends('auth.master')

@section('title', 'Profile Page')

@section('content')
<button id="logout" style="position: absolute;top: 10px;right: 10px;background: #ff4848;color: white;padding: 5px 25px;font-size: 18px;cursor: pointer;border: 1px solid #19ce55;"
>Log Out</button>


<h1 style="margin-top: 0;background:#ff4848;color:aliceblue">User Profile</h1>
<h2 style="margin-top: 50px;">Hi, <span id="name" style="color:brown; font-weight:600"></span></h2>
<p style="color: steelblue; font-weight:600">Email: <span id="email"></span> <span id="verify"></span></p>

<form id="update_form">
    <input type="hidden" value="" name="id" id="user_id">
    <label for="">Your Name: </label>
    <input type="text" name="name" id="nameInput" placeholder="Enter name"><br><br>
    <label for="">Your Email: </label>
    <input type="email" name="email" id="emailInput" placeholder="Enter email"><br><br>
    <button type="submit" style="padding: 5px 15px; font-size:18px; background: limegreen;color:aliceblue;border: 0; cursor: ponter"
    >Update Profile</button>
</form>

<div id="error"></div>



@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>

    // Function to redirect to login page after token expiration and remove token from local storage
function redirectToLoginAfterExpiration(expirationTime) {
    const currentTime = Date.now();
    const timeUntilExpiration = expirationTime - currentTime;
    if (timeUntilExpiration > 0) {
        setTimeout(function() {
            // Remove token from local storage
            localStorage.removeItem('token');
            // Redirect to login page
            window.location.href = '/login';
        }, timeUntilExpiration);
    } else {
        // Token has already expired, remove it immediately
        localStorage.removeItem('token');
        // Redirect to login page
        window.location.href = '/login';
    }
}

// Function to check JWT token expiration
function checkTokenExpiration() {
    if (!token) {
        // Token not found, redirect to login page
        window.location.href = '/login';
        return;
    }
    // Decode the token to get expiration time
    const decodedToken = JSON.parse(atob(token.split('.')[1]));
    const expirationTime = decodedToken.exp * 1000; // Convert to milliseconds
    // Redirect to login page after token expiration and remove token from local storage
    redirectToLoginAfterExpiration(expirationTime);
}

        const DomainName = window.location.origin;
        // let token = localStorage.getItem('token');

        // fetching profile data from api
        $(document).ready(function(){
            checkTokenExpiration();
            $.ajax({
                url: `${DomainName}/api/profile`,
                type: 'GET',
                headers: {'Authorization': token},
                success: function(res){
                    if (res.success == true) {
                        console.log(res);
                        let data = res.data;
                        $('#name').text(data.name)
                        $('#email').text(data.email)
                        $('#nameInput').val(data.name)
                        $('#emailInput').val(data.email)
                        $('#user_id').val(data.id)

                        if (data.email_verified_at == null || data.email_verified_at == '' ) {
                            $('#verify').html(`<a href="">Verify</a>`);
                        } else {
                            $('#verify').html(`verified`);
                        }

                    } else {
                        res.msg
                    }
                }
            })
        })

        // logout click function
        $('#logout').on('click',function(){
            console.log('logout');
            $.ajax({
                url: `${DomainName}/api/logout`,
                type: 'GET',
                headers: {'Authorization': token},
                success: function(res){

                     if (res.success == true) {
                        console.log(res.msg);
                        localStorage.removeItem('token');
                        window.open('/login', '_self');
                    }
                }
            })
        })

        // update profile code
        $('#update_form').submit(function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            $('#error').empty()
            $.ajax({
                url: `${DomainName}/api/update-profile`,
                type: 'POST',
                data: formData,
                headers: {'Authorization': token},
                success: function(res){
                    if (res.success == true) {
                            $('#error').append(`<h3 style="color:green;">${res.msg}</h3>`)
                            setTimeout(() => {
                                $('#error').empty()
                            }, 1500);

                    } else if (res.success == false) {
                            $('#error').append(`<h3 style="color:red;">${res.msg}</h3>`)
                            setTimeout(() => {
                                $('#error').empty()
                            }, 1500);

                    } else {
                        $.each(res, function(key, value) {
                            $('#error').append(`<h3 style="color:red;">${value}</h3>`)
                        });
                        setTimeout(() => {
                                $('#error').empty()
                        }, 1500);
                    }
                }
            })
        })

        // {{-- 12345678 --}}


</script>
@endpush

