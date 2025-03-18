<?php

namespace App\Http\Controllers\Vendor;

use App\Traits\ScopesTrait;
use App\Traits\UploadTrait;
use App\Models\VendorProducts;
use App\Http\Requests\VendorProductsRequest;
use App\Models\User;
use App\Mail\SendVendor;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
class VendorProductsController extends Controller
{
    use ScopesTrait, UploadTrait;   

    protected function providerRequest(VendorProductsRequest $request)
    {
        $uploaded= $request->input('media');

        $companyName = $request->input('companyName');
        $contactName = $request->input('contactName');
        $email = $request->input('email');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $productName = $request->input('productName');
        $sellingPrice = $request->input('sellingPrice');
        $wholesalePrice = $request->input('wholesalePrice');
        $minQuantity = $request->input('minQuantity');
        $productDescription = $request->input('productDescription');

      $vendorProduct=  VendorProducts::query()->create([
            'companyName' => $companyName,
            'contactName' => $contactName,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'productName' => $productName,
            'sellingPrice' => $sellingPrice,
            'wholesalePrice' => $wholesalePrice,
            'minQuantity' => $minQuantity,
            'productDescription' => $productDescription,
            'fileURL' => $uploaded,
        ]);

        $recipientEmails = User::whereHas('roles', function ($query) {
            $query->where('name', 'ADMIN');
        })->pluck('email')->toArray();
        
        Mail::to($recipientEmails)->send(new SendVendor ($vendorProduct));
        return response()->json(['message' => 'Vendor created'])
        ->setStatusCode(ResponseAlias ::HTTP_OK);
    }
}
