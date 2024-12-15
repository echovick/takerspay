<?php
namespace App\Traits;

trait AlertMessageHelper
{
    public $errorMsg;
    public $successMsg;

    public function setMessage(string $type, string $msg)
    {
        $this->$type = $msg;
    }

    public function clearMessage(string $type = null)
    {
        if (isset($type)) {
            $this->$type = '';
        } else {
            $this->errorMsg = '';
            $this->successMsg = '';
        }
    }
}
