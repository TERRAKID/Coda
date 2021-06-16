<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\UserFriend;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Inertia\Inertia;

class CommunityController extends Controller
{
    use UploadTrait;

    public function showAllCommunities(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $communities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
            ->where('community_member.user_id', '=', $currentUser)
            ->where('community_member.active', '=', 1)
            ->where('community.active', '=', 1)
            ->get();

        return Inertia::render('Community/Index')->with('communities', $communities)->with('user', auth()->user());
    }

    public function showCommunity($id){
        $currentUser = auth()->user();
        if($currentUser != null){
            $currentUser = $currentUser->id;
        }

        $community = Community::where('id', $id)
            ->where('active', '=', 1)
            ->get();
        
        if($community->isEmpty()){

            $communities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
                ->where('community_member.user_id', '=', $currentUser)->get();

            return Inertia::render('Community/Index')->with('communities', $communities)->with('user', auth()->user());
        }
        else{
            $community = $community[0];
        }
        

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        return Inertia::render('Community/Show')
            ->with('community', $community)
            ->with('isMember', $member);
    }

    //-----------------------------------------------------------------------
    
    public function communityDetails($id){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $checkCurrentUserIsMember = CommunityMember::where('user_id', '=', $currentUser)
            ->where('community_id', '=', $id)
            ->where('active', '=', '1')->count();

        if($checkCurrentUserIsMember != 0){
            $community = Community::where('id', $id)
                ->get();
            $community = $community[0];

            $users = User::join('community_member', 'community_member.user_id', '=', 'users.id')
                    ->where('community_member.community_id', '=', $community->id)
                    ->where('community_member.active', '=', '1')
                    ->get(['users.id']);
            $memberCount = $users->count();
            
            $communityMembers = [];

            foreach($users as $user){
                $communityMember = User::where('id', '=', $user['id'])->first();
                array_push($communityMembers, $communityMember);
            }
            
            if($community['created_by'] == $currentUser){
                $deletePermissions = 1;
            }
            else{
                $deletePermissions = 0;
            }
        }
        else{
            $community = null;
            $communityMembers = null;
            $memberCount = null;
            $deletePermissions = null;
        }

        return Inertia::render('Community/Details')
            ->with('community', $community)
            ->with('communityMembers', $communityMembers)
            ->with('memberCount', $memberCount)
            ->with('deletePermissions', $deletePermissions);
    }

    //-----------------------------------------------------------------------
    
    public function leaveCommunity($id){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];
        
        $query = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->update(['active' => 0]);
        
        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        if($query){
            return redirect('/community' . '/' . $id)
                ->with(['community' => $community], ['member' => $member])
                ->withSuccess('You have left ' . $community->name);
        }
        else{
            return back()
                ->with(['community' => $community], ['member' => $member])
                ->withFail('Something went wrong, try again later');
        }
    }

    //-----------------------------------------------------------------------
    
    public function communityInvite($id){
        $community = Community::where('id', $id)
            ->where('active', '=', 1)
            ->get();

        if($community->count() == 1){
            $community = $community[0];
        }
        else{
            $community = null;
        }
        
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();
        //dd($community);
        return Inertia::render('Community/Invite')
            ->with('community', $community)
            ->with('isMember', $member);
    }

    //-----------------------------------------------------------------------
    
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
            $query = CommunityMember::where('user_id', $currentUser)
                ->where('community_id', $id)
                ->update(['active' => 1, 'invited' => 0]);

            if($query){
                return Inertia::render('Community/Show')->with('community', $community)->with('isMember', $member);
            }
            else{
                return back()
                    ->with('community', $community)
                    ->with('member', $member)
                    ->withFail('Something went wrong, try again later');
            }
        }

        else if($member == 0){
            $communityMember->user_id = $currentUser;
            $communityMember->community_id = $id;
            $communityMember->active = 1;
            $communityMember->invited = 0;
    
            $query = $communityMember->save();

            if($query){
                return Inertia::render('Community/Show')->with('community', $community)->with('isMember', $member);
            }
            else{
                return back()
                    ->with('community', $community)
                    ->with('member', $member)
                    ->withFail('Something went wrong, try again later');
            }
        }
    }
    
    //-----------------------------------------------------------------------
    
    public function createCommunityShowUsers(){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $friends = [];
        $friends1 = UserFriend::where('user_friend.user_id', '=', $currentUser)
            ->where('user_friend.accepted', '=', '1')
            ->get('friend_id');

        $friends2 = UserFriend::where('user_friend.friend_id', '=', $currentUser)
            ->where('user_friend.accepted', '=', '1')
            ->get('user_id');

        $allFriends = [];

        if($friends1->count() > 0 || $friends2->count() > 0){
            foreach($friends1 as $friend){
                array_push($friends, $friend['friend_id']);
            }
            foreach($friends2 as $friend){
                array_push($friends, $friend['user_id']);
            }
            $friends = array_unique($friends);
    
            foreach($friends as $friend){
                $users = User::where('id', '=', $friend)->get();
                foreach($users as $user){
                    array_push($allFriends, $user);
                }
            }
        }
        else{
            $allFriends = null;
        }

        return Inertia::render('Community/Create')
            ->with('friends', $allFriends);

    }

    //-----------------------------------------------------------------------
    
    public function createCommunity(Request $request){
        $validator = $request->validate([
            'name' => 'required|max:255',
            'avatar' => 'max:2048',
            'banner' => 'max:2048',
        ]);
        $community = new Community;
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community->created_by = $currentUser;
        $community->name = request('name');
        $community->visibility = request('visibility');

        if ($request->has('avatar')) {

            $image = $request->file('avatar');

            $name = $request->input('name').'_'.time();
            $nameCheck1 = preg_replace('/[^a-zA-Z0-9\']/', '_', $name);
            $nameCheck2 = str_replace("'", '', $nameCheck1);
            $name = str_replace(' ', '_', $nameCheck2);
            
            $folder = 'community-avatars/';

            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            //this comes from /Traits/UploadTrait
            $this->uploadOne($image, $folder, 'public', $name);

            $community->community_photo_path = $filePath;
        }

        if ($request->has('banner')) {
            $image = $request->file('banner');

            $name = $request->input('name').'_'.time();
            $nameCheck1 = preg_replace('/[^a-zA-Z0-9\']/', '_', $name);
            $nameCheck2 = str_replace("'", '', $nameCheck1);
            $name = str_replace(' ', '_', $nameCheck2);

            $folder = 'community-banners/';

            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            //this comes from /Traits/UploadTrait
            $this->uploadOne($image, $folder, 'public', $name); 

            $community->background_photo_path = $filePath;
        }
        $community->save();

        $community = Community::where('name', request('name'))
            ->orderBy('id', 'DESC')
            ->take(1)
            ->get();
        $communityId = $community[0]->id;

        for($x = 0; $x <= 4; $x++){
            $communityMember = new CommunityMember;
            $value = request('invitee-' . $x);
            if(isset($value)){
                $communityMember->user_id = $value;
                $communityMember->community_id = $communityId;
                $communityMember->invited = '1';
                $communityMember->active = '0';

                $communityMember->save();
            }
        }

        $communityMember->user_id = $currentUser;
        $communityMember->community_id = $communityId;
        $communityMember->active='1';

        $communityMember->save();

        $community = Community::where('id', $communityId)
            ->get();
        $community = $community[0];

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $community)
            ->where('active', 1)
            ->count();

        return ($communityId);
    }

    public function deleteCommunity($id){
        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $community = Community::find($id);

        if($community){
            $community->active = '0';
            $community->save();
        }

        return redirect()->to('/diary')->send();
    }
}
