<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case AwaitingPayment = 'awaiting_payment';
    case Paid = 'paid';
    case Processing = 'processing';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Expired = 'expired';
    case Failed = 'failed';
    case Refunded = 'refunded';

    public function label(): string
    {
        return str($this->value)->replace('_', ' ')->title()->toString();
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Paid, self::Completed => 'bg-emerald-50 text-emerald-700',
            self::Failed => 'bg-rose-50 text-rose-700',
            self::Refunded, self::Expired => 'bg-amber-50 text-amber-700',
            self::Cancelled => 'bg-slate-100 text-slate-600',
            self::Processing => 'bg-indigo-50 text-indigo-700',
            self::Pending, self::AwaitingPayment => 'bg-sky-50 text-sky-700',
        };
    }
}
