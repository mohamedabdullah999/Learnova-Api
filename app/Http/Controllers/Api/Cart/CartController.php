<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Models\User;
// use App\Models\Course
use App\Models\Enrollment;

class CartController extends Controller
{
    public function addToCart(AddToCartRequest $request)
    {
        $user_id = auth()->id();
        $courseId = $request->course_id;

        //Check if the user is already enrolled in the course
        $alreadyEnrolled = Enrollment::where('user_id', $user_id)
                                    ->where('course_id', $courseId)
                                    ->exists();

        if ($alreadyEnrolled) {
            return response()->json(['message' => 'You are already enrolled in this course.'], 409);
        }
        // Check if the item is already in the cart
        $existingItem = CartItem::where('user_id', $user_id)
                                ->where('course_id', $courseId)
                                ->first();

        if ($existingItem) {
            return response()->json(['message' => 'Course is already in the cart.'], 409);
        }

        // Add item to cart
        $cartItem = CartItem::create([
            'user_id' => $user_id,
            'course_id' => $courseId,
        ]);

        return response()->json(['message' => 'Course added to cart successfully.', 'cart_item' => $cartItem], 201);
    }

    public function viewCart()
    {
        $user_id = auth()->id();

        $cartItems = CartItem::with('course')
                            ->where('user_id', $user_id)
                            ->whereNull('order_id')
                            ->get();

        return response()->json(['cart_items' => $cartItems], 200);
    }
}
