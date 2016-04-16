<?php

namespace Flocc\Http\Controllers;

use Flocc\Activities;
use Flocc\Tribes;
use Flocc\User;
use Flocc\User\Features;
use Flocc\User\Floccs\Floccs;
use Flocc\User\Floccs\Search;
use Flocc\User\FreeTime;
use Flocc\User\Settings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Input;
use Validator;
use Auth;
use URL;
use Response;
use Flocc\Http\Requests;
use Flocc\Profile;
use Flocc\Helpers\ImageHelper;

class ProfilesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profile = Auth::user()->getProfile();

        if(empty($profile)) {
            $profile = Profile::create([
                'user_id' => Auth::user()->id,
            ]);
        }

        return view('profiles.create', compact('profile'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = Auth::user()->id;

        $profile = new Profile($request->all());
        $profile->user_id = $id;
        $profile->avatar_url = URL::asset('img/avatar_'.$request->gender.'.png');

        $profile->save();

        $message = "Successfully updated";

        return view('profiles.edit', compact('message', 'profile'));
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\Illuminate\Http\Request $request, $id = null)
    {
        if($id === null) {
            $profile = Auth::user()->getProfile();
        } else {
            $profile = Profile::findOrFail($id);
        }

        $is_mine            = ($profile->user_id == \Flocc\Auth::getUserId());

        if($is_mine === true) {
            $activities         = (new Activities())->get();
            $tribes             = (new Tribes())->get();

            $events_time_lines  = new Collection();

            $users              = new User();
            $users_settings     = new Settings();
            $users_floccs       = new Floccs();
            $user               = $users->getById($profile->user_id);

            $user_flocc         = $users_floccs->getByUserIdOrEmail($profile->user_id, $user->getEmail());

            foreach($profile->getTimeLine()->getLatestUpdatedEvents() as $event) {
                foreach($event->getTimeLine() as $line) {
                    if($line->isMessage()) {
                        $events_time_lines->push([
                            'id'        => $event->getId(),
                            'slug'      => $event->getSlug(),
                            'event'     => $event->getTitle(),
                            'date'      => $line->getTime(),
                            'message'   => $line->getMessage()
                        ]);
                    }
                }
            }

            $events_time_lines = $events_time_lines->sortByDesc('date')->slice(0, 5);

            $flocc      = (new Search())->getFloccs(\Flocc\Auth::getUserId())->first();
            $message    = $request->session()->get('message');
            $show_modal = ($users_settings->get(\Flocc\Auth::getUserId(), 'profile.floccs.modal') === null) ? true : false;

            return view('dashboard', compact('profile', 'is_mine', 'activities', 'tribes', 'events_time_lines', 'flocc', 'message', 'show_modal', 'user_flocc'));
        } else {
            return view('profiles.show', compact('profile', 'is_mine', 'id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);

        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        // validation

        $profile->fill($request->all());
        $profile->save();

        $message = "Successfully updated";

        return view('profiles.edit', compact('message', 'profile'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function upload()
    {
        $profile = Auth::user()->getProfile();

        $image = Input::file('image');

        $validator = Validator::make(['image' => $image], ['image' => 'required']);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        else {
            if (Input::file('image')->isValid()) {
                $updatedUrl = (new ImageHelper())->uploadFile($image);
                $profile->avatar_url = $updatedUrl;
                $profile->save();
                return view('profiles.edit', compact('profile'));
            }
            else {
                // sending back with error message.
                return view('profiles.edit', compact('profile'))->withErrors('error', 'Upload failed');
            }
        }
    }

    /**
     * Update settings
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function editSettings($id)
    {
        /**
         * @var $profile \Flocc\Profile
         */
        $profile        = Profile::findOrFail($id);

        $partying       = Profile\Partying::all();
        $alcohol        = Profile\Alcohol::all();
        $smoking        = Profile\Smoking::all();
        $imprecation    = Profile\Imprecation::all();
        $plannings      = Profile\Plannings::all();
        $plans          = Profile\Plans::all();
        $vegetarian     = Profile\Vegetarian::all();
        $flexibility    = Profile\Flexibility::all();
        $plans_change   = Profile\PlansChange::all();
        $verbosity      = Profile\Verbosity::all();
        $vigor          = Profile\Vigor::all();
        $cool           = Profile\Cool::all();
        $rules          = Profile\Rules::all();
        $opinions       = Profile\Opinions::all();
        $tolerance      = Profile\Tolerance::all();
        $compromise     = Profile\Compromise::all();
        $feelings       = Profile\Feelings::all();
        $emergency      = Profile\Emergency::all();
        $features_sets  = Profile\Features::where(['is_set' => '1'])->get();
        $features       = Profile\Features::where(['is_set' => '0'])->get();
        $free_time      = Profile\FreeTime::all();

        if(!empty(\Input::get())) {
            $post       = \Input::get();

            if(isset($post['partying_id'])) {
                $profile->setPartyingId($post['partying_id']);
            }

            if(isset($post['alcohol_id'])) {
                $profile->setAlcoholId($post['alcohol_id']);
            }

            if(isset($post['smoking_id'])) {
                $profile->setSmokingId($post['smoking_id']);
            }

            if(isset($post['imprecation_id'])) {
                $profile->setImprecationId($post['imprecation_id']);
            }

            if(isset($post['imprecation_id'])) {
                $profile->setImprecationId($post['imprecation_id']);
            }

            if(isset($post['plannings_id'])) {
                $profile->setPlanningsId($post['plannings_id']);
            }

            if(isset($post['plans_id'])) {
                $profile->setPlansId($post['plans_id']);
            }

            if(isset($post['vegetarian_id'])) {
                $profile->setVegetarianId($post['vegetarian_id']);
            }

            if(isset($post['verbosity_id'])) {
                $profile->setVerbosityId($post['verbosity_id']);
            }

            if(isset($post['vigor_id'])) {
                $profile->setVigorId($post['vigor_id']);
            }

            if(isset($post['cool_id'])) {
                $profile->setCoolId($post['cool_id']);
            }

            if(isset($post['rules_id'])) {
                $profile->setRulesId($post['rules_id']);
            }

            if(isset($post['opinions_id'])) {
                $profile->setOpinionsId($post['opinions_id']);
            }

            if(isset($post['tolerance_id'])) {
                $profile->setToleranceId($post['tolerance_id']);
            }

            if(isset($post['compromise_id'])) {
                $profile->setCompromiseId($post['compromise_id']);
            }

            if(isset($post['feelings_id'])) {
                $profile->setFeelingsId($post['feelings_id']);
            }

            if(isset($post['emergency_id'])) {
                $profile->setEmergencyId($post['emergency_id']);
            }

            //->setFlexibilityId($post['flexibility_id'])
            //->setPlansChangeId($post['plans_change_id'])

            $profile->save();

            $users_features     = new Features();
            $free_time_user     = new FreeTime();

            $users_features->clear(\Flocc\Auth::getUserId());
            $free_time_user->clear(\Flocc\Auth::getUserId());

            if(isset($post['features'])) {
                foreach($post['features'] as $feature_id) {
                    $users_features->addNew(\Flocc\Auth::getUserId(), $feature_id);
                }
            }

            if(isset($post['free_time'])) {
                foreach($post['free_time'] as $free_time_id) {
                    $free_time_user->addNew(\Flocc\Auth::getUserId(), $free_time_id);
                }
            }

            $message = "Successfully updated";
        }

        return view('profiles.edit.settings', compact(
            'message', 'profile', 'partying', 'alcohol', 'smoking',
            'imprecation', 'plannings', 'plans', 'vegetarian',
            'flexibility', 'plans_change', 'verbosity', 'vigor',
            'cool', 'rules', 'opinions', 'tolerance', 'compromise',
            'feelings', 'emergency', 'features', 'features_sets',
            'errors', 'free_time'
        ));
    }

    /**
     * Update user floccs
     *
     * @param Request $request
     */
    public function editFloccs(\Illuminate\Http\Request $request)
    {
        $user_id        = \Flocc\Auth::getUserId();
        $users          = new User();
        $users_floccs   = new Floccs();
        $users_settings = new Settings();
        $user           = $users->getById($user_id);
        $user_flocc     = $users_floccs->getByUserIdOrEmail($user_id, $user->getEmail());

        $flocc          = ($user_flocc === null) ? $users_floccs : $user_flocc;
        $activity_id    = \Input::get('activity_id', null);
        $place          = \Input::get('place', '');
        $tribes         = (array) \Input::get('tribes', []);

        $flocc
            ->setUserId($user_id)
            ->setEmail($user->getEmail())
            ->setActivityId($activity_id)
            ->setPlace($place)
            ->setTribes($tribes)
        ->save();

        $users_settings->set($user_id, 'profile.floccs.modal', '1');

        $request->session()->flash('message', 'Ustawienia zostały zapisane');

        return redirect()->route('profile.my');
    }

    /**
     * Hide user floccs modal
     *
     * @param Request $request
     */
    public function editFloccsCancel(\Illuminate\Http\Request $request)
    {
        $user_id        = \Flocc\Auth::getUserId();
        $users_settings = new Settings();

        $users_settings->set($user_id, 'profile.floccs.modal', '1');

        $request->session()->flash('message', 'Ustawienia zostały zapisane');

        return redirect()->route('profile.my');
    }
}
