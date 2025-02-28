<?php

namespace App\Http\Services;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class WalletService
{
    protected $user;
    protected $wallet;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->wallet = $user->wallet;
    }

    public function topUp(float $balance): User
    {
        DB::transaction(function () use ($balance) {
            $this->updateWalletBalance($balance);
            $this->createTransaction('top_up', $balance);
        });

        return $this->user;
    }

    public function transfer(User $recipient, float $balance): User
    {
        $transactionFee = $this->calculateTransactionFee($balance);

        DB::transaction(function () use ($recipient, $balance, $transactionFee) {
            $this->updateWalletBalance(-$balance - $transactionFee);
            $this->updateWalletBalance($balance, $recipient);
            $this->createTransaction('transfer', $balance, $recipient, $transactionFee);
        });

        return $this->user;
    }

    public function calculateTransactionFee(float $balance): float
    {
        return ($balance > 25) ? (2.5 + 0.10 * $balance) : 0;
    }

    protected function updateWalletBalance(float $balance, User $recipient = null): void
    {
        if ($recipient) {
            $recipient->wallet->balance += $balance;
            $recipient->wallet->save();
        } else {
            $this->wallet->balance += $balance;
            $this->wallet->save();
        }
    }

    protected function createTransaction(string $type, float $balance, User $recipient = null, float $transactionFee = 0): void
    {
        $transaction = new Transaction();
        $transaction->user_id = $this->user->id;
        $transaction->recipient_user_id = $recipient ? $recipient->id : $this->user->id;
        $transaction->type = $type;
        $transaction->amount = $balance;
        $transaction->transaction_fee = $transactionFee;
        $transaction->save();
    }

    public function getBalance(): float
    {
        return $this->wallet->balance;
    }

    public function getTransactionHistory()
    {
        return $this->user->transactions()->orderBy('created_at', 'desc')->get();
    }
}
