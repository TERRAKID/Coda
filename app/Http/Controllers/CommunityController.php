<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommunityController extends Controller
{
    use UploadTrait;

    public function showCommunity($id){
        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        $currentUser = auth()->user();
        if($currentUser != null){
            $currentUser = $currentUser->id;
        }
        

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        return view('community.show', ['community' => $community], ['member' => $member]);
    }

    public function communityDetails($id){
        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        return view('community.details', ['community' => $community]);
    }

    public function leaveCommunity($id){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->update(['active' => 0]);
        
        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        return view('community.show', ['community' => $community], ['member' => $member]);
    }

    public function communityInvite($id){
        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        return view('community.invite', ['community' => $community], ['member' => $member]);
    }

    public function acceptInvite($id){
        $communityMember = new CommunityMember;

        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->count();

        if($member != 0){
            CommunityMember::where('user_id', $currentUser)
                ->where('community_id', $id)
                ->update(['active' => 1]);
        }

        elseif($member == 0){
            $communityMember->user_id = $currentUser;
            $communityMember->community_id = $id;
            $communityMember->active = 1;
    
            $communityMember->save();
        }

        return view('community.show', ['community' => $community], ['member' => $member]);
    }
    
    public function createCommunityShowUsers(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $friends = auth()->user()->friends()->get();

        return view('community.create', ['users' => $friends]);
    }

    public function createCommunity(Request $request){
        
        $validation = $request->validate([
            'name' => 'required|max:255',
            'avatar' => 'image|max:2048',
            'banner' => 'image|max:2048',
        ]);

        $community = new Community;

        $community->name = request('name');
        $community->visibility = request('visibility');

        if ($request->has('avatar')) {

            $image = $request->file('avatar');

            $name = $request->input('name').'_'.time();

            $folder = 'community-avatars/';

            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            //this comes from /Traits/UploadTrait
            $this->uploadOne($image, $folder, 'public', $name);

            $community->community_photo_path = $filePath;
        }

        if ($request->has('banner')) {
            $image = $request->file('banner');

            $name = $request->input('name').'_'.time();

            $folder = 'community-banners/';

            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            //this comes from /Traits/UploadTrait
            $this->uploadOne($image, $folder, 'public', $name); 

            $community->background_photo_path = $filePath;
        }
        
        $community->save();

        $community = \DB::table('community')
            ->select('id')
            ->where('name', request('name'))
            ->orderBy('id', 'DESC')
            ->take(1)
            ->get();
        
        $communityId = $community[0]->id;

        for($x = 0; $x <= 4; $x++){
            $communityMember = new CommunityMember;
            $value = request('invitee-' . $x);

            if(isset($value)){
                var_dump($value);
            
                $communityMember->user_id = $value;
                $communityMember->community_id = $communityId;
                $communityMember->invited = '1';
                $communityMember->active = '0';

                $communityMember->save();
            }
        }

        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community = Community::where('id', $communityId)
            ->get();
        $community = $community[0];

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $community)
            ->where('active', 1)
            ->count();

        return view('community.show', ['community' => $community], ['member' => $member]);
    }
}
