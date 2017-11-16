<html>
<body>
<table style="margin:auto;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
    <tr>
        <td>
            <table style="width: 100%;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
                <tr>
                    <td style="width: 50%">
                        <img src="{{ (!empty(SystemInc\LaravelAdmin\Setting::first()) && SystemInc\LaravelAdmin\Setting::first()->source != null) ? SLA::getFile(SystemInc\LaravelAdmin\Setting::first()->source) : url('/').'/'.config('laravel-admin.route_prefix').'/images/logo.png' }}" style="width:300px">
                    </td>
                    <td style="width: 50%; text-align: right;">
                        {{ config('laravel-admin.invoice.company_name') }}<br>
                        {!! config('laravel-admin.invoice.address') !!}<br>
                        {{ config('laravel-admin.invoice.phone') }}<br>
                        {{ config('laravel-admin.invoice.email') }}<br>
                        {{ config('laravel-admin.invoice.website') }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>                
        <td>
            <hr />
            @if ($type == 'proforma')
                Proforma invoice number :    T-{{$order->id}}-{{date('Y')}}<br>
                Date of order:   {{$order->created_at->format('d.m.Y')}}<br>
                Valid until:   {{$order->valid_until ? $order->valid_until->format('d.m.Y') : $order->created_at->addDays('30')->format('d.m.Y') }}<br>
            @else
                Invoice number :    {{$order->invoice_number}}<br>
                Date of order:   {{$order->created_at->format('d.m.Y')}}<br>
                Date of purchase:  {{$order->date_of_purchase ? $order->date_of_purchase->format('d.m.Y') : ''}}<br>
            @endif
            <hr />
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%; border: 1px solid black;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
                <tr>
                    <td style="border: 1px solid black;vertical-align: top; padding:10px; width: 50%">
                        <strong>{{ config('laravel-admin.invoice.company_name') }}</strong>
                        &nbsp; <br>
                        {{ empty(config('laravel-admin.invoice.tax_id')) ? '' : 'Tax ID: '.config('laravel-admin.invoice.tax_id') }}
                        {{ empty(config('laravel-admin.invoice.company_number')) ? '' : 'Company number: '.config('laravel-admin.invoice.company_number') }}
                        {{ empty(config('laravel-admin.invoice.beneficiary')) ? '' : 'Beneficiary: '.config('laravel-admin.invoice.beneficiary') }}
                        {{ empty(config('laravel-admin.invoice.IBAN')) ? '' : 'IBAN: '.config('laravel-admin.invoice.IBAN') }}
                        {{ empty(config('laravel-admin.invoice.swift')) ? '' : 'Swift: '.config('laravel-admin.invoice.swift') }}
                        {{ empty(config('laravel-admin.invoice.bank')) ? '' : 'Bank: '.config('laravel-admin.invoice.bank') }}
                        {{ empty(config('laravel-admin.invoice.account_no')) ? '' : 'Account No: '.config('laravel-admin.invoice.account_no') }}
                    </td>
                    <td style="border: 1px solid black; padding:10px;">
                        <strong>Buyer:</strong> <br />
                            {{$order->billing_name}}<br>
                            {{$order->billing_contact_person}}<br>
                            {{$order->billing_address}}<br>
                            {{$order->billing_postcode}} {{$order->billing_city}}<br>
                            {{$order->billing_country}}<br>
                            {{$order->billing_phone}}<br>
                            {{$order->billing_email}}<br>        

                        @if ($order->show_shipping_address)
                            <strong>Shipping to:</strong><br>
                            {{$order->shipping_name}}<br>
                            {{$order->shipping_contact_person}}<br>
                            {{$order->shipping_address}}<br>
                            {{$order->shipping_postcode}} {{$order->shipping_city}}<br>
                            {{$order->shipping_country}}<br>
                            {{$order->shipping_phone}}<br>
                            {{$order->shipping_email}}<br>        
                        @endif
                    </td>
                </tr>
            </table>
            <br />
            <br />
        </td>
    </tr>
    <tr>
        <td>
            <table style="border-collapse: collapse; width: 100%;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
                <tr style="background: #ddd">
                    <th style="padding: 0 5px;border: 1px solid black;">Nmbr.</th>
                    <th style="padding: 0 5px;border: 1px solid black;">Product name</th>
                    <th style="padding: 0 5px;border: 1px solid black;">JM</th>
                    <th style="padding: 0 5px;border: 1px solid black;">qt.</th>
                    <th style="padding: 0 5px;border: 1px solid black;">price</th>
                    <th style="padding: 0 5px;border: 1px solid black;">Discount</th>
                    <th style="padding: 0 5px;border: 1px solid black;">total</th>
                    <th style="padding: 0 5px;border: 1px solid black;">VAT</th>                            
                </tr>
                @foreach ($order->items as $key => $item)
                    @if ($key == 20)
                        </table>
                        <div style="page-break-after: always;"></div>
                        <table style="border-collapse: collapse; width: 100%;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
                            <tr style="background: #ddd">
                                <th style="padding: 0 5px;border: 1px solid black;">Nmbr.</th>
                                <th style="padding: 0 5px;border: 1px solid black;">Product name</th>
                                <th style="padding: 0 5px;border: 1px solid black;">JM</th>
                                <th style="padding: 0 5px;border: 1px solid black;">qt.</th>
                                <th style="padding: 0 5px;border: 1px solid black;">price</th>
                                <th style="padding: 0 5px;border: 1px solid black;">Discount</th>
                                <th style="padding: 0 5px;border: 1px solid black;">total</th>
                                <th style="padding: 0 5px;border: 1px solid black;">VAT</th>                            
                            </tr>
                    @endif
                    <tr >
                        <td style="padding: 0 5px;border: 1px solid black;text-align: center">{{$key+1}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;width:300px">{{$item->product->title}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;">pcs</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: center">{{$item->quantity}}</td>                            
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$item->custom_price ?: $item->product->price}} {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$item->discount}} {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$item->custom_price ? ($item->custom_price - $item->discount) : ($item->product->price * $item->quantity - $item->discount)}} {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{ config('laravel-admin.invoice.vat') ?: '0' }}%</td>                            
                    </tr>
                @endforeach
                @if ($order->shipment_price)
                     <tr >
                        <td style="padding: 0 5px;border: 1px solid black;text-align: center">{{$order->items->count()+1}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;">Shipping</td>
                        <td style="padding: 0 5px;border: 1px solid black;">pcs</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: center">1</td>                            
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$order->shipment_price}} {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">0 {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$order->shipment_price}} {{$order->currency}}</td>
                        <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{ config('laravel-admin.invoice.vat') ?: '0' }}%</td>                            
                    </tr>               
                @endif
                <tr>
                    <td colspan="4" style="padding: 0 5px;border: 1px solid black;border: none;"></td>
                    <td colspan="2">Total without VAT</td>
                    <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$order->total_price}} {{$order->currency}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 0 5px;border: 1px solid black;border: none;"></td>
                    <td colspan="2">VAT amount</td>
                    <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{ $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td style="padding: 0 5px;border: 1px solid black;border: none;" colspan="4"></td>
                    <td colspan="2"><strong>Total for payment</strong></td>
                    <td style="padding: 0 5px;border: 1px solid black;text-align: right">{{$order->total_price + $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}</td>
                    <td></td>
                </tr>                        
            </table>
        </td>
    </tr>
    @if ($type == 'proforma')
        <tr>
            <td style="text-align: center; font-size:11px; padding:30px 0;">
                <hr />
                {{ config('laravel-admin.invoice.proforma_notice') }}
        </tr>
    @else
        <tr>
            <td style="text-align: center; padding:20px 0;">
                <strong>{{ config('laravel-admin.invoice.notice') }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; margin-top:20px;font-family: 'dejavu sans', sans-serif;font-size: 11px;">
                    <tr>
                        <td style="width: 60%"></td>
                        <td style="width: 30%; border-bottom: 1px solid black"></td>
                        <td style="width: 10%"></td>
                    </tr>
                    <tr>
                        <td style="width: 60%"></td>
                        <td  style="width: 30%; text-align: center;">
                            <strong>{{ config('laravel-admin.invoice.signee') }}</strong>
                        </td>
                        <td style="width: 10%"></td>
                    </tr>
                </table>
            </td>
        </tr>
    @endif
</table>
</body>
</html>
