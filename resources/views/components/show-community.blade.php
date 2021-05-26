<style>
/*THIS STYLING IS FOR TESTING ONLY -- REMOVE WHEN FINISHED*/
    .link{
        color: blue;
        text-decoration: none;
    }
    .link-btn{
        font-size: 2em;
        display: inline-block;
        background: white;
        border-radius: 50px;
        padding: 10px 20px 10px 20px;
        margin: 10px 10px 10px 10px;
    }
    .link-btn-text{
        margin: 0;
    }
</style>

<div>
    <div style="background-image: url('/storage/{{ $community->background_photo_path }}')">
        <div>
            <img src="/storage/{{ $community->community_photo_path }}" alt="" style="max-height: 200px;">
        </div>
        <div>
            <h1>{{ $community->name }}</h1>
            @if($member == 1)
                <a class="link details-link" href="/community/{{ $community->id }}/details"><div class="link-btn">
                        <p class="link-btn-text">i</p>
                </div></a>

                <input id="invite-btn" type="button" value="Invite Friends">
            @else
                <a class="link join-link" href="/community/{{ $community->id }}/invite"><div class="link-btn">
                        <p class="link-btn-text">Join Community</p>
                </div></a>
            @endif
        </div>

    </div>

    <div style="display: none" id="invite-popup">
        <h2>Send this link to your friends to invite them to {{ $community-> name }}</h2>
        <p id="invite-url">{{ url()->current() }}/invite</p>
        <input id="invite-close" type="button" value="Close">
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {

        $('#invite-btn').click(function(){
            $('#invite-popup').show();
        })

        $('#invite-close').click(function(){
            $('#invite-popup').hide();
        })
    });
</script>