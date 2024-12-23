<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Plan;
use App\Models\Home_Text;
use App\Models\Home_Text2;
use App\Models\Circle_Text;
use App\Models\Home_Videos;
use App\Models\Home_Images;
use App\Models\Graphic_Text;
use App\Models\Home_Steps;
use App\Models\About_Us;
use App\Models\Integrations;
use App\Models\Calc_Text;
use App\Models\Journey;
use App\Models\Integrations_Cat;
use App\Models\Testimonial;
use App\Models\Subscription;
use App\Models\Subscription_Item;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    
    public function upd_plan_api(Request $request){
        $validator = Validator::make($request->all(), [
            'source_object_id' => 'required|string',
            'plan_name' => 'required|string',
            'plan_duration' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $plan_name = $request->plan_name;
        $plan_duration = $request->plan_duration;
        $source_object_id_get = $request->source_object_id;

        // Check if the source_object_id exists in the users table
        $user = User::where('source_object_id', $source_object_id_get)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check if the plan_name exists in the plan table
        $newPlan = Plan::where('name', $plan_name)->where('price', '!=', 0)->where('duration', $plan_duration)->first();

        if (!$newPlan) {
            return response()->json(['message' => 'Plan not found.'], 404);
        }

        if (!$user->stripe_id) {
            return response()->json(['message' => 'User does not have a Stripe ID or not added a card'], 404);
        } else {
            // Retrieve Stripe customer subscriptions
            $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
            $subscriptions = $stripe->subscriptions->all(['customer' => $user->stripe_id]);
            $currentSubscription = !empty($subscriptions->data) ? $subscriptions->data[0] : null;
            if ($currentSubscription) {

                $stripe->subscriptions->update($currentSubscription->id, [
                    'cancel_at_period_end' => true,
                ]);

                // Update the local subscription status to 'canceled'
                Subscription::where('stripe_id', $currentSubscription->id)->update([
                    'stripe_status' => 'canceled',
                    'ends_at' => $currentSubscription->current_period_end,
                ]);
                // Update the subscription to the new plan
                $subscription = $stripe->subscriptions->update($currentSubscription->id, [
                    'items' => [['price' => $newPlan->stripe_plan]],
                    'prorate' => true,
                ]);

                $subscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'items' => [['price' => $newPlan->stripe_plan]],
                ]);

                // Create Subscription record
                $subscriptionModel = Subscription::create([
                    'user_id' => $user->id,
                    'stripe_id' => $subscription->id,
                    'stripe_status' => $subscription->status,
                    'stripe_price' => $newPlan->stripe_plan,
                    'quantity' => 1, // Adjust quantity if needed
                    'ends_at' => $subscription->current_period_end,
                ]);

                // Create or update Subscription_Item record
                Subscription_Item::create([
                    'subscription_id' => $subscriptionModel->id,
                    'stripe_id' => $subscription->items->data[0]->id,
                    'stripe_product' => $subscription->items->data[0]->price->product,
                    'stripe_price' => $subscription->items->data[0]->price->id,
                    'quantity' => 1, // Adjust quantity if needed
                ]);
            }
            else {
                // Create a new subscription if none exists
                $subscription = $stripe->subscriptions->create([
                    'customer' => $user->stripe_id,
                    'items' => [['price' => $newPlan->stripe_plan]],
                ]);

                // Create Subscription record
                $subscriptionModel = Subscription::create([
                    'user_id' => $user->id,
                    'stripe_id' => $subscription->id,
                    'stripe_status' => $subscription->status,
                    'stripe_price' => $newPlan->stripe_plan,
                    'quantity' => 1, // Adjust quantity if needed
                    'ends_at' => $subscription->current_period_end,
                ]);
                // Create or update Subscription_Item record
                Subscription_Item::create([
                    'subscription_id' => $subscriptionModel->id,
                    'stripe_id' => $subscription->items->data[0]->id,
                    'stripe_product' => $subscription->items->data[0]->price->product,
                    'stripe_price' => $subscription->items->data[0]->price->id,
                    'quantity' => 1, // Adjust quantity if needed
                ]);
            }

            // Update plan in the local database
            $user->plan_id = $newPlan->id;
            $user->save();

            return response()->json(['message' => 'Plan changed successfully.'], 200);
        }


    }

    public function upd_licnum_api(Request $request){
        $validator = Validator::make($request->all(), [
            'license_number' => 'required|string|max:255',
            'source_object_id' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $license_number_get = $request->license_number;
        $source_object_id_get = $request->source_object_id;

        // Check if the source_object_id exists in the users table
        $user = User::where('source_object_id', $source_object_id_get)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Update the UserDetail table with the new license number
        $userDetail = UserDetail::where('user_id', $user->id)->first();

        if ($userDetail) {
            $userDetail->lic_no = $license_number_get;
            $userDetail->save();

            return response()->json(['message' => 'License number updated successfully.'], 200);
        } else {
            return response()->json(['message' => 'User detail not found.'], 404);
        }


    }

    public function stateget_change_home(Request $request)
    {
        $state_get = $request->stateget_val;
        $path = public_path('Retail Package Store Licenses.xlsx');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();
        $licenseValid = false;
        $storeData = [];
        $allStoreNames = [];

         foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            if ($data[6] === $state_get) {
                $licenseValid = true;
                $storeData = [
                    'license_no' => $data[0],
                    'entity_name' => $data[1],
                    'store_name' => $data[2],
                    'store_address' => $data[3],
                    'city' => $data[4],
                    'country' => $data[5],
                    'state' => $data[6],
                    'phone' => $data[7],
                ];
                break;
            }
        }

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);
            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }
            if ($data[6] === $state_get) {
                $licenseValid = true;
                $allStoreNames[] = $data[2];

            }
        }
        return response()->json(['message' => $storeData,'storename' => $allStoreNames]);
    }

    public function statefetch_func_home(Request $request)
    {
        $client = new Client();
      try {
         $response = $client->get('https://api.smugglers-system.dev/api/application/public/states', [
            'headers' => [
                'Authorization' => 'Token f65d76a173f603a97091a4be7aad79f9881a859d',
            ],
        ]);
        
        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error response from API: ' . $response->getStatusCode());
        }

        $responseBody = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('JSON decode error: ' . json_last_error_msg());
        }

        return response()->json(['response' => $responseBody]);
    } catch (\Exception $e) {
        Log::error('Error in statefetch_func: ' . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
    }

    
    public function all_integration()
    {
        // Auth()->logout();
        // return view('home');
        
        $circleTextSettings = Circle_Text::first();
        $categories  = Integrations_Cat::with('integrations')->get();

            return view('all_integration', compact('circleTextSettings','categories'));

        
         
        }

   
    public function pricing()
    {
        $plan_db = Plan::where('price', '!=', 0)->orderBy('id', 'ASC')->get();
        $textSettings = Home_Text::first();
        $home_text2 = Home_Text2::first();
        $circleTextSettings = Circle_Text::first();
         $videoSettings = Home_Videos::first();
        $images = Home_Images::orderBy('reorder', 'asc')->get();
        $steps = Home_Steps::all();
        $integrations = Integrations::orderBy('id', 'desc')->limit(12)->get();

        $testimonials = Testimonial::all();
        $graphic_text = Graphic_Text::first();
        $calcSettings = Calc_Text::first();


        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

         // Fetch Stripe customer details
        $stripeCustomer = null;
        $paymentMethods = [];
        $subscription = null;

        if (Auth::check() && Auth::user()->stripe_id) {
            // Retrieve customer from Stripe
            $stripeCustomer = $stripe->customers->retrieve(Auth::user()->stripe_id, []);

            // Retrieve subscription details
            $subscriptions = $stripe->subscriptions->all([
                'customer' => $stripeCustomer->id,
            ]);

        $subscription = !empty($subscriptions->data) ? $subscriptions->data[0] : null;
        
        $priceId = $subscription ? $subscription->items->data[0]->price->id : 'N/A';

        return view('pricing', compact('plan_db','textSettings','home_text2','circleTextSettings','videoSettings','images','steps','integrations','priceId','testimonials','graphic_text','calcSettings'));
        }
        else{
            return view('pricing', compact('plan_db','textSettings','home_text2','circleTextSettings','videoSettings','images','steps','integrations','testimonials','graphic_text','calcSettings'));
        }
    }

    public function aboutus()
    {
        

        $testimonials = Testimonial::all();
        $about = About_Us::first();
        $journey = Journey::all();




        

        return view('aboutus', compact('testimonials','about','journey'));
    }

    public function index()
    {
        // Auth()->logout();
        // return view('home');
        $plan_db = Plan::where('price', '!=', 0)->orderBy('id', 'ASC')->get();
        $textSettings = Home_Text::first();
        $home_text2 = Home_Text2::first();
        $circleTextSettings = Circle_Text::first();
         $videoSettings = Home_Videos::first();
        $images = Home_Images::orderBy('reorder', 'asc')->get();
        $steps = Home_Steps::all();
        $integrations = Integrations::orderBy('id', 'desc')->limit(12)->get();

        $testimonials = Testimonial::all();
        $graphic_text = Graphic_Text::first();


        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

         // Fetch Stripe customer details
        $stripeCustomer = null;
        $paymentMethods = [];
        $subscription = null;

        if (Auth::check() && Auth::user()->stripe_id) {
            // Retrieve customer from Stripe
            $stripeCustomer = $stripe->customers->retrieve(Auth::user()->stripe_id, []);

            // Retrieve subscription details
            $subscriptions = $stripe->subscriptions->all([
                'customer' => $stripeCustomer->id,
            ]);

        $subscription = !empty($subscriptions->data) ? $subscriptions->data[0] : null;
        
        $priceId = $subscription ? $subscription->items->data[0]->price->id : 'N/A';

        return view('home', compact('plan_db','textSettings','home_text2','circleTextSettings','videoSettings','images','steps','integrations','priceId','testimonials','graphic_text'));
        }
        else{
            return view('home', compact('plan_db','textSettings','home_text2','circleTextSettings','videoSettings','images','steps','integrations','testimonials','graphic_text'));
        }

        
         
        }

   

}
