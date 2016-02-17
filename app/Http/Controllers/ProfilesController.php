<?php

namespace Flocc\Http\Controllers;

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
        return view('profiles.create');
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
            $id = \Flocc\Auth::getUserId();
        }

        $profile = Profile::where('user_id', $id)->firstOrFail();
        $is_mine = ($profile->user_id == \Flocc\Auth::getUserId());

        return view('dashboard', compact('profile', 'is_mine', 'id'));
    }

    /**
     * Get JSON with user time line
     *
     * @return string
     */
    public function timeLine()
    {
        $data   = [];

        $id     = \Input::get('user_id', \Flocc\Auth::getUserId());
        $type   = \Input::get('type', 'all');
        $start  = \Input::get('start', 0);
        $limit  = \Input::get('limit', 10);

        $profile = Profile::where('user_id', $id)->firstOrFail();

        foreach($profile->getTimeLine($type, $start, $limit) as $row) {
            $data[] = [
                'id'        => $row->getId(),
                'type'      => $row->getType(),
                'time'      => $row->getTime(),
                'message'   => $row->getMessage(),
                'html'      => view('partials.profiles.time_line.' . $row->getType(), array_merge($row->getMessage(), [
                    'time'          => $row->getTime()
                ]))->render()
            ];
        }

        return Response::json($data);
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
                return Response::json(['success' => true, 'file' => $updatedUrl]);
            }
            else {
              // sending back with error message.
              return Response::json('error', 400);
            }
        }
    }
}
