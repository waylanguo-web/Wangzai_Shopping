<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Category;
use Livewire\Component;

class AllOrdersComponent extends Component
{
    public function viewOrderDetails($id)
    { 
        if($id)
        {
            return redirect()->route('admin.orders.details', ['id'=>$id]);
        }
    }
    public function render()
    {
        $orders = Order::orderBy('created_at', 'DESC')->get();
        $categories = Category::all();
        return view('livewire.admin.all-orders-component', ['orders'=>$orders, 'categories'=>$categories])->layout('components.layouts.admin');
    }
}
