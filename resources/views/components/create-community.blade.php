
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
            <div>
                <img id="display-avatar-preview" src="" alt="" style="max-height: 150px;">
            </div>
            <div id="avatar-div">
                <label for="avatar">Upload Avatar</label>
                <input type="file" id="avatar" name="avatar" placeholder="Upload Avatar">
                <input type='button' id='remove-avatar' value='Remove File' style="display: none;">
            </div>
        </div>
        <div>
            <div>
                <img id="display-banner-preview" src="" alt="" style="max-height: 150px;">
            </div>
            <div>
                <label for="banner">Upload Banner</label>
                <input type="file" id="banner" name="banner" placeholder="Upload Banner">
                <input type='button' id='remove-banner' value='Remove File' style="display: none;">
            </div>
        </div>
    </div>

    <div id="community_details">
        <div>
            <label for="name">Community Name</label>
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
            <label for="invite">Invite Your Friends</label>
            <?php $x=0; ?>
            @foreach($users as $user)
                <div>
                    <label for="invitee-{{ $x }}">{{ $user->name }}</label>
                    <input type="checkbox" value="{{ $user->id }}" id="invitee-{{ $x }}" name="invitee-{{ $x }}">
                </div>
                <?php $x++; ?>
            @endforeach
        </div>
    </div>
    <input id="submit" type="submit" value="Create Community">
</form>

<script type="text/javascript">
     
    $(document).ready(function (e) {

        $('#avatar').change(function(){
            $('#remove-avatar').show();
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#display-avatar-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#remove-avatar').click(function(){
            $('#display-avatar-preview').attr('src', '');
            $('#avatar').val("");
            $('#remove-avatar').hide();
        });

        $('#banner').change(function(){
            $('#remove-banner').show();
            let reader = new FileReader();
            reader.onload = (e) => { 
              $('#display-banner-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]);
        });

        $('#remove-banner').click(function(){
            $('#display-banner-preview').attr('src', '');
            $('#banner').val("");
            $('#remove-banner').hide();
        });
    });
 
</script>