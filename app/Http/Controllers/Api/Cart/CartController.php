<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\AddToCartRequest;
use App\Models\CartItem;
use App\Models\Enrollment;
// use App\Models\Course
use App\Models\User;

class CartController extends Controller
{
    public function addToCart(AddToCartRequest $request)
    {
        $user_id = auth()->id();
        $courseId = $request->course_id;

        // Check if the user is already enrolled in the course
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

    public function deleteCourseFromCart($courseId)
    {
        $user_id = auth()->id();

        $cartItem = CartItem::where('user_id', $user_id)
            ->where('course_id', $courseId)
            ->whereNull('order_id')
            ->first();

        if (! $cartItem) {
            return response()->json(['message' => 'Course not found in cart.'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Course removed from cart successfully.'], 200);
    }

    public function clearCart()
    {
        $user_id = auth()->id();

        $query = CartItem::where('user_id', $user_id)
            ->whereNull('order_id');

        if (! $query->exists()) {
            return response()->json([
                'message' => 'Cart is already empty.',
            ], 404);
        }

        $query->delete();

        return response()->json([
            'message' => 'Cart cleared successfully.',
        ], 200);
    }
}
