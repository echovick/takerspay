<?php

namespace App\Livewire\Orders;

use App\Constants\AssetType;
use App\Mail\Notifications\NewOrderCreated;
use App\Models\Order;
use App\Models\User;
use App\Models\Wallet;
use App\Services\AssetService;
use App\Traits\ChatSystem;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
    public $ref;
    public $url;
    public $superAdmin;
    public $adminAccount;
    public $adminWallet;

    protected AssetService $assetService;

    public $photos = [];

    public function boot(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    public function mount()
    {
        $this->ref = $_GET['ref'] ?? '';
        $this->url = request()->path();
        $this->superAdmin = User::where('role', 'super-admin')->first();
        $this->setOrder();
        $this->getAvailableCryptoAssets();
        $this->getAvailableGiftCardAssets();
    }

    public function uploadImage()
    {
        foreach ($this->photos as $photo) {
            $photo->store(path: 'photos');
        }
    }

    public function getSuperAdminAccount()
    {
        $superAdmin = User::where('role', 'super-admin')->first();
        return Wallet::where('user_id', $superAdmin->id)->where('type', 'fiat')->first();
    }

    public function getSuperAdminWallet($assetId)
    {
        $superAdmin = User::where('role', 'super-admin')->first();
        return Wallet::where('user_id', $superAdmin->id)->where('asset_id', $assetId)->first();
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
        if (isset($this->ref) && !empty($this->ref)) {
            $this->order = Order::where('reference', $this->ref)->first();
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

    private function setAdminWalletAndAccount()
    {
        $this->adminAccount = $this->getSuperAdminAccount();
        if (isset($this->order->asset_id)) {
            $this->adminWallet = $this->getSuperAdminWallet($this->order->asset_id);
        }
    }

    private function sendNewOrderNotificationToAdmin()
    {
        $superAdmin = User::where('role', 'super-admin')->first();
        Mail::to($superAdmin->email)->send(new NewOrderCreated($this->order, $superAdmin));
    }

    private function addNewMessage(string $userInput)
    {
        $sender = 'user';
        if (Str::contains($this->url, 'tp-admin') && in_array(Auth::user()->role, ['admin', 'super-admin'])) {
            $sender = 'Bot';
        }
        $this->addMessage($sender, $userInput);
    }

    private function imageUpload($userInput = '')
    {
        $this->validate(['photos.*' => 'image|max:1024']);

        foreach ($this->photos as $photo) {
            $result = $photo->storeOnCloudinaryAs('images', $photo->getClientOriginalName());
            $url = $result->getSecurePath();
            $sender = 'user';
            if (Str::contains($this->url, 'tp-admin') && in_array(Auth::user()->role, ['admin', 'super-admin'])) {
                $sender = 'Bot';
            }
            $this->addImage($sender, $url, $userInput);
            $this->photos = null;
        }
    }

    private function resetChat()
    {
        $this->messages[] = ['sender' => 'Bot', 'text' => 'Chat has been reset.', 'timestamp' => Carbon::now()];
        $this->step = null;
        $this->data = [];
    }

    private function cancelChat()
    {
        $this->order->transaction_status = 'canceled';
        $this->order->save();
        $this->step = null;
        $this->data = [];
    }

    private function addImage($sender, $imageUrl, $caption)
    {
        $this->messages[] = ['sender' => $sender, 'image_url' => $imageUrl, 'timestamp' => Carbon::now(), 'caption' => $caption];
        $this->updateChatRecordOnDb($this->messages);
    }

    private function addMessage($sender, $text)
    {
        $this->messages[] = ['sender' => $sender, 'text' => $text, 'timestamp' => Carbon::now()];
        $this->updateChatRecordOnDb($this->messages);
    }

    public function render()
    {
        return view('livewire.orders.order-record');
    }
}
