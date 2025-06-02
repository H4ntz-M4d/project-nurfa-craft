<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VariantAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VariantProduk extends Controller
{
    public function index()
    {
        return view('admin.utilities.variant-list');
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $data = VariantAttribute::withCount('values')
                ->select('id_variant_attributes', 'nama_variant', 'created_at')
                ->orderBy('created_at', 'desc');

            return DataTables::of($data)
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" data-slug="'.$row->id_variant_attributes.'" class="form-check-input" value="'.$row->id_variant_attributes.'">';
                })
                ->addColumn('variant_used', function($row){
                    return $row->values_count ?? '0';
                })                
                ->addColumn('action', function($row){
                    return '
                    <button href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                    <i class="ki-duotone ki-down fs-5 ms-1"></i></button>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="/kategori-edit/'.$row->id_variant_attributes.'" class="menu-link px-3">View</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-slug="'.$row->id_variant_attributes.'" data-kt-variant-table-filter="delete_row">Delete</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    ';
                })
                ->rawColumns(['checkbox', 'action', 'variant_used'])
                ->make(true);
        }
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_variant' => 'required|string|max:255',
        ]);

        VariantAttribute::create([
            'nama_variant' => $request->nama_variant,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil disimpan',
        ]);
    }

    public function destroy($slug)
    {
        $variant = DB::table('variant_attributes')->where('id_variant_attributes', $slug)->delete();

        if (!$variant) {
            abort(404, 'Variant tidak ditemukan');
        }
        
        return response()->json(['success' => true, 'message' => 'Variant berhasil dihapus']);
    }
    
    public function destroySelected(Request $request)
    {
        $ids = $request->ids;
        if (!$ids || !is_array($ids)) {
            return response()->json(['success' => false, 'message' => 'ID tidak valid'], 400);
        }

        DB::table('variant_attributes')->whereIn('id_variant_attributes', $ids)->delete();

        return response()->json(['success' => true, 'message' => 'Data Variant berhasil dihapus']);
    }
}
