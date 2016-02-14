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

use Flocc\Helpers\ImageHelper;

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

    public function redirectToProvider($provider)
    {
        $providerKey = \Config::get('services.' . $provider);

        switch ($provider) {
            case 'facebook':
                return Socialite::with($provider)->fields([
                    'first_name', 'last_name', 'email', 'gender', 'birthday'
                ])->scopes([
                    'email', 'user_birthday'
                ])->redirect();
                break;
            case 'google':
                return Socialite::with($provider)->scopes([
                    'email', 'profile'
                ])->redirect();
                break;
            case 'live':
                return Socialite::with('live')->scopes([
                    'wl.basic', 'wl.birthday'
                ])->redirect();
                break;
            default:
                return \Redirect::back()->with('error', 'No such provider');
                break;
        }
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('auth.login')->with('error', 'Social login failed');
        }

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser);

        return redirect('profile/'.$authUser->getProfile()->id);
    }


    private function findOrCreateUser($providerUser, $provider)
    {
        $user = null;

        $emailCheck = User::where('email', $providerUser->email)->first();
        if(!empty($emailCheck)) {
            $soc = SocialProvider::where('provider_id', $providerUser->id)->where('provider', $provider)->first();
            if ($soc && $soc->user()) {
                return $soc->user;
            }
            // User email already in use, create new SocialProvider record
            $social = SocialProvider::create([
                'provider' => $provider,
                'provider_id' => $providerUser->id,
                'user_id' => $emailCheck->id
            ]);
            return $emailCheck;
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

        $firstname = "";
        $lastname = "";

        if (!empty($providerUser->user['first_name']))
            $firstname = $providerUser->user['first_name'];
        if (!empty($providerUser->user['last_name']))
            $lastname = $providerUser->user['last_name'];

        $avatar = null;
        switch ($provider) {
            case 'facebook':
                $avatar = preg_replace('/=[\d]*$/', '=320', $providerUser->avatar_original);
                break;
            case 'google':
                $avatar = preg_replace('/\?sz=[\d]*$/', '', $providerUser->avatar);
                break;
        }

        $fileName = (new ImageHelper())->cloneSocial($avatar);
        if (empty($fileName))
            $fileName = $avatar;

        $profile = Profile::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'avatar_url' => $fileName,
            'user_id' => $user->id
        ]);

        $social = SocialProvider::create([
            'provider' => $provider,
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
