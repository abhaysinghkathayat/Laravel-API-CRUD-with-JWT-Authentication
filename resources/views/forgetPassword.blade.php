<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forget Password</title>
</head>
<body style="display: flex; justify-content:center;">


    <div style="text-align:left">
        <div style="background:crimson; color: #ffffff;">
            <h1 style="margin-top: 100px;padding: 10px">Forget Password?</h1>
        </div>

        <p>Enter Your Registerd Email</p>
        <form id="forget_password">
            <label for="">Email: </label>
            <input type="email" name="email" placeholder="Enter email"><br><br>
            <button type="submit">Forget Password</button>
        </form>
        <p>asif@gmail.com</p>

        <ul id="error"></ul>
    </div>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            let DomainName = window.location.origin;
            $('#forget_password').submit(function(event){
                event.preventDefault();
                let formData = $(this).serialize();
                $('#error').empty()
                $.ajax({
                    url: `${DomainName}/api/forget-password`,
                    type: 'POST',
                    data: formData,
                    success: function(res){
                        console.log(res);
                        if (res.success == true) {
                            $('#error').append(`<li style="color:green">${res.msg}</li>`)
                        } else {
                            $('#error').append(`<li style="color:red">${res.msg}</li>`)
                        }
                    }
                })
            })
        })
    </script>

</body>
</html>
