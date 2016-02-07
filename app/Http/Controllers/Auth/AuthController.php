<?php

namespace Flocc\Http\Controllers\Auth;

use Flocc\Mail\Labels;
use Flocc\User;
use Flocc\Profile;
use Flocc\SocialProvider;
use Validator;
use Flocc\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Socialite;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */
    protected $redirectPath = '/';
    protected $loginPath = '/auth/login';

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            //'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $activation_code = str_random(30);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'activation_code' => $activation_code,
        ]);

        /**
         * mail_labels
         */
        (new Labels())->createDefaultLabels($user->id);

        return $user;
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        Mail::send('emails.verify', ['user' => $user], function ($m) use ($user) {
            $m->from('hello@flocc.eu', 'Flocc');
            $m->to($user->email, $user->name);
            $m->subject('Flocc registration');
        });

        $message = "Confirmation email sent. Please check your inbox.";

        return view('auth/login', compact('message', 'user'));
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->fields([
            'first_name', 'last_name', 'email', 'gender', 'birthday'
        ])->scopes([
            'email', 'user_birthday'
        ])->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->fields([
                'first_name', 'last_name', 'email', 'gender', 'birthday'
            ])->user();
        } catch (Exception $e) {
            return redirect('auth/facebook');
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser);

        return redirect('profile/'.$authUser->getProfile()->id);
    }

    private function findOrCreateUser($providerUser)
    {

        $soc = SocialProvider::where('provider_id', $providerUser->id)->first();
        if ($soc && $soc->user()) {
            return $soc->user;
        }

        $user = User::create([
            'name' => $providerUser->name,
            'email' => $providerUser->email,
            'active' => 1,
        ]);

        /**
         * mail_labels
         */
        (new Labels())->createDefaultLabels($user->id);

        $profile = Profile::create([
            'firstname' => $providerUser->user['first_name'],
            'lastname' => $providerUser->user['last_name'],
            'avatar_url' => $providerUser->avatar_original,
            'user_id' => $user->id
        ]);
        // G+ avatar
        // $user->avatar = preg_replace('/\?sz=[\d]*$/', '', $userData->avatar);

        $social = SocialProvider::create([
            'provider' => 'facebook',
            'provider_id' => $providerUser->id,
            'user_id' => $user->id
        ]);

        return $user;
    }

    public function verifyEmail($code)
    {
        $verifiedUser = User::where('activation_code', $code)->first();

        if ($verifiedUser) {
            $verifiedUser->active = 1;
            $verifiedUser->activation_code = '';
            $verifiedUser->save();
            Auth::login($verifiedUser);

            return redirect('/profile/create');
        }

        return redirect('auth/login');
    }

    public function authenticated(Request $request, User $user)
    {
        $profile = Profile::where('user_id', $user->id)->first();
        return redirect('/profile/'. $profile->id);
    }
}
