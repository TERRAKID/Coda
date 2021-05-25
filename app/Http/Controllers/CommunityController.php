<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;

class CommunityController extends Controller
{
    use UploadTrait;
    
    public function index(){
        $users = \DB::table('users')
            ->take(10)
            ->get();

        return view('community.create', ['users' => $users]);
    }

    public function create(Request $request){
        $community = new Community;

        $community->name = request('name');
        $community->visibility = request('visibility');

        if ($request->has('avatar')) {
            // Get image file
            $image = $request->file('avatar');
            // Make an image name based on user name and current timestamp
            $name = $request->input('name').'_'.time();
            // Define folder path
            $folder = 'community-photos/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $community->community_photo_path = $filePath;
        }

        if ($request->has('banner')) {
            // Get image file
            $image = $request->file('banner');
            // Make an image name based on user name and current timestamp
            $name = $request->input('name').'_'.time();
            // Define folder path
            $folder = 'community-photos/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
            $this->uploadOne($image, $folder, 'public', $name);
            // Set user profile image path in database to filePath
            $community->background_photo_path = $filePath;
        }

        for($x = 0; $x <= 5; $x++){
            
        }

        $community->save();
        return redirect()->back()->with(['message' => "Your Community, '" . request('name') . "', was created successfully."]);
    }
}
