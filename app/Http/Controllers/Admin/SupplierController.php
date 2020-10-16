<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Exception;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('viewAny', Supplier::class)) {
            $suppliers = Supplier::all();

            return view('admin.suppliers.index', compact('suppliers'));
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SupplierRequest $request)
    {
        if (Auth::user()->can('create', Supplier::class)) {
            Supplier::create($request->all());

            return redirect()->back()->with('message_success', trans('message_success'));
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->can('view', Supplier::class)) {
            $supplier = Supplier::find($id);
            if (empty($supplier)) {
                $data = [
                    'status' => config('setting.http_status.errors'),
                    'message' => trans('message_error'),
                ];

                return json_encode($data);
            }
            $data = [
                'status' => config('setting.http_status.success'),
                'name' => $supplier->name,
                'phone' => $supplier->phone,
                'address' => $supplier->address,
                'description' => $supplier->description,
                'url' => route('suppliers.update', $supplier->id),
            ];

            return json_encode($data);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SupplierRequest $request, $id)
    {
        if (Auth::user()->can('update', Supplier::class)) {
            Supplier::find($id)->update($request->all());

            return redirect()->back()->with('message_success', trans('message_success'));
        }

        return abort(config('setting.errors404'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->can('delete', Supplier::class)) {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            return redirect()->back()->with('message_success', trans('message_success'));
        }

        return abort(config('setting.errors404'));
    }
}
