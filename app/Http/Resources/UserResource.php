<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
         return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'avatar' => $this->profile?->avatar,
            'avatar_name' => $this->profile->avatar,
            'name' => $this->profile->fullname,
            'firstname' => $this->profile->firstname,
            'lastname' => $this->profile->lastname,
            'middlename' => $this->profile->middlename,
            'sex' => $this->profile->sex,
            'agency' => $this->profile?->agency_id,
            'facility' => $this->profile?->facility ? [
                'id' => $this->profile->facility->id,
                'name' => $this->profile->facility->name,
                'is_regional' => (bool) $this->profile->facility->is_regional,
            ] : null,
            'suffix' => $this->profile->suffix,
            'mobile' => $this->profile->mobile,
            'profile_id' => $this->profile->id,
            'is_active' => $this->is_active,
            'must_change' => $this->must_change,
            'two_factor_enabled' => ($this->two_factor_secret) ? true : false,
            'two_factor_confirmed' => ($this->two_factor_confirmed_at) ? true : false,
            'password_changed_at' => $this->password_changed_at,
            'password_confirmed_at' => session('auth'),
            'certificate' => $this->certificate ? [
                'has_p12' => (bool) $this->certificate->file,
                'has_signature' => (bool) $this->certificate->signature,
                'has_password' => (bool) $this->certificate->password,
                'signature_url' => $this->certificate->signature
                    ? Storage::disk('s3')->temporaryUrl(
                        $this->certificate->signature,
                        now()->addMinutes(30)
                    )
                    : null,
                'expires_at' => $this->certificate->expires_at,
                'updated_at' => $this->certificate->updated_at,
            ] : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
