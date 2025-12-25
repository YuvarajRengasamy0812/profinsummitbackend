<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // Display list of coupons
    public function couponlist()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();
        return view('admin.couponcode', compact('coupons'));
    }

    // Store new coupon
public function couponstore(Request $request)
{
    $request->validate([
        'coupon_name' => 'required|string|max:255',
        'percentage'  => 'required|integer|min:1|max:100',
        'coupon_code' => 'required|string|max:255|unique:coupon_codes,coupon_code', // <-- unique validation
        'status'      => 'required|boolean',
    ]);

    // If validation passes, create coupon
    Coupon::create($request->only('coupon_name', 'percentage', 'coupon_code', 'status'));

    return back()->with('success', 'Coupon created successfully!');
}


    // Get coupon for edit (AJAX)
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json($coupon);
    }

    // Update coupon
    public function couponupdate(Request $request, $id)
    {
        $request->validate([
            'coupon_name' => 'required|string|max:255',
            'percentage'  => 'required|integer|min:1|max:100',
            
            'status'      => 'required|boolean',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->only('coupon_name', 'percentage', 'status'));

    return back()->with('completed', 'Coupon Updated successfully!');
    }

    // Delete coupon
    public function coupondelete($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        // return response()->json(['success' => true]);
            return back()->with('deleted', 'Coupon Deeleted successfully!');

    }
    public function checkCoupon(Request $request)
    {
        $coupon = Coupon::where('coupon_code', $request->coupon_code)
                        ->where('status', 1)
                        ->first();

        if (!$coupon) {
            return response()->json([
                'valid' => false,
                'message' => 'Invalid coupon code!'
            ]);
        }

        return response()->json([
            'valid' => true,
            'percentage' => $coupon->percentage
        ]);
    }




}
