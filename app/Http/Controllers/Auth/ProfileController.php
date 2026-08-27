<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\UserCertificate;
use App\Traits\HandlesTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Profile\ViewClass;
use App\Services\Profile\SaveClass;
use App\Services\Dashboard\AnalystClass;
use App\Services\Common\Signing\CertificateVerifier;
use App\Http\Requests\ProfileRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivationCode;

class ProfileController extends Controller
{
    use HandlesTransaction;

    public function __construct(ViewClass $view, SaveClass $save, CertificateVerifier $certificateVerifier, AnalystClass $analyst){
        $this->view = $view;
        $this->save = $save;
        $this->certificateVerifier = $certificateVerifier;
        $this->analyst = $analyst;
    }

    public function index(Request $request){
        $options = $request->option;
        switch($options){
            case 'authentication-logs':
                return $this->view->authenticationlogs($request);
            break;
            case 'activity-logs':
                return $this->view->activitylogs($request);
            break;
            case 'statistics':
                return $this->view->statistics($request);
            break;
            case 'sessions':
                return $this->view->sessions($request);
            break;
            case 'certificate-password-check':
                return $this->checkCertificatePassword($request);
            break;
            default:
            UserCertificate::firstOrCreate(['user_id' => \Auth::user()->id]);
            return inertia('Auth/Profile/Index',[
                'laboratories' => $this->analyst->laboratories()
            ]);
        }
    }

    public function store(Request $request)
    {   
        if($request->option == 'certificate'){
           
            $request->validate([
                'p12' => 'required|file'
            ]);
            if ($request->file('p12')->getClientOriginalExtension() !== 'p12') {
                return back()->withErrors(['p12' => 'The uploaded file must have a .p12 extension.']);
            }
            $result = $this->handleTransaction(function () use ($request) {

                $user = User::find(\Auth::user()->id);
                // Get the uploaded file
                $file = $request->file('p12');

                // Optional: generate a unique filename
                $filename = 'lims/certificates/' . $user->username . '.' . $file->getClientOriginalExtension();

                // Store in S3
                $path = $file->storeAs('', $filename, 's3');

                // Get full URL if needed
                $url = Storage::disk('s3')->url($path);

                // Find or create the UserCertificate
                // A newly uploaded certificate invalidates any previous password check.
                $certificate = UserCertificate::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'file' => $path, // save the S3 path
                        'is_checked' => false,
                    ]
                );

                   return [
                        'data' => [],
                        'message' => 'Certificate uploaded successfully.',
                        'info' => "The user's PNPKI certificate has been updated."
                    ];
            });
        }else if($request->option == 'certificate_password'){
            $request->validate([
                'password' => 'required|string|min:4'
            ]);

            $user = User::with('certificate')->find(\Auth::user()->id);
            $isChecked = false;

            if ($user->certificate && $user->certificate->file) {
                $verification = $this->certificateVerifier->verify($user->certificate->file, $request->password);

                if ($verification['checked'] && !$verification['valid']) {
                    throw ValidationException::withMessages([
                        'password' => 'The password you entered does not match your uploaded PNPKI certificate.',
                    ]);
                }

                $isChecked = $verification['checked'] && $verification['valid'];
            }

            $result = $this->handleTransaction(function () use ($request, $isChecked) {

                $user = User::find(\Auth::user()->id);

                UserCertificate::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'password' => $request->password,
                        'is_checked' => $isChecked,
                    ]
                );

                return [
                    'data' => [],
                    'message' => 'Certificate password saved successfully.',
                    'info' => 'The PNPKI certificate password has been updated.'
                ];
            });
        }else if($request->option == 'signature'){
            $request->validate([
                'signature' => 'required'
            ]);
           
            $result = $this->handleTransaction(function () use ($request) {

                $user = User::find(\Auth::user()->id);
                // Get the uploaded file
                $file = $request->file('signature');

                // Optional: generate a unique filename
                $filename = 'lims/signatures/' . $user->username . '.' . $file->getClientOriginalExtension();

                // Store in S3
                $path = $file->storeAs('', $filename, 's3');

                // Get full URL if needed
                $url = Storage::disk('s3')->url($path);

                // Find or create the UserCertificate
                $certificate = UserCertificate::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'signature' => $path
                    ]
                );

                   return [
                        'data' => [],
                        'message' => 'Profile picture updated successfully.', 
                        'info' => "The user's profile image has been changed to the new photo."
                    ];
            });
        }else{
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png|max:2048' // Assuming maximum file size is 2MB
            ],[
                'image.required' => 'Please upload an image.',
                'image.image' => 'The file must be a valid image.',
                'image.mimes' => 'Only JPEG or PNG images are allowed.',
                'image.max' => 'The image size must be less than 2MB.',
            ]);
            $result = $this->handleTransaction(function () use ($request) {
                return $this->save->save($request);
            });
        }
       

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function update(ProfileRequest $request){
        $result = $this->handleTransaction(function () use ($request) {
            return $this->save->update($request);
        });

        return back()->with([
            'data' => $result['data'],
            'message' => $result['message'],
            'info' => $result['info'],
            'status' => $result['status'],
        ]);
    }

    public function destroy(Request $request)
    {
        return $this->save->destroy($request);
    }

    public function activation(){
        return inertia('Auth/Activation');
    }

    public function activate(Request $request){
        $validated = $request->validate([
            'code' => ['required', 'digits:9'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()     // must include uppercase and lowercase
                    ->letters()       // must include letters
                    ->numbers()       // must include numbers
                    ->symbols()       // must include symbols
                    ->uncompromised() // checks against data leaks (optional)
            ],
        ]);
        $id = \Auth::user()->id;
        $user = User::findOrFail($id);
        if ($user->code !== $request->code) {
            throw ValidationException::withMessages([
                'code' => 'The activation code you entered is invalid.',
            ]);
        }
        $user->is_active = 1;
        $user->must_change = 0;
        $user->password = bcrypt($validated['password']);
        $user->password_changed_at = now();
        if($user->save()){
            return redirect()->intended(route('dashboard', absolute: false));
        }
    }

    protected function checkCertificatePassword(Request $request)
    {
        $user = User::with('certificate')->find(\Auth::user()->id);
        $certificate = $user->certificate;

        if (!$certificate || !$certificate->file || !$certificate->password) {
            return response()->json([
                'checked' => false,
                'valid' => true,
            ]);
        }

        $verification = $this->certificateVerifier->verify($certificate->file, $certificate->password);

        if ($verification['checked'] && $certificate->is_checked !== $verification['valid']) {
            $certificate->update(['is_checked' => $verification['valid']]);
        }

        return response()->json($verification);
    }

    public function verifyCertificatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);

        $user = User::with('certificate')->find(\Auth::user()->id);
        $certificate = $user->certificate;

        if (!$certificate || !$certificate->file) {
            return response()->json([
                'checked' => false,
                'valid' => true,
            ]);
        }

        $verification = $this->certificateVerifier->verify($certificate->file, $request->password);

        return response()->json($verification);
    }

    public function check(Request $request)
    {
        $request->validate([
        'code' => 'required|string|size:9',
        ]);

        $user = \Auth::user();
        $valid = $user->code === $request->code;

        return response()->json([
            'valid' => $valid,
        ]);
    }

    public function resend(Request $request)
    {
        $user = \Auth::user();
        $key = 'activation-resend:'.$user->id;

        if (RateLimiter::tooManyAttempts($key, 1)) {
            return response()->json([
                'available_at' => now()->addSeconds(RateLimiter::availableIn($key))->timestamp,
            ]);
        }

        RateLimiter::hit($key, 60);

        do {
            $code = random_int(100000000, 999999999);
        } while (User::where('code', $code)->exists());

        $user->update(['code' => $code]);
        Mail::to($user->email)->queue(new AccountActivationCode($user, $code));

        return response()->json([
            'available_at' => now()->addSeconds(60)->timestamp,
        ]);
    }

}
