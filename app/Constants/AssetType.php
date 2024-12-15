<?php
namespace App\Constants;

enum AssetType: string
{
    case CRYPTO = 'crypto';
    case FIAT = 'fiat';
    case GIFT_CARD = 'giftcard';
}
?>
