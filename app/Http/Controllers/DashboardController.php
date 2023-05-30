<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $total_visits = views(Product::class)->count();
        $total_paid = Order::query()
            ->where('is_deleted', 0)
            ->where('order_status', Order::STATUS_COMPLETED)
            ->count();

        $days = 7; // Number of days to retrieve visit counts

        $paid_start_date = Carbon::now()->subDays(7);

        /**
         * ==============================
         *        Paid Counts
         * ==============================
         */

        $paidCounts = [];

        // Iterate over the days and retrieve the paid counts
        for ($i = 0; $i < $days; $i++) {
            $currentDay = $paid_start_date->copy()->addDays($i);
            $startOfDay = $currentDay->startOfDay();

            // Retrieve the paid count for the current day
            $paidCount = Order::where('order_status', 4)
                ->whereDate('order_completed_at', '=', $startOfDay->format('Y-m-d'))
                ->count();

            // Store the paid count indexed by the day abbreviation
            $paidCounts[$startOfDay->format('D')] = $paidCount;
        }

        /**
         * ==============================
         *        Visit Counts
         * ==============================
         */

        $now = Carbon::now();

        $visitCounts = [];

        for ($i = 0; $i < $days; $i++) {
            $startOfDay = $now->copy()->subDays($i + 1)->startOfDay();
            $endOfDay = $now->copy()->subDays($i)->startOfDay();

            $visitCount = views(Product::class)
                ->period(Period::create($startOfDay, $endOfDay))
                ->count();

            $visitCounts[$startOfDay->format('D')] = $visitCount;
        }

        /**
         * ==============================
         *     Unique Visitor Counts
         * ==============================
         */

        $categories = Category::where('is_deleted', 0)->where('category_status', 1)->get();

        $year = date('Y'); // Get the current year

        $months = ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec'];

        $uniqueVisits = [];

        foreach ($categories as $category) {
            $uniqueVisits[$category->category_slug] = [];

            foreach ($months as $month) {
                $startDate = Carbon::create($year, array_search($month, $months) + 1, 1)->startOfMonth();
                $endDate = $startDate->copy()->endOfMonth();

                $uniqueVisits[$category->category_slug][$month] = views(Product::class)
                    ->period(Period::create($startDate, $endDate))
                    ->collection($category->category_slug)
                    ->unique()
                    ->count();
            }
        }

        $result = [];

        foreach ($uniqueVisits as $categorySlug => $monthVisits) {
            foreach ($months as $month) {
                $key = $categorySlug . '_unique_visit_' . $month;
                $result[$key] = $monthVisits[$month] ?? 0;
            }
        }

        /**
         * ==============================
         *      Paid Amount by Week
         * ==============================
         */

        $paid_start_week = Carbon::now()->startOfWeek();
        $paid_end_week = Carbon::now()->endOfWeek();

        $paid_amount_by_week = Order::query()
            ->where('order_status', 4)
            ->whereBetween('order_completed_at', [$paid_start_week, $paid_end_week])
            ->sum('order_total_price');

        $total_paid_amount = Order::query()
            ->where('is_deleted', 0)
            ->where('order_status', 4)
            ->sum('order_total_price');

        // Activity Logs
        $activityLogs = Activity::query()
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Favorites
        $total_favorites = Favorite::query()
            ->where('is_checked', 1)
            ->count();

        $top_favorites = Favorite::query()
            ->select('product_id', DB::raw('count(*) as count'))
            ->where('is_checked', 1)
            ->groupBy('product_id')
            ->orderByDesc('count')
            ->take(3)
            ->get();

        /**
         * ==============================
         *        Users Counts
         * ==============================
         */
        $total_users = User::query()
            ->where('is_deleted', 0)
            ->where('user_role', User::USER_ROLE)
            ->where('user_status', User::STATUS_ACTIVE)
            ->count();

        $createdStart = now()->subDays($days);

        $userCreatedCounts = [];

        // Iterate over the days and retrieve the user created counts
        for ($i = 0; $i < $days; $i++) {
            $userCreatedStart = $createdStart->copy()->addDays($i);
            $userCreatedEnd = $userCreatedStart->startOfDay();

            // Retrieve the user created count for the current day
            $userCreatedCount = User::query()
                ->where('is_deleted', 0)
                ->where('user_role', User::USER_ROLE)
                ->where('user_status', User::STATUS_ACTIVE)
                ->whereDate('user_created', '=', $userCreatedEnd->format('Y-m-d'))
                ->count();

            // Store the user created count indexed by the day abbreviation
            $userCreatedCounts[$userCreatedStart->format('D')] = $userCreatedCount;
        }

        return view('pages.dashboard.analytics', [
            'title' => 'Dashboard',
            'total_visits' => $total_visits,
            'total_paid' => $total_paid,
            'total_paid_amount' => $total_paid_amount,
            'result' => $result,
            'months' => $months,
            'visitCounts' => $visitCounts,
            'paidCounts' => $paidCounts,
            'paid_amount_by_week' => $paid_amount_by_week,
            'activityLogs' => $activityLogs,
            'total_favorites' => $total_favorites,
            'top_favorites' => $top_favorites,
            'total_users' => $total_users,
            'userCreatedCounts' => $userCreatedCounts,
        ]);
    }
}
