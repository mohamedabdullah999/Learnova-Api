<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;

class OrderController extends Controller
{
    public function listOrders()
    {
        $orders = Order::with('cartItems.course', 'user')->where('status', 'pending')->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function checkout()
    {
        $user = auth()->user();

        // Retrieve cart items for the user
        $cartItems = $user->cartItems()->whereNull('order_id')->with('course')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 400);
        }

        $total = $cartItems->sum(fn ($item) => (float) ($item->course->price));

        // Create order
        $order = Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            // Associate cart item with order
            $item->update(['order_id' => $order->id]);
        }

        return response()->json(['message' => 'Order placed successfully.', 'order' => $order], 201);
    }

    public function approveOrder($order_id)
    {
        $order = Order::with('cartItems.course')->find($order_id);

        if (! $order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $order->update(['status' => 'approved']);

        foreach ($order->cartItems as $item) {
            Enrollment::create([
                'user_id' => $order->user_id,
                'course_id' => $item->course_id,
                'enrolled_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Order approved and user enrolled in courses.', 'order' => $order], 200);
    }

    public function myPendingOrders()
    {
        $user = auth()->user();

        $orders = Order::with('cartItems.course')
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->get();

        return response()->json(['orders' => $orders,
            'user' => new UserResource($user),
        ],
            200);
    }
}
