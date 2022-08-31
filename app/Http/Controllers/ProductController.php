<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Log;
use DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $products = new Product;
            if ($request->product_type) {
                $products = $products->whereIn("product_type",$request->product_type);
            }
            if ($request->category) {
                $products = $products->whereIn("category",$request->category);
            }
            if ($request->concept) {
                $products = $products->whereIn("concept",$request->concept);
            }
            if ($request->published_year) {
                $years = $request->published_year;
                $products = $products->where(function($q) use($years) {
                    foreach ($years as $year) {
                        $q->whereYear('publication_date', '=', $year, 'or');
                    }
                });
            }
            if ($request->language) {
                $products = $products->whereIn("language",$request->language);
            }
            $products = $products->get();
            $response = array('data' => $products,'responseMessage' => "Success");
			return response()->json($response)->setStatusCode(200);
        } catch (\Exception $e) {
			$response = array('data' => null,'responseMessage' => $e->getMessage());
			return response()->json($response)->setStatusCode(400);
        }
    }

    public function GetProductFilters(Request $request) {
        try{
            $filters['published_years'] = Product::selectRaw('DISTINCT(YEAR(publication_date)) as published_year')
                ->orderBy('publication_date','desc')->get();

            $filters['categories'] = Product::selectRaw('count(id) as total, category')
                ->whereNotNull('category')->groupBy('category')->orderBy('total', 'desc')->get();

            $filters['concepts'] = Product::selectRaw('DISTINCT(concept) as concept, count(id) as total')
                ->whereNotNull('concept')->groupBy('concept')->orderBy('total', 'desc')->get();

            $filters['languages'] = Product::selectRaw('DISTINCT(language) as language, count(id) as total')
                ->where('language',"!=",'0')->groupBy('language')->orderBy('total', 'desc')->get();

            $filters['product_type'] = Product::selectRaw('DISTINCT(product_type) as product_type, count(id) as total')
                ->whereNotNull("product_type")->groupBy('product_type')->orderBy('total', 'desc')->get();

            $response = array('data' => $filters,'responseMessage' => "Success");
			return response()->json($response)->setStatusCode(200);
        } catch (\Exception $e) {
			$response = array('data' => null,'responseMessage' => $e->getMessage());
			return response()->json($response)->setStatusCode(400);
        }
    }
}
