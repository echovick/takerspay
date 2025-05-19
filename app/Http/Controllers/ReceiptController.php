<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Response;

class ReceiptController extends Controller
{
    /**
     * Generate and download a receipt for an order
     *
     * @param string $reference
     * @return Response
     */
    public function downloadReceipt(string $reference): Response
    {
        $order = Order::with(['user', 'user.metaData'])->where('reference', $reference)->firstOrFail();

        $firstName      = (string) ($order->user?->metaData?->first_name ?? '');
        $lastName       = (string) ($order->user?->metaData?->last_name ?? '');
        $userTag        = (string) ($order->user?->metaData?->tag ?? '');
        $orderDateTime  = $order->created_at->format('d M Y, h:i A');
        $orderReference = (string) $order->reference;
        $orderStatus    = ucfirst((string) $order->transaction_status);
        $buyOrSell      = ucfirst((string) $order->type);
        $assetName      = (string) $order->asset;
        $assetValue     = (string) $order->asset_value;
        $dollarPrice    = number_format((float) $order->dollar_price, 2);
        $nairaPrice     = number_format((float) $order->naira_price, 2);
        $tradeCurrency  = (string) $order->trade_currency;
        $orderCreatedAt = $order->created_at->format('d M Y, h:i A');
        $confirmedAt    = $order->confirmed_at ? Carbon::parse($order->confirmed_at)->format('d M Y, h:i A') : 'Pending';
        $fulfilledAt    = $order->fulfilled_at ? Carbon::parse($order->fulfilled_at)->format('d M Y, h:i A') : 'Pending';
        $currentYear    = Carbon::now()->format('Y');

        $data = [
            'OrderDateTime'  => $orderDateTime,
            'OrderReference' => $orderReference,
            'OrderStatus'    => $orderStatus,
            'BuyOrSell'      => $buyOrSell,
            'AssetName'      => $assetName,
            'AssetValue'     => $assetValue,
            'DollarPrice'    => $dollarPrice,
            'NairaPrice'     => $nairaPrice,
            'TradeCurrency'  => $tradeCurrency,
            'OrderCreatedAt' => $orderCreatedAt,
            'ConfirmedAt'    => $confirmedAt,
            'FulfilledAt'    => $fulfilledAt,
            'UserName'       => $firstName . ' ' . $lastName,
            'UserTag'        => $userTag,
            'CurrentYear'    => $currentYear,
        ];

        $pdf = PDF::loadView('template.receipt', $data);

        // Configure PDF settings for a slimmer format
        $pdf->setPaper([0, 0, 350, 800], 'portrait');
        $pdf->setOption('dpi', 150);
        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('isRemoteEnabled', true);

        return $pdf->download('takerspay_receipt_' . $reference . '.pdf');
    }
}
