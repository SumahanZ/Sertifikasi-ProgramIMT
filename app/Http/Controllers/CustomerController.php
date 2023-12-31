<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::get();
        return view("customer", [
            "customerList" => $customers,
        ]);
    }

    public function create()
    {
        return view("customer-add");
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view("customer-edit", ["customer" => $customer]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string|min:10',
            'no_telp' => 'required|numeric|min:9',
            'id_card' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect('/customer-add')
                ->withErrors($validator)
                ->withInput();
        }

        $customer = $this->createRecordCustomerDatabase($request);

        if ($customer) {
            Session::flash("status", "success");
            Session::flash("message", "Add new customer success!");
        }

        return redirect("/customers");
    }

    private function createRecordCustomerDatabase(Request $request)
    {
        $customer = Customer::create($request->all());
        return $customer;
    }

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'alamat' => 'required|string|min:10',
            'no_telp' => 'required|numeric|min:9',
            'id_card' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect("/customer-edit/$id")
                ->withErrors($validator)
                ->withInput();
        }

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        if ($customer) {
            Session::flash("status", "success");
            Session::flash("message", "Edit customer success!");
        }

        return redirect("/customers");
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);
        return view("customer-delete", ["customer" => $customer]);
    }

    public function destroy($id)
    {
        $deleteCustomer = Customer::findOrFail($id);
        $deleteCustomer->delete();

        if ($deleteCustomer) {
            Session::flash("status", "success");
            Session::flash("message", "Delete customer success!");
        }

        return redirect("/customers");
    }
}
