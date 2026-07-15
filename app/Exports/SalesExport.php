<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $query = Order::query()->with('items.inventory');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Date',
            'Customer Name',
            'Order Type',
            'Total Amount (Rs.)',
            'Payment Method',
            'Status',
            'Items'
        ];
    }

    public function map($order): array
    {
        $itemsDesc = $order->items->map(function($item) {
            $name = $item->inventory ? $item->inventory->name : 'Unknown Product';
            return "{$name} (x{$item->quantity})";
        })->implode(', ');

        return [
            $order->id,
            $order->created_at->format('Y-m-d H:i:s'),
            $order->customer_name,
            ucfirst($order->order_type),
            $order->total,
            ucfirst($order->payment_method),
            ucfirst($order->status),
            $itemsDesc
        ];
    }
}
