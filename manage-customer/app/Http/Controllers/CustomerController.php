<?php

namespace App\Http\Controllers;

use App\Customers;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
//        hiển thị danh sách khách hàng
        $customers = Customers::paginate(5);
        return view("list", compact("customers"));
    }

    public function create()
    {
//        show form tạo mới khách hàng
        return view('create');
    }

    public function store(CreateCustomerRequest $request)
    {
//        thực hiện thêm mới khách hàng
        $customer = new Customers();
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->email = $request->email;
        if ($request->hasFile('inputFile')) {
            $file = $request->inputFile;
            $path = $file->store('images', 'public');
            $customer->avatar = $path;
        }
        else{
            $customer->avatar='images/6uS8z9O6snM7GBEEq34LZw1iqx8Ioc548gsAuKJt.png';
        }
        $customer->save();
        return redirect()->route('customers.index');
    }

    public function edit($id)
    {
//      hiển thị form và dữ liệu khách hàng cần sửa
        $customer = Customers::findOrFail($id);
        return view('edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customers::findOrFail($id);
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->email = $request->email;
        if ($request->hasFile('inputFile')) {
            $file = $request->inputFile;
            $path = $file->store('images', 'public');
            $customer->avatar = $path;
        }
        $customer->save();
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
//        xóa khách hàng
        Customers::destroy($id);
        return redirect()->route('customers.index');
    }

}
