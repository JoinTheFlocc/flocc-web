<?php

namespace Flocc\Http\Controllers;

use Illuminate\Http\Request;

use Flocc\Http\Requests;
use Flocc\Http\Controllers\Controller;
use Auth;
use URL;

use Flocc\User;
use Flocc\Profile;

class ProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = NULL)
    {
        if (!$id) {
            $profile = Profile::where('user_id', Auth::user()->id)->firstOrFail();
        } else {
            $profile = Profile::findOrFail($id);
        }
<<<<<<< HEAD

        $id      = (int) $id;
        $profile = Profile::findOrFail($id);
        $is_mine = ($id == (int) Auth::user()->id);
=======
>>>>>>> profile-fix
        
        return view('dashboard', compact('profile', 'is_mine', 'id'));
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
}
