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
            'total_users' => User::count(),
        ];

        // Context-specific statistics
        if ($context === 'all' || $context === 'crypto') {
            $stats['total_orders']          = Order::count();
            $stats['pending_orders']        = Order::where('transaction_status', 'pending')->count();
            $stats['crypto_wallet_balance'] = Wallet::where('type', 'crypto')->sum('balance');
            $stats['fiat_wallet_balance']   = Wallet::where('type', 'fiat')->sum('balance');
            $stats['total_assets']          = Asset::count();
        }

        if ($context === 'all' || $context === 'finance') {
            $stats['total_transactions']   = Transaction::count();
            $stats['nuban_wallet_balance'] = Wallet::where('type', 'nuban')->sum('balance');
            $stats['pending_transactions'] = Transaction::where('status', 'pending')->count();
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
            $recentOrders = Order::with(['user', 'wallet'])
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($order) {
                    return [
                        'type'        => 'order',
                        'id'          => $order->id,
                        'user'        => $order->user->email,
                        'amount'      => $order->naira_price,
                        'status'      => $order->transaction_status,
                        'created_at'  => $order->created_at,
                        'description' => "{$order->type} order for {$order->asset}",
                    ];
                });

            $activities = array_merge($activities, $recentOrders->toArray());
        }

        if ($context === 'all' || $context === 'finance') {
            $recentTransactions = Transaction::with('wallet.user')
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function ($transaction) {
                    return [
                        'type'        => 'transaction',
                        'id'          => $transaction->id,
                        'user'        => $transaction->wallet->user->email ?? 'Unknown',
                        'amount'      => $transaction->amount,
                        'status'      => $transaction->status,
                        'created_at'  => $transaction->created_at,
                        'description' => $transaction->transaction_description ?? $transaction->transaction_type,
                    ];
                });

            $activities = array_merge($activities, $recentTransactions->toArray());
        }

        // Sort combined activities by creation date
        usort($activities, function ($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        // Limit to requested number
        return array_slice($activities, 0, $limit);
    }
}
