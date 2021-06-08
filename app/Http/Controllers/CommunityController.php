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

        //$members = CommunityMember::where('user_id', $currentUser)->get();

        $communities = Community::join('community_member', 'community_member.community_id', '=', 'community.id')
            ->where('community_member.user_id', '=', $currentUser)->get();

        return Inertia::render('Community/Index')->with('communities', $communities)->with('user', auth()->user());
    }

    public function showCommunity($id){
        $currentUser = auth()->user();
        if($currentUser != null){
            $currentUser = $currentUser->id;
        }

        $community = Community::where('id', $id)
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

        return Inertia::render('Community/Show')->with('community', $community)->with('isMember', $member);
    }

    //-----------------------------------------------------------------------
    
    public function communityDetails($id){
        $community = Community::where('id', $id)
            ->get();
        $community = $community[0];

        return Inertia::render('Community/Details')->with('community', $community);
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
            ->get();
        $community = $community[0];

        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

        $member = CommunityMember::where('user_id', $currentUser)
            ->where('community_id', $id)
            ->where('active', 1)
            ->count();

        return Inertia::render('Community/Invite')->with('community', $community)->with('isMember', $member);
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
                ->update(['active' => 1]);

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
    
            $query = $communityMember->save();

            if($query){
                return Inertia::render('Community/Show')->with('community', $community)->with('isMember', $member);
                /*
                return redirect('/community' . '/' . $id)
                    ->with(['community' => $community], ['member' => $member])
                    ->withSuccess('You have joined ' . $community->name);
                */
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

        $friends = auth()->user()->friends()->take(6)->get();
        return Inertia::render('Community/Create')->with('friends', $friends);
    }

    //-----------------------------------------------------------------------
    
    public function createCommunity(Request $request){
        $validator = $request->validate([
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

        $currentUser = auth()->user();
        $currentUser = $currentUser->id;

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

        return Inertia::render('Community/Show')->with('community', $community)->with('isMember', $member);
    }
}
