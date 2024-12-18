<?php

namespace App\Livewire\Orders;

use App\Constants\AssetType;
use App\Models\Order;
use App\Services\AssetService;
use App\Traits\ChatSystem;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class OrderRecord extends Component
{
    use ChatSystem, WithFileUploads;

    public $order;
    public $cryptoAssets;
    public $giftCardAssets;
    public $messages = [];
    public $input = '';
    public $step = null;
    public $data = [];

    protected AssetService $assetService;

    public $photos = [];

    public function boot(AssetService $assetService)
    {
        $this->assetService = $assetService;
        $this->setOrder();
    }

    public function mount()
    {
        $this->getAvailableCryptoAssets();
        $this->getAvailableGiftCardAssets();
    }

    public function uploadImage()
    {
        foreach ($this->photos as $photo) {
            $photo->store(path: 'photos');
        }
    }

    private function updateChatRecordOnDb(array $chat)
    {
        $this->order->chat = $chat;
        $this->order->save();
    }

    private function getAvailableCryptoAssets()
    {
        $cryptoAssets = $this->assetService->getAssets(AssetType::CRYPTO);
        foreach ($cryptoAssets as $asset) {
            $this->cryptoAssets .= "{$asset->id}. {$asset->name}, ";
        }
    }

    private function getAvailableGiftCardAssets()
    {
        $giftCardAssets = $this->assetService->getAssets(AssetType::GIFT_CARD);
        foreach ($giftCardAssets as $asset) {
            $this->giftCardAssets .= "{$asset->id}. {$asset->name}, ";
        }
    }

    private function setOrder()
    {
        if (isset($_GET['ref']) && !empty($_GET['ref'])) {
            $this->order = Order::where('reference', $_GET['ref'])->first();
            $this->handleOrder();
        } else if (session()->has('orderId')) {
            $this->order = Order::find(session('orderId'));
            $this->handleOrder();
        } else {
            $this->newOrder();
        }
    }

    public function handleOrder()
    {
        if (!$this->order) {
            $this->newOrder();
            return;
        }
        if ($this->order->chat) {
            $this->messages = json_decode($this->order->chat, true);
        }
        if ($this->order->order_step) {
            $this->step = $this->order->order_step;
        }
    }

    private function newOrder()
    {
        $user = Auth::user();
        $this->order = Order::create([
            'user_id' => $user->id,
            'reference' => 'TP' . date('ymdhis'),
        ]);
        session(['orderId' => $this->order->id]);
    }

    public function render()
    {
        return view('livewire.orders.order-record');
    }
}
