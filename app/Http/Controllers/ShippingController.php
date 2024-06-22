<?php

namespace App\Http\Controllers;

use App\Models\Shipping;
use App\Models\Manifest;
use App\Models\Price;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ShippingController extends Controller
{
    private $destinations = [
        ['id' => 1, 'name' => 'Damascus'],
        ['id' => 2, 'name' => 'Aleppo'],
        ['id' => 3, 'name' => 'Homs'],
        ['id' => 4, 'name' => 'Latakia'],
        ['id' => 5, 'name' => 'Hama'],
        ['id' => 6, 'name' => 'Raqqa'],
        ['id' => 7, 'name' => 'Deir ez-Zor'],
        ['id' => 8, 'name' => 'Idlib'],
        ['id' => 9, 'name' => 'Hasakah'],
        ['id' => 10, 'name' => 'Qamishli'],
        ['id' => 11, 'name' => 'Daraa'],
        ['id' => 12, 'name' => 'Suwayda'],
        ['id' => 13, 'name' => 'Tartus'],
        ['id' => 14, 'name' => 'Palmyra'],
    ];
    public function AddInvoice(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'source_id' => 'required|numeric',
                'destination_id' => 'required|numeric',
                'manifest_number' => 'required|string',
                'sender' => 'required|string',
                'receiver' => 'required|string',
                'sender_number' => 'required|max:15',
                'receiver_number' => 'required|max:15',
                'num_of_packages' => 'required|numeric',
                'type_id' => 'required|numeric',
                'weight' => 'required|numeric',
                'size' => 'required|string',
                'content' => 'required|string',
                'marks' => 'required|string',
                'notes' => 'string|nullable',
                'shipping_cost' => 'numeric|nullable',
                'against_shipping' => 'numeric|nullable',
                'adapter' => 'numeric|nullable',
                'advance' => 'numeric|nullable',
                'miscellaneous' => 'numeric|nullable',
                'prepaid' => 'numeric|nullable',
                'discount' => 'numeric|nullable',
                'collection' => 'numeric|nullable',
                'quantity' => 'numeric|nullable'

            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->toJson()
                ], 400);
            }
    
            $shippingCost = $this->calculateShippingCost($request->type_id, $request->weight);
    
            $barcode = 'SHIP-' . uniqid() . Str::random(6);
    
            $shipping = Shipping::create([
                'source_id' => $request->source_id,
                'destination_id' => $request->destination_id,
                'manifest_number' => $request->manifest_number,
                'sender' => $request->sender,
                'receiver' => $request->receiver,
                'sender_number' => $request->sender_number,
                'receiver_number' => $request->receiver_number,
                'num_of_packages' => $request->num_of_packages,
                'price_id' => $request->type_id,
                'weight' => $request->weight,
                'size' => $request->size,
                'content' => $request->content,
                'marks' => $request->marks,
                'notes' => $request->notes,
                'shipping_cost' => $shippingCost,
                'against_shipping' => $request->against_shipping,
                'adapter' => $request->adapter,
                'advance' => $request->advance,
                'miscellaneous' => $request->miscellaneous,
                'prepaid' => $request->prepaid,
                'discount' => $request->discount,
                'collection' => $request->collection,
                'barcode' => $barcode,
                'quantity' => $request->quantity

            ]);
            $shipping->number = $shipping->id;
            $shipping->save();
            $manifest = Manifest::where('number', $request->manifest_number)->first();
    
            if ($manifest) {
                $manifest->general_total += $shippingCost;
                $manifest->save();
            }
    
            return response()->json([
                'success' => true,
                'message' => 'Invoice added successfully',
                'data' => $shipping
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the invoice',
                'error' => $e->getMessage()
            ], 500);
        }
    }
   
//!Mark:Changed here

    public function getManifestWithInvoices($manifestNumber)
    {
        try {
            $manifest = Manifest::with('shippings')->where('number', $manifestNumber)->first();

            if (!$manifest) {
                return response()->json([
                    'success' => false,
                    'message' => 'Manifest not found',
                ], 404);
            }

            $shippings = $manifest->shippings->map(function ($shipping) {
                return $this->transformShipping($shipping);
            });

            return response()->json([
                'success' => true,
                'message' => 'Manifest retrieved successfully',
                'data' => [
                    // 'manifest' => $manifest,
                    'shippings' => $shippings
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the manifest',
                'error' => $e->getMessage()
            ], 500);
        }
    }
//!Mark:Changed here
    public function GetAllRceipts($destination_id)
    {
        try {
            $branch_id = Auth::guard('employee')->user()->branch_id;

            $receipts = Shipping::where([
                ['source_id', '=', $branch_id],
                ['destination_id', '=', $destination_id],
            ])->get();

            if ($receipts->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No receipts found'
                ], 404);
            }

            $transformedReceipts = $receipts->map(function ($receipt) {
                return $this->transformShipping($receipt);
            });

            return response()->json([
                'success' => true,
                'message' => 'Receipts retrieved successfully',
                'data' => $transformedReceipts
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the receipts',
                'error' => $e->getMessage()
            ], 500);
        }
    }

   
    public function DetermineShippingPrices(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'type' => 'required|string',
                'cost' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->toJson()
                ], 400);
            }

            // Create the new price entry
            $price = Price::create([
                'type' => $request->type,
                'cost' => $request->cost,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Price added successfully',
                'data' => $price
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while adding the price',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function EditShippingPrices(Request $request)
    {
        try {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'type' => 'required|string',
                'cost' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->toJson()
                ], 400);
            }

            // Find the price by type
            $price = Price::where('type', $request->type)->first();

            if (!$price) {
                return response()->json([
                    'success' => false,
                    'message' => 'Type not found'
                ], 404);
            }

            // Update the price details
            $price->update($validator->validated());

            return response()->json([
                'success' => true,
                'message' => 'Price edited successfully',
                'data' => $price
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while editing the price',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function GetPricesList()
    {
        try {
            // Paginate the prices list
            $list = Price::paginate(10);

            if ($list->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No prices found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Prices retrieved successfully',
                'data' => $list
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving the prices',
                'error' => $e->getMessage()
            ], 500);
        }
    }
//!Mark:Changed here

    private function calculateShippingCost($type_id, $weight)
    {
        $price = Price::findOrFail($type_id);
        return $price->cost * $weight;
    }
//!Mark:Changed here

    private function getDestinationName($id)
    {
        $destination = collect($this->destinations)->firstWhere('id', $id);
        return $destination ? $destination['name'] : 'Unknown';
    }
//!Mark:Changed here

    private function getBranchName($id)
    {
        $branch = Branch::find($id);
        return $branch ? $branch->desk : 'Unknown';
    }
//!Mark:Changed here

    private function transformShipping($shipping)
    {
        return [
            'id' => $shipping->id,
            'source_id'=>$shipping->source_id,
            'source_name' => $this->getBranchName($shipping->source_id),
            'destination_id'=>$shipping->destination_id,
            'destination_name' => $this->getDestinationName($shipping->destination_id),
            'manifest_number' => $shipping->manifest_number,
            'sender' => $shipping->sender,
            'receiver' => $shipping->receiver,
            'sender_number' => $shipping->sender_number,
            'receiver_number' => $shipping->receiver_number,
            'num_of_packages' => $shipping->num_of_packages,
            'weight' => $shipping->weight,
            'size' => $shipping->size,
            'content' => $shipping->content,
            'marks' => $shipping->marks,
            'notes' => $shipping->notes,
            'shipping_cost' => $shipping->shipping_cost,
            'against_shipping' => $shipping->against_shipping,
            'adapter' => $shipping->adapter,
            'advance' => $shipping->advance,
            'miscellaneous' => $shipping->miscellaneous,
            'prepaid' => $shipping->prepaid,
            'discount' => $shipping->discount,
            'collection' => $shipping->collection,
            'barcode' => $shipping->barcode,

        ];
    }
}