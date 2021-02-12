<?php

namespace SystemInc\LaravelAdmin\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Mail;
use PDF;
use SystemInc\LaravelAdmin\Order;
use SystemInc\LaravelAdmin\OrderItem;
use SystemInc\LaravelAdmin\OrderItemVariation;
use SystemInc\LaravelAdmin\OrderStatus;
use SystemInc\LaravelAdmin\Product;
use SystemInc\LaravelAdmin\Validations\UpdatedOrderValidation;
use Validator;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $query = Order::whereRaw('1=1');

        if ($request->has('filter')) {
            $filters = array_filter($request->input('filter'), 'strlen');

            foreach ($filters as $filter_name => $filter_value) {
                switch ($filter_name) {
                    case 'search':
                        $query->where($filters['search_column'], 'like', '%'.$filter_value.'%');
                        break;

                    case 'date_from':
                        $query->where('created_at', '>', $filter_value);
                        break;

                    case 'date_to':
                        $query->where('created_at', '<', $filter_value);
                        break;

                    case 'tool_id':
                        $query->whereHas('items', function ($sub_query) use ($filter_value) {
                            $sub_query->where('tool_id', $filter_value);
                        });
                        break;

                    case 'tool_category_id':
                        $query->whereHas('items.tool', function ($sub_query) use ($filter_value) {
                            $sub_query->where('tool_category_id', $filter_value);
                        });
                        break;

                    case 'total_price':
                        $query->where('total_price', $filters['price_comparison_sign'], $filter_value);
                        break;

                    case 'payment_type':
                        $query->where('payment_type', $filter_value);
                        break;

                    case 'currency':
                        $query->where('currency', $filter_value);
                        break;

                    case 'order_status_id':
                        $query->where('order_status_id', $filter_value);
                        break;

                    default:
                        continue 2;
                }
            }
        }

        $query->orderBy('created_at', 'desc');

        if ($request->has('print_pdf')) {
            return @PDF::loadView('admin::pdf.orders', ['orders' => $query->get()])->download('orders.pdf');
        }

        $orders = $query->paginate(15);

        return view('admin::orders.index', compact('orders'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getEdit($order_id)
    {
        $order = Order::find($order_id);

        $statuses = OrderStatus::all();

        $products = Product::all();

        $max_invoice_number = (int) Order::whereRaw('YEAR(created_at)='.date('Y'))->max('invoice_number');

        return view('admin::orders.order', compact('order', 'max_invoice_number', 'statuses', 'products'));
    }

    /**
     * Store changes.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function postSave(Request $request, $order_id)
    {
        // validation
        $validation = Validator::make($request->all(), UpdatedOrderValidation::rules(), UpdatedOrderValidation::messages());

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation);
        }

        $order = Order::find($order_id);
        $old_order_status_id = $order->order_status_id;

        if ($request->invoice_number) {
            $order_with_same_invoice_number = Order::whereRaw('YEAR(created_at)='.$order->created_at->format('Y'))
                ->where('invoice_number', $request->invoice_number)
                ->where('id', '<>', $order->id)
                ->first();

            if ($order_with_same_invoice_number) {
                return back()->with('error', 'Invoice number already taken by Order '.$order_with_same_invoice_number->id);
            }
        }

        $order->update($request->all());

        $order->valid_until = empty($request->valid_until) ? null : $request->valid_until;
        $order->date_of_purchase = empty($request->date_of_purchase) ? null : $request->date_of_purchase;
        $order->show_shipping_address = empty($request->show_shipping_address) ? false : $request->show_shipping_address;

        $order->recalculateTotalPrice();
        $order->save();

        // deduct delivered products from stock
        $this->removeFromStock($order);

        return back()->with('success', 'Saved successfully');
    }

    /**
     * Delete item.
     *
     * @param Request $request
     * @param int     $item_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getDeleteItem(Request $request, $item_id)
    {
        $item = OrderItem::find($item_id);
        $product = $item->product;

        $item->delete();

        return back()->with('success', $product->title.' deleted');
    }

    /**
     * Edit item.
     *
     * @param Request $request
     * @param int     $item_id
     *
     * @return \Illuminate\Http\Response
     */
    public function postEditItem(Request $request, $item_id)
    {
        $item = OrderItem::find($item_id);

        $item->quantity = $request->quantity;
        $item->discount = $request->discount;
        $item->custom_price = $request->custom_price;

        $item->save();

        $item->order->recalculateTotalPrice();
        $item->order->save();

        return back()->with('success', $item->product->title.' edited');
    }

    /**
     * Preview PDF proforma.
     *
     * @param int $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPreviewProforma($order_id)
    {
        $data = ['order' => Order::find($order_id), 'type' => 'proforma'];

        $pdf = PDF::loadView('admin::pdf.invoice', $data);

        return $pdf->stream('invoice.pdf');
    }

    /**
     * Preview PDF invoice.
     *
     * @param int $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPreviewInvoice($order_id)
    {
        $data = ['order' => Order::find($order_id), 'type' => 'invoice'];

        $pdf = PDF::loadView('admin::pdf.invoice', $data);

        return $pdf->stream('invoice.pdf');
    }

    /**
     * Send PDF proforma.
     *
     * @param Request $request
     * @param int     $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getSendProforma(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $type = 'proforma';

        $pdf_path = storage_path('app/public/invoices/'.$type.'-'.$order_id.'.pdf');

        if (!File::exists(storage_path('app/public/invoices'))) {
            File::makeDirectory(storage_path('app/public/invoices'), 755, true);
        }

        PDF::loadView('admin::pdf.invoice', compact('order', 'type'))->save($pdf_path);

        // send email
        Mail::send('admin::mail.invoice', ['type' => 'proforma'], function ($m) use ($order, $pdf_path) {
            $m->to($order->billing_email, $order->billing_name)->subject("Proforma invoice No: T-{$order->id}-".date('Y'))->attach($pdf_path);
        });

        $order->order_status_id = 2;
        $order->save();

        return back()->with('success', 'Invoice sent');
    }

    /**
     * Send PDF invoice.
     *
     * @param Request $request
     * @param int     $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getSendInvoice(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $type = 'invoice';

        $max_invoice_number = (int) Order::whereRaw('YEAR(created_at)='.date('Y'))->max('invoice_number');

        $order->invoice_number = $max_invoice_number + 1;
        $order->order_status_id = 4;
        $order->save();

        $pdf_path = storage_path('app/public/invoices/'.$type.'-'.$order_id.'.pdf');

        if (!File::exists(storage_path('app/public/invoices'))) {
            File::makeDirectory(storage_path('app/public/invoices'), 755, true);
        }

        PDF::loadView('admin::pdf.invoice', compact('order', 'type'))->save($pdf_path);

        // send email
        Mail::send('admin::mail.invoice', ['type' => 'invoice'], function ($m) use ($order, $pdf_path) {
            $m->to($order->billing_email, $order->billing_name)->subject("Invoice No: {$order->invoice_number} ".date('Y'))->attach($pdf_path);
        });

        return back()->with('success', 'Invoice sent');
    }

    /**
     * Print PDF invoice.
     *
     * @param Request $request
     * @param int     $order_id
     *
     * @return \Illuminate\Http\Response
     */
    public function getPrintInvoice(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        $type = 'invoice';

        $max_invoice_number = (int) Order::whereRaw('YEAR(created_at)='.date('Y'))->max('invoice_number');

        $order->invoice_number = $max_invoice_number + 1;
        $order->save();

        return PDF::loadView('admin::pdf.invoice', compact('order', 'type'))->download($type.'-'.$order_id.'.pdf');
    }

    /**
     * Remove from stock.
     */
    private function removeFromStock($order)
    {
        if ($order->order_status_id == 5) {
            foreach ($order->items as $item) {
                $item->product->stock--;
                $item->product->save();
            }
        }
    }

    public function getViewItem($item_id)
    {
        $orderItem = OrderItem::find($item_id);

        $variation = OrderItemVariation::whereOrderItemId($item_id)->get();

        return view('admin::orders.item', compact('orderItem', 'variation'));
    }
}
