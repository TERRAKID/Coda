@if(Session::has('fail'))
    <div class="alert alert-danger">
       {{Session::get('fail')}}
    </div>
@endif

<div>
    @if($member == 1)
        <h1>You are already a member of {{ $community->name }}</h1>
        <a href="/community/{{ $community->id }}">
            <input type="button" value="Go to community">
        </a>
    @else
        <h1>You have been invited to join {{ $community->name }}</h1>

        <form action="/community/{{ $community->id }}/invite" method="POST">
            @csrf
            <input type="submit" value="Click here to join">
        </form>
    @endif
</div>
