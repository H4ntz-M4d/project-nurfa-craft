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
        return view('admin.utilities.variant-list',[
            'title' => 'Variant Produk',
            'sub_title' => 'Utilities - Variant Produk',
        ]);
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
                    <a href="#" class="btn btn-sm btn-danger btn-flex btn-center btn-active-light-primary" data-id="'.$row->id_variant_attributes.'" data-kt-variant-table-filter="delete_row">
                        <i class="ki-solid ki-eraser fs-5 ms-1"></i>
                        Delete
                    </a>
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
