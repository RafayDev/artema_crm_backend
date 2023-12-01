<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\CategorySubCategory;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Query;
use App\Models\QueryProduct;
use App\Models\Cart;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = Notification::where('to_user_id', $user->id)->where('is_read',0)->orderBy('id', 'desc')->paginate(24);
        return response()->json([
            'notifications' => $notifications
        ], 200);
    }
    public function markAllAsRead()
    {
        $user = auth()->user();
        $notifications = Notification::where('to_user_id', $user->id)->where('is_read',0)->get();
        foreach($notifications as $notification){
            $notification->is_read = 1;
            $notification->save();
        }
        return response()->json([
            'message' => 'All notifications marked as read'
        ], 200);
    }
}
