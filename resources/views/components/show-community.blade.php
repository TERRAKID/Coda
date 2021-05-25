<div>
    <div style="background-image: url('/storage/{{ $community->background_photo_path }}')">
        <div>
            <img src="/storage/{{ $community->community_photo_path }}" alt="" style="max-height: 200px;">
        </div>
        <div>
            <h1>{{ $community->name }}</h1>
            <a href="/community/{{ $community->id }}/details"><div>
                <p>i</p>
            </div></a>
        </div>

    </div>
</div>