<html>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
@if(Session::has('success'))
    <div class="alert alert-success">
        {{Session::get('success')}}
    </div>
@endif
    
    @component('../components/show-community', ['community' => $community, 'member' => $member])@endcomponent

</html>