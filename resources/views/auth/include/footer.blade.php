@stack('js')
<script>

    let token = localStorage.getItem("token");
    console.log(token);
    let pathName = window.location.pathname;

    if (pathName == '/login' || pathName == '/register') {
        if (token != null ) {
            // window.open('/profile', '_self')
            window.location.href = '/profile';
        }
    } else {
        if (token == null ) {
            // window.open('/login', '_self')
            window.location.href = '/login';
        }
    }

    // if token expires then automatic go back to login page code
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
    $(document).ready(function(){
        checkTokenExpiration();
    });

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

    // refresh User Token
    $('#refresh_user').on('click',function(){
        console.log('refresh token');
        $.ajax({
            url: `${DomainName}/api/refresh-token`,
            type: 'GET',
            headers: {'Authorization': token},
            success: function(res){
                if (res.success == true) {
                    localStorage.setItem("token", `${res.token_type} ${res.token}`);
                    $('#error').append(`<h3 style="color:green;">User Refreshed</h3>`)
                    console.log(res.token);
                } else {
                    alert(res.msg);
                }

            }
        })
    })


</script>
</body>
</html>





