@extends('auth.master')

@section('title', 'Profile Page')

@section('content')
<button id="logout" style="position: absolute;top: 10px;right: 10px;background: #ff4848;color: white;padding: 5px 25px;font-size: 18px;cursor: pointer;border: 1px solid dark;"
>Log Out</button>


<div style="margin:150px auto 0 auto ;background:#2ce0f8;color:aliceblue; width:620px;">
    <h1 style="padding: 10px">User Profile</h1>
</div>
<div class="content" style="margin:auto;width:620px;height:auto;display:flex;justify-content:space-evenly;align-items:center;gap:20px;border:1px solid #2ce0f8;">
    <div class="user-details">
        <h2 style="">Hi, <span id="name" style="color:brown;font-weight:600"></span></h2>
        <p style="color: brown; font-weight:600">Email: <span id="email"></span></p>
        <button id="verify" data-id="" style="border:0;margin-bottom:10px;"></button>
    </div>
    <div class="user-form">
        <form id="update_form">
            <input type="hidden" value="" name="id" id="user_id">
            <label for="name" style="color:#18a5b8;font-weight:600">Your Name: </label>
            <input style="border:1px solid #18a5b8;padding:2px;color:#18a5b8;outline:#18a5b8"
                type="text" name="name" id="nameInput" placeholder="Enter name"><br><br>
            <label for="email" style="color:#18a5b8;font-weight:600">Your Email: </label>
            <input style="border:1px solid #18a5b8;padding:2px;color:#18a5b8;outline:#18a5b8"
                type="email" name="email" id="emailInput" placeholder="Enter email"><br><br>
            <button type="submit" style="padding:5px 15px;font-size:16px;background:#157e8b;color:aliceblue;border:0;cursor:pointer"
            >Update Profile</button>
        </form>
    </div>
</div>
<div id="error" style="margin: auto; text-align:center"></div>






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
                        $('#verify').attr('data-id', data.email);

                        if (data.is_verified == 0 ) {
                            $('#verify').html(`<button id="verify-email">Verify</button>`);
                            $("#verify-email").css({ "background-color": "blue",
                                "padding": "5px 12px",
                                "color": "white",
                                "border": "1px solid black",
                                "cursor": "pointer",
                            });
                        } else {
                            $('#verify').html(`Verified`);
                            $("#verify").css({"font-size": "1rem",
                                "padding": "3px 6px",
                                "color": "limegreen",
                                "cursor": "pointer",

                            });
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

        // Email Verification
        $('#verify').on('click',function(){
            let mail = $(this).attr('data-id');
            console.log('verify click');
            $.ajax({
                url: `${DomainName}/api/send-verify-mail/${mail}`,
                type: 'GET',
                headers: {'Authorization': token},
                success: function(res){
                    $('#error').append(`<h3 style="color:green;">${res.msg}</h3>`)
                    setTimeout(() => {
                        $('#error').empty();
                    }, 5000);
                }
            })
         })

        // {{-- 12345678 --}}


</script>
@endpush

