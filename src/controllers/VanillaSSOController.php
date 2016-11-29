<?php

namespace ReliQArts\VanillaSSO\Http\Controllers;

use Auth;
use Config;
use App\Http\Controllers\Controller;
use ReliQArts\VanillaSSO\SSOUser;
use ReliQArts\VanillaSSO\VanillaSSO;

/**
 *  VanillaSSOController.
 */
class VanillaSSOController extends Controller
{
    /**
     * Produces jsonResponse.
     *
     * @return Response
     */
    public function jsonResponse()
    {
        $user = Auth::user();

        //Change here whatever you need
        $ssoUser = new SSOUser();
        $ssoUser->id = $user->id;
        $ssoUser->name = $user->username;
        $ssoUser->email = $user->email;
        $ssoUser->roles = $user->roles;
        $ssoUser->profilePicture = str_replace('{user_id}', $user->id, Config::get('vanillasso.profile_pic_url'));

        $userInfo = $ssoUser->toArray();

        die(VanillaSSO::WriteJsConnect($userInfo, $_GET, true));
    }
}
