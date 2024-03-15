<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\AD;
use App\Models\Year;
use App\Models\Stage;

class ADController extends Controller
{
    //  index all ads
    public function index()
    {
        $ads = AD::all();
        if ($ads->isNotEmpty()) {
            return response()->json(
                ['message' => $ads],
                200
            );
        }
        return response()->json(
            ['message' => 'no ads has been found'],
            404
        );
    }

    //  add a new ad
    public function store(Request $request)
    {
        // $user = Auth::user();

        // if ($user->role != (1 || 2 || 3)) {
        //     return response()->json(
        //         ['error' => 'Unauthorized'],
        //         403
        //     );
        // }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image_data' => 'required',
        ]);

        // Check if year and stage IDs are provided
        $year = Year::find($request->year_id);
        $stage = null;
        if ($year) {
            $stage = Stage::find($year->stage_id);
        }

        // Construct ad data
        $adData = [
            'title' => $request->title,
            'description' => $request->description,
            'year_id' => $year ? $year->id : null,
            'stage_id' => $stage ? $stage->id : null,
        ];

        // Store image if provided
        $image = $request->file('image');
        if ($image) {
            $imageData = base64_encode(file_get_contents($image->path()));
            $adData['image_data'] = $imageData;
        }

        // Create the ad
        $ad = AD::create($adData);

        return response()->json(['message' => 'AD added successfully'], 200);
    }


    // update a price or quantity
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'adv_name' => 'required|exists:meds,adv_name',
            'dosage' => 'numeric',
            'quantity' => 'nullable|numeric|min:0', // Added validation for minimum quantity
            'price' => 'nullable|numeric|min:0',    // Added validation for minimum price
        ]);

        $medicine = Med::where('adv_name', $request->adv_name)
            ->where('dosage', optional($request)->dosage)
            ->where('store_name', $user->store_name)
            ->where('expiration_date', $request->expiration_date)
            ->first();

        if (!$medicine) {
            return response()->json(
                ['error' => 'Medicine not found'],
                404
            );
        }

        // Check if the authenticated user is the owner of the medicine
        if ($user->store_name != $medicine->store_name) {
            return response()->json(
                ['error' => 'Unauthorized'],
                403
            );
        }

        if ($request->has('quantity')) {
            $medicine->quantity = $request->quantity;
        }

        if ($request->has('price')) {
            $medicine->price = $request->price;
        }

        $medicine->save();

        return response()->json(
            ['message' => 'Medicine updated successfully'],
            200
        );
    }

    //  show last 6 ads added
    public function show()
    {
        $newestAD = AD::orderBy('id', 'desc')->first(); // gets the whole row
        $maxValue = $newestAD->id;
        $newestADs = [];
        for ($i = 0; $i < 6; $i++) {
            $ad = AD::where('id', $maxValue)->first();
            if ($ad && $ad->isExpired == 0) {
                $newestADs[$i] = $ad;
                $maxValue--;
            } else {
                $maxValue--;
                $i--;
            }
            if ($maxValue == 0)
                break;
        }
        return response()->json(
            ['message' => $newestADs],
            200
        );
    }

    //  update an ad
    // public function update(Request $request){

    //     $request->validate([
    //         'ad_id' => 'required|numeric'
    //     ]);

    //     $ad = AD::where('id', $request->ad_id)
    //         ->first();


    // }


    //  set the ad to be expired
    public function setExpired()
    {
    }

    // delete an ad
    public function destroy()
    {
    }
}
