@stack('js')
<script>

    let token = localStorage.getItem("token");
    console.log(token);
    let pathName = window.location.pathname;

    if (pathName == '/login' || pathName == '/register') {
        if (token != null ) {
            window.open('/profile', '_self')
        }
    } else {
        if (token == null ) {
            window.open('/login', '_self')
        }
    }


</script>
</body>
</html>





