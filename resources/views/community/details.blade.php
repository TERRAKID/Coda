<html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@if(Session::has('fail'))
    <div class="alert alert-danger">
       {{Session::get('fail')}}
    </div>
@endif
    
    @component('../components/community-details', ['community' => $community])@endcomponent

</html>