<?php

namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderReportExport implements FromCollection, WithHeadings
{
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $records = $this->query->get();
        $result = [];

        foreach ($records as $record) {
            $orderItems = [];
            foreach ($record->order_item as $orderItem) {
                $orderItems[] = $orderItem->order_item_name;
            }

            $result[] = [
                'order_number' => $record->order_number,
                'name' => $record->user->user_fullname,
                'order_status' => self::getStatusLabel($record->order_status),
                'order_item' => implode(", ", $orderItems),
                'order_total_price' => number_format($record->order_total_price, 2, '.', ''),
                'order_created' => Carbon::parse($record->order_created)->format('Y-m-d'),
                'order_completed_at' => $record->order_completed_at ? Carbon::parse($record->order_completed_at)->format('Y-m-d') : '-',
            ];
        }

        return collect($result);
    }

    public static function getStatusLabel($status)
    {
        switch ($status) {
            case Order::STATUS_PROCESSING:
                return 'Processing';
            case Order::STATUS_PENDING:
                return 'Pending';
            case Order::STATUS_AWAITING:
                return 'Awaiting Payment';
            case Order::STATUS_COMPLETED:
                return 'Completed';
            case Order::STATUS_CANCELLED:
                return 'Cancelled';
            default:
                return '-';
        }
    }

    public function headings(): array
    {
        return [
            'Order Number',
            'Customer',
            'Order Status',
            'Order Items',
            'Total Price',
            'Order Created',
            'Order Completed At',
        ];
    }
}
