<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\ShippingAddress;
use App\BillingAddress;
use App\Country;
use App\State;
use App\City;
use Auth;
use Redirect;
use View;
use Hash;

class AccountController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        if (Auth::check()) {
            $users = User::where('id', Auth::id())->first();
            $shipping_address = ShippingAddress::where('user_id', Auth::id())->first();
            $billing_address = BillingAddress::where('user_id', Auth::id())->first();
            $countries = Country::get(array('name', 'id'));
            return View::make('accounts.account', compact('users', 'shipping_address', 'billing_address', 'countries'));
        }
        return redirect('/login');
    }

    /**
     * Update profile function.
     *
     * @return Response
     */
    public function updateProfile(Request $request) {
        $data = $request->all();

        $validator = Validator::make($data, [
                    'first_name' => 'required|max:50',
                    'last_name' => 'required|max:50'
        ]);

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $type = $image->getClientMimeType();
            if ($type == 'image/png' || $type == 'image/jpg' || $type == 'image/jpeg') {
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $path = base_path('public/user_images/');
                $image->move($path, $filename);
                $data['user_image'] = $filename;
            }
        }

        $users = User::findOrFail(Auth::id());
        $users->fill($data)->save();
        return response()->json(['success' => true, 'messages' => "Profile updated successfully."]);
    }

    /**
     * Update shipping function.
     *
     * @return Response
     */
    public function updateShipping(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
                    'address1' => 'required|max:150',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city' => 'required',
                    'zip' => 'required|max:6'
        ]);


        $data = $this->getLatLong($data['state_id'], $data['city'], $data['address1'], $data['zip']);

        $data['user_id'] = Auth::id();

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }

        $shippings = ShippingAddress::where('user_id', Auth::id())->first();
        if (!empty($shippings)) {
            $shippings->fill($data)->save();
        } else {
            ShippingAddress::create($data);
            BillingAddress::create($data);   // billing address same as shipping address when user enter first time
        }
        return response()->json(['success' => true, 'messages' => "Shipping address updated successfully."]);
    }

    /**
     * function to get latitude and longitude.
     *
     * @return Response
     */
    public function getLatLong($state_id, $city, $address, $zip) {
        $states = State::where('id', $state_id)->first();

        $address = str_replace(" ", "+", $states->get_countries->name) . "+" . str_replace(" ", "+", $states->name) . "+" . str_replace(" ", "+", $city) . "+" . str_replace(" ", "+", $address) . "+" . $zip;
        $url = "http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=USA";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        if (isset($response_a->results[0]->geometry->location->lat)) {
            $result['latitude'] = $response_a->results[0]->geometry->location->lat;
            $result['longitude'] = $response_a->results[0]->geometry->location->lng;
        } else {
            $result['latitude'] = null;
            $result['longitude'] = null;
        }
        return $result;
    }

    /**
     * Update billing function.
     *
     * @return Response
     */
    public function updateBilling(Request $request) {

        $data = $request->all();
        $validator = Validator::make($data, [
                    'address1' => 'required|max:150',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'city' => 'required',
                    'zip' => 'required|max:6'
        ]);

        $data['user_id'] = Auth::id();

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }

        $billings = BillingAddress::where('user_id', Auth::id())->first();
        if (!empty($billings)) {
            $billings->fill($data)->save();
        } else {
            BillingAddress::create($data);
            ShippingAddress::create($data); // billing address same as shipping address when user enter first time
        }
        return response()->json(['success' => true, 'messages' => "Billing address updated successfully."]);
    }

    /**
     * Chnage password function.
     *
     * @return Response
     */
    public function changePassword(Request $request) {
        $data = $request->all();
        $validator = Validator::make($data, array(
                    'current_password' => 'required',
                    'password' => 'required|min:6',
                    'confirm_password' => 'required|same:password'
                        )
        );

        $errors = $validator->errors();
        if (!empty($errors->messages())) {
            return response()->json($errors, 401);
        }


        //grab user with find method
        $user = User::find(Auth::id());

        $old_password = $data['current_password'];
        $password = $data['password'];

        //check if old password supplied matches their current password
        if (Hash::check($old_password, $user->getAuthPassword())) {
            //get users password field in db = new password
            $user->password = bcrypt($password);

            if ($user->save()) {
                return response()->json(['success' => true, 'messages' => "Your password has been changed."]);
            }
        } else {
            return response()->json(array('error' => 'The current password is invalid. Please enter correct current password!'), 401);
        }
        return response()->json(array('error' => 'Your password could not be changed.Please try again later!'), 401);
    }

    /**
     * get state by country id.
     *
     * @return Response
     */
    public function getStateByCountryId(Request $request) {
        $id = $request->get('id');
        return State::where('country_id', $id)->get(array('id', 'name'));
    }

    // To activate user by the code provided in the link via email
    public function getActivate($code) {

        $user = User::where('verify_token', '=', $code)->where('status', '=', 0);

        if ($user->count()) {
            // To get user info
            $user = $user->first();
            //Update user to activate state
            //has to be 1 for user to log in
            $user->status = 1;
            $user->verify_token = null;
            if ($user->save()) {
                Auth::login($user);
                return Redirect::to('/my-account')->with('success-message', 'Your account has been activated and successfully logged in!');
            } else {
                return Redirect::to('/')
                                ->with('error-message', 'We could not activate your account, please try again later.');
            }
        }
        return Redirect::to('/')
                        ->with('success-message', 'Your account is already activated! You may now sign in!');
    }

}
