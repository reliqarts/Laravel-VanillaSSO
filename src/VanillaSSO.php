<?php
/**
 * This file contains part of the client code for Vanilla jsConnect single sign on. It was adapted to support Laravel.
 *
 * @author Todd Burry <todd@vanillaforums.com>
 *
 * @version 1.3b
 *
 * @copyright Copyright 2008, 2009 Vanilla Forums Inc.
 * @license http://www.opensource.org/licenses/gpl-2.0.php GPLv2
 *
 * @link https://github.com/vanilla/jsConnectPHP/blob/master/functions.jsconnect.php
 */
namespace ReliQArts\VanillaSSO;

use Config;
use Log;

define('JS_TIMEOUT', 24 * 60);

/**
 *  VanillaSSO.
 */
class VanillaSSO
{
    /**
     * Write the jsConnect string for single sign on.
     *
     * @param array       $User    An array containing information about the currently signed on user. If no user is signed in then this should be an empty array.
     * @param array       $Request An array of the $_GET request.
     * @param string|bool $Secure  Whether or not to check for security. This is one of these values.
     *                             - true: Check for security and sign the response with an md5 hash.
     *                             - false: Don't check for security, but sign the response with an md5 hash.
     *                             - string: Check for security and sign the response with the given hash algorithm. See hash_algos() for what your server can support.
     *                             - null: Don't check for security and don't sign the response.
     *
     * @since 1.1b Added the ability to provide a hash algorithm to $Secure.
     *
     * @return string JSON response formatted.
     */
    public static function WriteJsConnect($User, $Request, $Secure = true)
    {
        $User = array_change_key_case($User);
        $ClientID = Config::get('vanillasso.client_id');
        $Secret = Config::get('vanillasso.secret');

        // Error checking.
        if ($Secure) {
            // Check the client.
            if (! isset($Request['client_id'])) {
                $Error = ['error' => 'invalid_request', 'message' => 'The client_id parameter is missing.'];
            } elseif ($Request['client_id'] != $ClientID) {
                $Error = ['error' => 'invalid_client', 'message' => "Unknown client {$Request['client_id']}."];
            } elseif (! isset($Request['timestamp']) && ! isset($Request['signature'])) {
                if (is_array($User) && count($User) > 0) {
                    // This isn't really an error, but we are just going to return public information when no signature is sent.
                    $Error = ['name' => $User['name'], 'photourl' => @$User['photourl']];
                } else {
                    $Error = ['name' => '', 'photourl' => ''];
                }
            } elseif (! isset($Request['timestamp']) || ! is_numeric($Request['timestamp'])) {
                $Error = ['error' => 'invalid_request', 'message' => 'The timestamp parameter is missing or invalid.'];
            } elseif (! isset($Request['signature'])) {
                $Error = ['error' => 'invalid_request', 'message' => 'Missing  signature parameter.'];
            } elseif (($Diff = abs($Request['timestamp'] - self::JsTimestamp())) > JS_TIMEOUT) {
                $Error = ['error' => 'invalid_request', 'message' => 'The timestamp is invalid.'];
            } else {
                // Make sure the timestamp hasn't timed out.
                $Signature = self::JsHash($Request['timestamp'].$Secret, $Secure);
                if ($Signature != $Request['signature']) {
                    $Error = ['error' => 'access_denied', 'message' => 'Signature invalid.'];
                }
            }
        }

        if (isset($Error)) {
            $Result = $Error;
        } elseif (is_array($User) && count($User) > 0) {
            if ($Secure === null) {
                $Result = $User;
            } else {
                $Result = self::SignJsConnect($User, $ClientID, $Secret, $Secure, true);
            }
        } else {
            $Result = ['name' => '', 'photourl' => ''];
        }

        $Json = json_encode($Result);

        if (Config::get('vanillasso.debug', false)) {
            Log::info($Json);
        }

        if (isset($Request['callback'])) {
            return "{$Request['callback']}($Json)";
        } else {
            return $Json;
        }
    }

    protected static function SignJsConnect($Data, $ClientID, $Secret, $HashType, $ReturnData = false)
    {
        $Data = array_change_key_case($Data);
        ksort($Data);

        foreach ($Data as $Key => $Value) {
            if ($Value === null) {
                $Data[$Key] = '';
            }
        }

        $String = http_build_query($Data, null, '&');
        $Signature = self::JsHash($String.$Secret, $HashType);

        if (Config::get('vanillasso.debug', false)) {
            // Log::info($Data);
            Log::info($String);
            Log::info($Signature);
        }
        if ($ReturnData) {
            $Data['client_id'] = $ClientID;
            $Data['signature'] = $Signature;

            return $Data;
        } else {
            return $Signature;
        }
    }

    /**
     * Return the hash of a string.
     *
     * @param string      $String The string to hash.
     * @param string|bool $Secure The hash algorithm to use. TRUE means md5.
     *
     * @return string
     *
     * @since 1.1b
     */
    protected static function JsHash($String, $Secure = true)
    {
        if ($Secure === true) {
            $Secure = 'md5';
        }

        switch ($Secure) {
            case 'sha1':
                return sha1($String);
                break;
            case 'md5':
            case false:
                return md5($String);
            default:
                return hash($Secure, $String);
        }
    }

    protected static function JsTimestamp()
    {
        return time();
    }

    /**
     * Generate an SSO string suitible for passing in the url for embedded SSO.
     *
     * @param array  $User     The user to sso.
     * @param string $ClientID Your client ID.
     * @param string $Secret   Your secret.
     *
     * @return string
     */
    protected static function JsSSOString($User, $ClientID, $Secret)
    {
        if (! isset($User['client_id'])) {
            $User['client_id'] = $ClientID;
        }

        $String = base64_encode(json_encode($User));
        $Timestamp = time();
        $Hash = hash_hmac('sha1', "$String $Timestamp", $Secret);

        $Result = "$String $Hash $Timestamp hmacsha1";

        return $Result;
    }
}
