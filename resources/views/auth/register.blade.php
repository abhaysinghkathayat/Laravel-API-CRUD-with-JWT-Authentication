<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register Page | User</title>
</head>
<body>
    <h1>Register A User</h1>
    <form id="register_form">
        <label for="">Your Name: </label>
        <input type="text" name="name" placeholder="Enter name"><br><br>
        <label for="">Your Email: </label>
        <input type="email" name="email" placeholder="Enter email"><br><br>
        <label for="">Your Password: </label>
        <input type="password" name="password" placeholder="Enter password"><br><br>
        <label for="">Confirm Passowrd: </label>
        <input type="password" name="password_confirmation" placeholder="Enter confirm password"><br><br>
        <button type="submit">Submit</button>
    </form>
    <ul id="error" style="color:red"></ul>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js" integrity="sha512-PJa3oQSLWRB7wHZ7GQ/g+qyv6r4mbuhmiDb8BjSFZ8NZ2a42oTtAq5n0ucWAwcQDlikAtkub+tPVCw4np27WCg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(){
        let DomainName = window.location.origin;
        $('#register_form').submit(function(event){
            event.preventDefault();
            let formData = $(this).serialize();
            $('#error').empty()
            $.ajax({
                url: `${DomainName}/api/register`,
                type: 'POST',
                data: formData,
                success: function(res){
                    let errors = res.errors
                    if (errors) {
                        $.each(errors, function(key, value) {
                            if (key == 'password') {
                                if (value.length > 1) {
                                    $('#error').append(`<li>${value[0]}</li>
                                                        <li>${value[1]}</li>`)
                                } else {
                                    if (value[0].includes('password confirmation')) {
                                        $('#error').append(`<li>${value}</li>`)
                                    } else {
                                        $('#error').append(`<li>${value}</li>`)
                                    }
                                }
                            } else {
                                $('#error').append(`<li>${value}</li>`)
                            }
                        })
                    } else {
                        $('#register_form')[0].reset()
                        console.log(res.msg);
                    }
                }
            })
        })
    })
</script>

</body>
</html>

