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
    
    <input id="leave-btn" class="btn danger-btn" type="button" value="Leave Community">

    <form id="leave-community-form" style="display: none;" action="/community/{{ $community->id }}/details" method="POST">
        @csrf
        <h3>Are you sure you want to leave {{ $community->name }}?</h3>
        <input id="leave-confirm" class="btn danger-btn" type="submit" value="Leave Community">
        <input id="leave-cancel" type="button" value="Cancel">
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {

        $('#leave-btn').click(function(){
            $('#leave-community-form').show();
        })

        $('#leave-cancel').click(function(){
            $('#leave-community-form').hide();
        })
    });
</script>