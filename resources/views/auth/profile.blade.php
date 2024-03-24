@extends('auth.master')

@section('title', 'Profile Page')

@section('content')
<h1>User Profile</h1>

<button id="logout">Log Out</button>

@endsection

@push('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
        const DomainName = window.location.origin;
        // let token = localStorage.getItem('token');
        $('#logout').on('click',function(){
            $.ajax({
                url: `${DomainName}/api/logout`,
                type: 'GET',
                headers: {'Authorization': token},
                success: function(res){
                    if (res.success == true) {
                        console.log(res.msg);
                        localStorage.removeItem('token');
                        window.open('/login', '_self');
                    } else {
                        alert(res.msg);
                    }
                }
            })
        })
</script>
@endpush

