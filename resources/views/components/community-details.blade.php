<div>
    <div id="group-members">
        <div class="members-header header">
            <div>
                <h2>Group members</h2>
                <input type="search" name="memberSearch" id="">
            </div>
            <p></p>
        </div>
        <div id="member-list">
            <article></article>
        </div>
    </div>

    <div id="community-goals">
        <div class="goals-header header">
            <h2>Community Goals</h2>
        </div>
        <div id="goals-list">
            <article></article>
        </div>
    </div>

    <div id="movie-month">
        <div class="movie-month-header header">
            <h2>Group members</h2>
        </div>
        <div id="movie-month-list">
            <article>
                <img src="" alt="">
                <h3></h3>
                <p></p>
                <p></p>
            </article>
        </div>
    </div>

    <div id="polls">
        <div class="polls-header header">
            <h2>Polls</h2>
        </div>
        <div id="polls-list">
            <article>
                <div class="poll-info">
                    <img src="" alt="">
                    <h3></h3>
                    <p></p>
                </div>
            </article>
        </div>
    </div>

    <form action="/community/{{ $community->id }}/details" method="POST">
        @csrf
        @if( $flash = session('message') )
            <div class="alert alert-success">{{ $flash }}</div>
        @endif

        @if( $flash = session('error') )
            <div class="alert alert-danger">{{ $flash }}</div>
        @endif

        @if( $errors->any())
            <ul class="alert alert-danger">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        @endif

        <input class="btn danger-btn" type="button" value="Leave Community">
    </form>
</div>