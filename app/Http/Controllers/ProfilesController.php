<?php

namespace Flocc\Http\Controllers;

use Flocc\Activities;
use Flocc\Tribes;
use Flocc\User\Features;
use Flocc\User\FreeTime;
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
     * @param int|null $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id = null)
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

            return view('dashboard', compact('profile', 'is_mine', 'activities', 'tribes', 'events_time_lines'));
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
            $validator  = \Validator::make($post, [
                'partying_id'       => 'required',
                'alcohol_id'        => 'required',
                'smoking_id'        => 'required',
                'imprecation_id'    => 'required',
                'plannings_id'      => 'required',
                'plans_id'          => 'required',
                'vegetarian_id'     => 'required',
                //'flexibility_id'    => 'required',
                //'plans_change_id'   => 'required',
                'verbosity_id'      => 'required',
                'vigor_id'          => 'required',
                'cool_id'           => 'required',
                'rules_id'          => 'required',
                'opinions_id'       => 'required',
                'tolerance_id'      => 'required',
                'compromise_id'     => 'required',
                'feelings_id'       => 'required',
                'emergency_id'      => 'required',
                'features'          => 'required',
                'free_time'         => 'required'

            ]);
            $errors     = $validator->errors();

            if($errors->count() == 0) {
                /**
                 * @var $profile \Flocc\Profile
                 */
                $profile
                    ->setPartyingId($post['partying_id'])
                    ->setAlcoholId($post['alcohol_id'])
                    ->setSmokingId($post['smoking_id'])
                    ->setImprecationId($post['imprecation_id'])
                    ->setPlanningsId($post['plannings_id'])
                    ->setPlansId($post['plans_id'])
                    ->setVegetarianId($post['vegetarian_id'])
                    //->setFlexibilityId($post['flexibility_id'])
                    //->setPlansChangeId($post['plans_change_id'])
                    ->setVerbosityId($post['verbosity_id'])
                    ->setVigorId($post['vigor_id'])
                    ->setCoolId($post['cool_id'])
                    ->setRulesId($post['rules_id'])
                    ->setOpinionsId($post['opinions_id'])
                    ->setToleranceId($post['tolerance_id'])
                    ->setCompromiseId($post['compromise_id'])
                    ->setFeelingsId($post['feelings_id'])
                    ->setEmergencyId($post['emergency_id'])
                ->save();

                $users_features     = new Features();
                $free_time_user     = new FreeTime();

                $users_features->clear(\Flocc\Auth::getUserId());
                $free_time_user->clear(\Flocc\Auth::getUserId());

                foreach($post['features'] as $feature_id) {
                    $users_features->addNew(\Flocc\Auth::getUserId(), $feature_id);
                }

                foreach($post['free_time'] as $free_time_id) {
                    $free_time_user->addNew(\Flocc\Auth::getUserId(), $free_time_id);
                }

                $message = "Successfully updated";
            }
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
}
