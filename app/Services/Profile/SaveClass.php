<?php

namespace App\Services\Profile;

use App\Models\User;
use App\Http\Resources\UserResource;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class SaveClass
{
    public function save($request){

        $user = User::find(\Auth::user()->id);
        if ($user->profile->avatar) {
            Storage::disk('public')->delete($user->profile->avatar);
        }

        $image = $request->file('image');

        $manager = new ImageManager(new Driver());

        // Read image
        $img = $manager->read($image);

        // Resize + convert to webp
        $img->cover(300, 300); // better than fit() in v3
        $webp = $img->toWebp(80);

        $filename = 'avatar_' . $user->username . '_' . time() . '.webp';
        $path = 'profile-pictures/' . $filename;
        Storage::disk('public')->put($path, $webp);
        
        $user->profile->avatar = $path;
        $user->profile->save();

        return [
            'data' => [],
            'message' => 'Profile picture updated successfully.', 
            'info' => "The user's profile image has been changed to the new photo."
        ];
    }

    public function update($request){
        $data = User::find(\Auth::user()->id);
        $data->email = $request->email;
        if($data->save()){
            $profile = $data->profile;
            $profile->firstname = $request->firstname;
            $profile->middlename = $request->middlename;
            $profile->lastname = $request->lastname;
            $profile->sex = $request->sex;
            $profile->mobile = $request->mobile;
            $profile->save();
        }
        
        return [
            'data' => new UserResource($data),
            'message' => 'User information updated successfully.', 
            'info' => "All relevant fields have been refreshed with the latest data."
        ];
    }

    public function destroy($request)
    {
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }
        $this->deleteOtherSessionRecords($request);
        return back(303);
    }

    protected function deleteOtherSessionRecords(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return;
        }
        \DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getAuthIdentifier())
            ->where('id', '!=', $request->session()->getId())
            ->delete();
    }
}
