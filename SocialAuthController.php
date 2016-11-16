<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;
use Session;


class SocialAuthController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function redirect($provider)
    {
		//settings in config/services.php
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        // when facebook call us a with token
		
		$currentuser = Auth::user();
		$providerUser = Socialite::driver($provider)->user();
		
		if ($provider == 'facebook')
		{
			$currentuser->facebookLink = 'http://facebook.com/' . $providerUser->getId();
			Session::flash('message','Your facebook account has been successfuly added.');	
		}
		elseif($provider == 'twitter')
		{
			$currentuser->twitterLink = 'https://twitter.com/intent/user?user_id=' . $providerUser->getId();
			Session::flash('message','Your twitter account has been successfuly added.');
		}
		elseif($provider == 'linkedin') //NOT YET IMPLEMENTED
		{
			$currentuser->facebookLink = ''; 
			Session::flash('message','Your LinkedIn account has been successfuly added.');
		}
		$currentuser->save();
		return redirect()->route('profile.settings');
    }
	public function deleteLink($provider)
	{
		$currentuser = Auth::user();
		if ($provider == 'facebook')
		{
			$currentuser->facebookLink = '';
			Session::flash('message','Your facebook account has been successfuly removed.');	
		}
		elseif($provider == 'twitter')
		{
			$currentuser->twitterLink = '';
			Session::flash('message','Your twitter account has been successfuly removed.');
		}
		elseif($provider == 'linkedin') //NOT YET IMPLEMENTED
		{
			$currentuser->linkedinLink = ''; 
			Session::flash('message','Your LinkedIn account has been successfuly removed.');
		}
		$currentuser->save();
		return redirect()->route('profile.settings');
	}
}
