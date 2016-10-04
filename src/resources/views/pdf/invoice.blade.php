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
                    </td>
                    <td style="width: 40%">
                        <table>
                            <tr>
                                <td style="vertical-align: top">Location: </td>
                            </tr>
                            <tr>
                                <td>Address:</td>
                                <td align="right"></td>
                            </tr>
                            <tr>
                                <td>
                                    skype :                              
                                </td>
                                <td align="right">

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    website :        
                                </td>
                                <td align="right">
                                    system-inc.com
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    e-mail:  
                                </td>
                                <td align="right">
                                    office@system-inc.com
                                </td>
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
                        company prefix <br>
                        <span colspan="2" style="font-size:24px">"Laravel Admin" </span>
                    </td>
                    <td width="50%">
                        &nbsp; <br>
                        Tax ID: <br>
                        Company number: <br>
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
                            {{$order->billing_telephone}}<br>
                            {{$order->billing_email}}<br>        

                        @if ($order->show_shipping_address)
                            <strong>Shipping to:</strong><br>
                            {{$order->shipping_name}}<br>
                            {{$order->shipping_contact_person}}<br>
                            {{$order->shipping_address}}<br>
                            {{$order->shipping_postcode}} {{$order->shipping_city}}<br>
                            {{$order->shipping_country}}<br>
                            {{$order->shipping_telephone}}<br>
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
                        <td>{{$key+1}}</td>
                        <td style="width:300px">{{$item->product->title}}</td>
                        <td>pcs</td>
                        <td style="text-align: center">{{$item->quantity}}</td>                            
                        <td style="text-align: right">{{$item->custom_price ?: $item->product->price}}{{$order->currency_sign}}</td>
                        <td style="text-align: right">{{$item->discount}}{{$order->currency_sign}}</td>
                        <td style="text-align: right">{{$item->custom_price ? ($item->custom_price - $item->discount) : ($item->product->price * $item->quantity - $item->discount)}}{{$order->currency_sign}}</td>
                        <td style="text-align: right">0%</td>                            
                    </tr>

                @endforeach


                @if ($order->shipment_price)
                     <tr >
                        <td>{{$order->items->count()}}</td>
                        <td>Shipping</td>
                        <td>pcs</td>
                        <td style="text-align: center">1</td>                            
                        <td style="text-align: right">{{$order->shipment_price}}{{$order->currency_sign}}</td>
                        <td style="text-align: right">0{{$order->currency_sign}}</td>
                        <td style="text-align: right">{{$order->shipment_price}}{{$order->currency_sign}}</td>
                        <td style="text-align: right">0%</td>                            
                    </tr>               
                @endif
                
                <tr>
                    <td colspan="4" class="no-border" style="border-right: 1px solid black"></td>
                    <td colspan="2">Total without VAT :</td>
                    <td style="text-align: right">{{$order->total_price}}{{$order->currency_sign}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="4" class="no-border" style="border-right: 1px solid black"></td>
                    <td colspan="2">VAT amount :</td>
                    <td style="text-align: right">0,00{{$order->currency_sign}}</td>
                    <td></td>
                </tr>
                <tr>
                    <td class="no-border" style="border-right: 1px solid black" colspan="4"></td>
                    <td colspan="2"><strong>Total for payment :</strong></td>
                    <td style="text-align: right">{{$order->total_price}}{{$order->currency_sign}}</td>
                    <td></td>
                </tr>                        
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding: 20px 0;">
            <strong>Laravel Admin is not responsible for any consequential damage</strong>
        </td>
    </tr>
    <tr>
        <td>
          
            <table>
                <tr>
                    <td>Beneficiary:</td>
                    <td>Laravel Admin </td>
                </tr>
                 <tr>
                    <td>IBAN:</td>
                    <td>d</td>
                </tr>
                <tr>
                    <td>Swift:</td>
                    <td>s</td>
                </tr>
                <tr>
                    <td>Bank:</td>
                    <td>s</td>
                </tr>
                <tr>
                    <td>Account No:</td>
                    <td>d</td>
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
                <strong>some text</strong>
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
                            <strong>M.P.</strong>
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
