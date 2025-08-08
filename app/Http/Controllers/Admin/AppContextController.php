<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class AppContextController extends Controller
{
    /**
     * Get context-specific statistics for the admin dashboard
     */
    public function getContextStats(Request $request)
    {
        $context = $request->get('context', 'all');

        // Base statistics - always included
        $stats = [
            'total_users'    => User::count(),
            'active_users'   => User::where('status', 'active')->count(),
            'new_users_today' => User::whereDate('created_at', today())->count(),
        ];

        // Context-specific statistics
        if ($context === 'all' || $context === 'crypto') {
            $stats['total_orders']             = Order::count();
            $stats['pending_orders']           = Order::where('transaction_status', 'pending')->count();
            $stats['completed_orders']         = Order::where('transaction_status', 'completed')->count();
            $stats['crypto_wallet_balance']    = Wallet::where('type', 'crypto')->sum('balance');
            $stats['fiat_wallet_balance']      = Wallet::where('type', 'fiat')->sum('balance');
            $stats['total_assets']             = Asset::count();
            $stats['active_assets']            = Asset::where('available_units', '>', 0)->count();
            $stats['orders_today']             = Order::whereDate('created_at', today())->count();
            $stats['total_order_value']        = Order::sum('naira_price');
            $stats['avg_order_value']          = Order::avg('naira_price') ?? 0;
        }

        if ($context === 'all' || $context === 'finance') {
            $stats['total_transactions']      = Transaction::count();
            $stats['nuban_wallet_balance']     = Wallet::where('type', 'nuban')->sum('balance');
            $stats['pending_transactions']     = Transaction::where('status', 'pending')->count();
            $stats['successful_transactions']  = Transaction::where('status', 'success')->count();
            $stats['transactions_today']       = Transaction::whereDate('created_at', today())->count();
            $stats['total_transaction_volume'] = Transaction::where('status', 'success')->sum('amount');
            $stats['avg_transaction_amount']   = Transaction::where('status', 'success')->avg('amount') ?? 0;
            $stats['total_fees_collected']     = Transaction::sum('fee');
        }

        // Common cross-context stats
        if ($context === 'all') {
            $stats['total_wallet_balance'] = Wallet::sum('balance');
            $stats['total_wallets']        = Wallet::count();
            $stats['active_wallets']       = Wallet::where('status', 'active')->count();
        }

        return $stats;
    }

    /**
     * Get recent activities based on the current context
     */
    public function getRecentActivities(Request $request)
    {
        $context = $request->get('context', 'all');
        $limit   = $request->get('limit', 5);

        $activities = [];

        // Get recent activities based on context
        if ($context === 'all' || $context === 'crypto') {
            $recentOrders = Order::with(['user.metaData', 'wallet'])
                ->orderBy('created_at', 'desc')
                ->limit($limit * 2) // Get more to ensure we have enough after filtering
                ->get()
                ->map(function ($order) {
                    $userName = $order->user->metaData?->first_name . ' ' . $order->user->metaData?->last_name;
                    $userName = trim($userName) ?: $order->user->email;
                    
                    return [
                        'type'        => 'order',
                        'id'          => $order->id,
                        'reference'   => $order->reference,
                        'user'        => $userName,
                        'user_email'  => $order->user->email,
                        'amount'      => $order->naira_price,
                        'asset'       => $order->asset,
                        'order_type'  => $order->type,
                        'status'      => $order->transaction_status,
                        'created_at'  => $order->created_at,
                        'description' => ucfirst($order->type) . " order for {$order->asset}",
                        'currency'    => 'NGN',
                    ];
                });

            $activities = array_merge($activities, $recentOrders->toArray());
        }

        if ($context === 'all' || $context === 'finance') {
            $recentTransactions = Transaction::with('wallet.user.metaData')
                ->orderBy('created_at', 'desc')
                ->limit($limit * 2) // Get more to ensure we have enough after filtering
                ->get()
                ->filter(function ($transaction) {
                    return $transaction->wallet && $transaction->wallet->user;
                })
                ->map(function ($transaction) {
                    $user = $transaction->wallet->user;
                    $userName = $user->metaData?->first_name . ' ' . $user->metaData?->last_name;
                    $userName = trim($userName) ?: $user->email;
                    
                    return [
                        'type'        => 'transaction',
                        'id'          => $transaction->id,
                        'reference'   => $transaction->transaction_reference,
                        'user'        => $userName,
                        'user_email'  => $user->email,
                        'amount'      => $transaction->amount,
                        'transaction_type' => $transaction->transaction_type,
                        'status'      => $transaction->status,
                        'created_at'  => $transaction->created_at,
                        'description' => $transaction->transaction_description ?? ucfirst($transaction->transaction_type) . ' transaction',
                        'currency'    => $transaction->currency ?? 'NGN',
                        'fee'         => $transaction->fee ?? 0,
                    ];
                });

            $activities = array_merge($activities, $recentTransactions->toArray());
        }

        // Include user registration activities for all contexts
        if ($context === 'all') {
            $recentUsers = User::with('metaData')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($user) {
                    $userName = $user->metaData?->first_name . ' ' . $user->metaData?->last_name;
                    $userName = trim($userName) ?: $user->email;
                    
                    return [
                        'type'        => 'user_registration',
                        'id'          => $user->id,
                        'user'        => $userName,
                        'user_email'  => $user->email,
                        'amount'      => 0,
                        'status'      => $user->status ?? 'active',
                        'created_at'  => $user->created_at,
                        'description' => 'New user registration',
                        'currency'    => 'NGN',
                    ];
                });

            $activities = array_merge($activities, $recentUsers->toArray());
        }

        // Sort combined activities by creation date
        usort($activities, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        // Limit to requested number
        return array_slice($activities, 0, $limit);
    }
}
