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
        table .green,table tr.green, .green, tr.green{
        	background-color:rgba(0,128,0,.2)
        }
        table .red,table tr.red, .red, tr.red{
        	background-color:rgba(255,0,0,.2)
        }
        table .blue,table tr.blue, .blue, tr.blue{
        	background-color:rgba(0,0,255,.2)
        }
        table .yellow,table tr.yellow, .yellow, tr.yellow{
        	background-color:rgba(255,255,0,.2)
        }
    </style>
</head>
<body>
	<h1>Orders</h1>
	<span class="last-update"></span>

	<table class="order-list" style="width: 100%; text-align:center;">
		<tr>
			<th>ID</th>
			<th>Status</th>
			<th>Billing Name</th>
			<th>Billing Email</th>
			<th>Total</th>
			<th>Invoice number</th>
		</tr>

		@if (!count($orders))
			<tr><td colspan="9">No orders with given filter</td></tr>
		@endif

		@foreach ($orders as &$order)
			@if ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::PAID)
				<tr style="background-color:rgba(0,0,255,.2)">
			@elseif ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::DELIVERED)
				<tr style="background-color:rgba(255,255,0,.2)">
			@elseif ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::CREATED)
				<tr style="background-color:rgba(0,128,0,.2)">
			@elseif ($order->status->id == SystemInc\LaravelAdmin\OrderStatus::NOT_ACCEPTED)
				<tr style="background-color:rgba(255,0,0,.2)">
			@else
				<tr>
			@endif
				<td>{{$order->id}}</td>
				<td>{{$order->status->title}}</td>
				<td>{{$order->billing_name}}</td>
				<td>{{$order->billing_email}}</td>
				<td style="text-align: center;">{{$order->total_price}} {{$order->currency}}</td>
				<td style="text-align: center; font-weight: bold">{{$order->invoice_number ?: ''}}</td>
			</tr>
		@endforeach
	</table>
</body>