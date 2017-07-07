<?php

namespace SystemInc\LaravelAdmin;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $dates = ['created_at', 'updated_at', 'valid_until', 'date_of_purchase'];

    protected $fillable = [
        'invoice_number',
        'order_status_id',
        'shipment_price',
        'total_price',
        'valid_until',
        'date_of_purchase',
        'currency',
        'note',
        'billing_name',
        'billing_email',
        'billing_telephone',
        'billing_address',
        'billing_city',
        'billing_country',
        'billing_postcode',
        'billing_contact_person',
        'shipping_name',
        'shipping_email',
        'shipping_telephone',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'shipping_postcode',
        'shipping_contact_person',
        'parity',
        'term_of_payment',
        'footnote',
        'show_shipping_address',
    ];

    public function status()
    {
        return $this->belongsTo('SystemInc\LaravelAdmin\OrderStatus', 'order_status_id');
    }

    public function items()
    {
        return $this->hasMany('SystemInc\LaravelAdmin\OrderItem', 'order_id');
    }

    public function recalculateTotalPrice()
    {
        $this->total_price = 0;

        foreach ($this->items as $item) {
            $this->total_price += $item->custom_price != 0.0 ? $item->custom_price - $item->discount : ($item->product->price - $item->discount) * $item->quantity;
    }
        $this->total_price += $this->shipment_price;

        return $this->total_price;
    }
}
