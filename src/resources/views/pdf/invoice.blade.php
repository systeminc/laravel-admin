<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        .page-break {
            page-break-after: always;
        }
        table{
            font-family: 'dejavu sans', sans-serif;
            font-size: 11px;
        }
        .list td, .list th{
            padding: 0 5px;
            border: 1px solid black;
        }
        .list td.no-border{
            border: none;       
        }
    </style>
</head>
<body>

<table style="margin:auto">
    <tr>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 60%">
                        <img src="{{ (!empty(SystemInc\LaravelAdmin\Setting::first()) && SystemInc\LaravelAdmin\Setting::first()->source != null) ? url('/').'/'.config('laravel-admin.route_prefix').'/'.asset('storage').'/'.SystemInc\LaravelAdmin\Setting::first()->source : url('/').'/'.config('laravel-admin.route_prefix').'/images/logo.png' }}">
                    </td>
                    <td style="width: 40%">
                        <table>
                            <tr>
                                <td>{{ empty(config('laravel-admin.invoice.location')) ? '' : 'Location:' }}</td>
                                <td align="right">{{ empty(config('laravel-admin.invoice.location')) ? '' : config('laravel-admin.invoice.location') }}</td>
                            </tr>
                            <tr>
                                <td>{{ empty(config('laravel-admin.invoice.address')) ? '' : 'Address:' }}</td>
                                <td align="right">{{ empty(config('laravel-admin.invoice.address')) ? '' : config('laravel-admin.invoice.address') }}</td>
                            </tr>
                            <tr>
                                <td>{{ empty(config('laravel-admin.invoice.skype')) ? '' : 'Skype:' }}</td>
                                <td align="right">{{ empty(config('laravel-admin.invoice.skype')) ? '' : config('laravel-admin.invoice.skype') }}</td>
                            </tr>
                            <tr>
                                <td>{{ empty(config('laravel-admin.invoice.website')) ? '' : 'Website:' }}</td>
                                <td align="right">{{ empty(config('laravel-admin.invoice.website')) ? '' : config('laravel-admin.invoice.website') }}</td>
                            </tr>
                            <tr>
                                <td>{{ empty(config('laravel-admin.invoice.email')) ? '' : 'Email:' }}</td>
                                <td align="right">{{ empty(config('laravel-admin.invoice.email')) ? '' : config('laravel-admin.invoice.email') }}</td>
                            </tr>                          
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>                
        <td>
            <hr />
            <table style="width: 100%;">
                <col style="width: 50%">
                <col style="width: 50%">  
                <tr>
                    <td width="50%">
                        {{ empty(config('laravel-admin.invoice.company_prefix')) ? '' : config('laravel-admin.invoice.company_prefix') }} <br>
                        <span colspan="2" style="font-size:24px">{{ empty(config('laravel-admin.invoice.company_name')) ? '' : '"'.config('laravel-admin.invoice.company_name').'"' }}</span>
                    </td>
                    <td width="50%">
                        &nbsp; <br>
                        {{ empty(config('laravel-admin.invoice.tax_id')) ? '' : 'Tax ID: '.config('laravel-admin.invoice.tax_id') }} <br>
                        {{ empty(config('laravel-admin.invoice.company_number')) ? '' : 'Company number: '.config('laravel-admin.invoice.company_number') }} <br>
                    </td>                        
                </tr>
                <tr>
                    <td colspan="2"></td>                        
                </tr>                        
            </table>
            <hr />
        </td>
    </tr>
    <tr>
        <td>
            <table style="width: 100%; border: 1px solid black;">
                <col style="width: 50%">
                <col style="width: 50%">                
                <tr>
                    <td style="border: 1px solid black;vertical-align: top; padding:10px;">
                        @if ($type == 'proforma')
                            Proforma invoice number :    T-{{$order->id}}-{{date('Y')}}<br>
                            Date of order:   {{$order->created_at->format('d.m.Y')}}<br>
                            Valid until:   {{$order->valid_until ? $order->valid_until->format('d.m.Y') : $order->created_at->addDays('30')->format('d.m.Y') }}<br>
                        @else
                            Invoice number :    {{$order->invoice_number}}<br>
                            Date of order:   {{$order->created_at->format('d.m.Y')}}<br>
                            Date of purchase:  {{$order->date_of_purchase ? $order->date_of_purchase->format('d.m.Y') : ''}}<br>
                            Term of payment:  {{$order->term_of_payment}}<br>
                        @endif
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
            <table class="list" style="border-collapse: collapse; width: 100%">
                <tr style="background: #ddd">
                    <th>Nmbr.</th>
                    <th>Product name</th>
                    <th>JM</th>
                    <th>qt.</th>
                    <th>price</th>
                    <th>Discount</th>
                    <th>total</th>
                    <th>VAT</th>                            
                </tr>

                @foreach ($order->items as $key => $item)
                    @if ($key == 20)
                        </table>
                        <div class="page-break"></div>
                        <table class="list" style="border-collapse: collapse; width: 100%">
                            <tr style="background: #ddd">
                                <th>Nmbr.</th>
                                <th>Product name</th>
                                <th>JM</th>
                                <th>qt.</th>
                                <th>price</th>
                                <th>Discount</th>
                                <th>total</th>
                                <th>VAT</th>                            
                            </tr>
                    @endif

                    <tr >
                        <td style="text-align: center">{{$key+1}}</td>
                        <td style="width:300px">{{$item->product->title}}</td>
                        <td>pcs</td>
                        <td style="text-align: center">{{$item->quantity}}</td>                            
                        <td style="text-align: right">{{$item->custom_price ?: $item->product->price}} {{$order->currency}}</td>
                        <td style="text-align: right">{{$item->discount}} {{$order->currency}}</td>
                        <td style="text-align: right">{{$item->custom_price ? ($item->custom_price - $item->discount) : ($item->product->price * $item->quantity - $item->discount)}} {{$order->currency}}</td>
                        <td style="text-align: right">{{ empty(config('laravel-admin.invoice.vat')) ? '0%' : config('laravel-admin.invoice.vat')."%" }}</td>                            
                    </tr>

                @endforeach


                @if ($order->shipment_price)
                     <tr >
                        <td style="text-align: center">{{$order->items->count()+1}}</td>
                        <td>Shipping</td>
                        <td>pcs</td>
                        <td style="text-align: center">1</td>                            
                        <td style="text-align: right">{{$order->shipment_price}} {{$order->currency}}</td>
                        <td style="text-align: right">0 {{$order->currency}}</td>
                        <td style="text-align: right">{{$order->shipment_price}} {{$order->currency}}</td>
                        <td style="text-align: right">{{ empty(config('laravel-admin.invoice.vat')) ? '0%' : config('laravel-admin.invoice.vat')."%" }}</td>                            
                    </tr>               
                @endif
                
                <tr>
                    <td colspan="4" class="no-border" style="border-right: 1px solid black"></td>
                    <td colspan="2">Total without VAT :</td>
                    <td style="text-align: right">{{$order->total_price}} {{$order->currency}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="no-border" style="border-right: 1px solid black"></td>
                    <td colspan="2">VAT amount :</td>
                    <td style="text-align: right">{{ $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border" style="border-right: 1px solid black" colspan="4"></td>
                    <td colspan="2"><strong>Total for payment :</strong></td>
                    <td style="text-align: right">{{$order->total_price + $order->total_price * (empty(config('laravel-admin.invoice.vat')) ? '0' : config('laravel-admin.invoice.vat'))/100 }} {{$order->currency}}</td>
                    <td></td>
                </tr>                        
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding: 20px 0;">
            <strong>{{ empty(config('laravel-admin.invoice.disclaimer')) ? '' : config('laravel-admin.invoice.disclaimer') }}</strong>
        </td>
    </tr>
    <tr>
        <td>
          
            <table>
                <tr>
                    <td>{{ empty(config('laravel-admin.invoice.beneficiary')) ? '' : 'Beneficiary:' }}</td>
                    <td>{{ empty(config('laravel-admin.invoice.beneficiary')) ? '' : config('laravel-admin.invoice.beneficiary') }}</td>
                </tr>
                 <tr>
                    <td>{{ empty(config('laravel-admin.invoice.IBAN')) ? '' : 'IBAN:' }}</td>
                    <td>{{ empty(config('laravel-admin.invoice.IBAN')) ? '' : config('laravel-admin.invoice.IBAN') }}</td>
                </tr>
                <tr>
                    <td>{{ empty(config('laravel-admin.invoice.swift')) ? '' : 'Swift:' }}</td>
                    <td>{{ empty(config('laravel-admin.invoice.swift')) ? '' : config('laravel-admin.invoice.swift') }}</td>
                </tr>
                <tr>
                    <td>{{ empty(config('laravel-admin.invoice.bank')) ? '' : 'Bank:' }}</td>
                    <td>{{ empty(config('laravel-admin.invoice.bank')) ? '' : config('laravel-admin.invoice.bank') }}</td>
                </tr>
                <tr>
                    <td>{{ empty(config('laravel-admin.invoice.account_no')) ? '' : 'Account No:' }}</td>
                    <td>{{ empty(config('laravel-admin.invoice.account_no')) ? '' : config('laravel-admin.invoice.account_no') }}</td>
                </tr>
            </table>

        </td>
    </tr>
    @if ($type == 'proforma')
        <tr>
            <td align="center" style="font-size:11px; padding:30px 0;">
                <hr />
                * Please include all of the possible additional expenses of the bank transfer (e.g. intermediary bank provisions). <br />
                This is needed because of the customs regulations - exact amount received is needed to be same like amount on the invoice.</td>
        </tr>
    @else
        <tr>
            <td style="text-align: center; padding:20px 0;">
                <strong>{{ empty(config('laravel-admin.invoice.small_note')) ? '' : config('laravel-admin.invoice.small_note') }}</strong>
            </td>
        </tr>
        <tr>
            <td>
                <table style="width: 100%; margin-top:20px">
                    <tr>
                        <td style="width: 60%"></td>
                        <td style="width: 30%; border-bottom: 1px solid black"></td>
                        <td style="width: 10%"></td>
                    </tr>
                    <tr>
                        <td style="width: 60%"></td>
                        <td  style="width: 30%; text-align: center;">
                            <strong>{{ empty(config('laravel-admin.invoice.signee')) ? '' : config('laravel-admin.invoice.signee') }}</strong>
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
