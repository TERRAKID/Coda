
<form action="/community/create" method="POST" enctype="multipart/form-data">
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

    <div id="img_uploads">
        <div>
            <label for="avatar">Upload Avatar</label>
            <input type="file" name="avatar" placeholder="Upload Avatar">
        </div>
        <div>
            <label for="banner">Upload Banner</label>
            <input type="file" name="banner" placeholder="Upload Banner">
        </div>
    </div>

    <div id="community_details">
        <div>
            <label for="name">Community name</label>
            <input type="text" name="name" placeholder="Name">
        </div>
        <div>
            <label for="visibility">Community Visibility</label>
            <select name="visibility" id="community_visibility">
                <option value="1">Public</option>
                <option value="0">Private</option>
            </select>
        </div>
        <div>
            <label for="invite">Invite members</label>

            @foreach($users as $user)
                <div>
                    <label for="{{ $user->id }}">{{ $user->name }}</label>
                    <input type="checkbox" id="{{ $user->id }}" name="invitee-{{ $user->id }}">
                </div>
            @endforeach
        </div>
    </div>
    <input id="submit" type="submit" value="Create Community">
</form>