<?php

namespace Flocc\Http\Controllers;

use Flocc\Activities;
use Flocc\Tribes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Input;
use Validator;
use Auth;
use URL;
use Response;

use Flocc\Http\Requests;
use Flocc\Http\Controllers\Controller;

use Flocc\User;
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
        $user_id    = \Flocc\Auth::getUserId();
        $users      = new User();
        $profile    = $users->getById($user_id)->getProfile();

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
        $profile = null;

        if($id === null) {
            $user_id = \Flocc\Auth::getUserId();
            $profile = Profile::where('user_id', $user_id)->firstOrFail();
        } else {
            $profile = Profile::findOrFail($id);
        }

        $is_mine            = ($profile->user_id == \Flocc\Auth::getUserId());
        $activities         = (new Activities())->get();
        $tribes             = (new Tribes())->get();

        $events_time_lines  = new Collection();

        foreach($profile->getTimeLine()->getLatestUpdatedEvents() as $event) {
            foreach($event->getTimeLine() as $line) {
                if($line->isMessage()) {
                    $events_time_lines->push([
                        'slug'      => $event->getSlug(),
                        'date'      => $line->getTime(),
                        'message'   => $line->getMessage()
                    ]);
                }
            }
        }

        $events_time_lines = $events_time_lines->sortByDesc('date')->slice(0, 5);

        return view('dashboard', compact('profile', 'is_mine', 'id', 'activities', 'tribes', 'events_time_lines'));
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
}
