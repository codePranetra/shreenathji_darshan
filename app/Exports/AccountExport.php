<?php

namespace App\Exports;

use App\Models\Account;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AccountExport implements FromCollection, WithHeadings, WithMapping
{
    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Account::with('user'); // Eager load user relation

        if (!empty($this->filters['user_id'])) {
            $query->where('user_id', $this->filters['user_id']);
        }

        if (!empty($this->filters['from_date'])) {
            $query->whereDate('created_at', '>=', $this->filters['from_date']);
        }

        if (!empty($this->filters['to_date'])) {
            $query->whereDate('created_at', '<=', $this->filters['to_date']);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            // 'ID',
            'User Name', // changed from 'User ID'
            // 'Booking ID',
            // 'Booking Type',
            'Vendor Name',
            'Shipper Name',
            'Shipper Country',
            'Consignee Name',
            'Total Number of Item',
            'Destination',
            'Tracking Number',
            'Total Weight',
            'Total Contract Charges',
            'Discount',
            'Contract Charges',
            'Fuel Surcharge',
            'GST',
            'Total',
            'Extra',
            'Extra Description',
            'Created At',
            // 'Updated At',
        ];
    }

    public function map($account): array
    {
        return [
            // $account->id,
            optional($account->user)->name, // Safe access to user name
            // $account->booking_id,
            // $account->booking_type,
            $account->vendor_name,
            $account->shipper_name, 
            $account->shipper_country,
            $account->consignee_name,
            $account->total_number_of_item,
            $account->destination,
            $account->tracking_number,
            $account->total_weight,
            $account->total_contract_charges,
            $account->discount,
            $account->contract_charges,
            $account->fuel_surcharge,
            $account->gst,
            $account->total,
            $account->extra,
            $account->extra_description,
            $account->created_at,
            // $account->updated_at,
        ];
    }
}
