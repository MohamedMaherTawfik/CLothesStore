<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\colorRequest;
use App\Http\Requests\productRequest;
use App\Http\Requests\sizeRequest;
use App\Http\Requests\stockRequest;
use App\Http\Resources\ProductsResoucres;
use App\Models\productColors;
use App\Models\productSizes;
use App\services\colorSizesServices;
use App\Services\productServices;
use App\services\StockServices;
use Illuminate\Http\Request;

class productController extends Controller
{
    use apiResponse;
    private $productServices;

    public function __construct(productServices $productServices){
        $this->productServices = $productServices;
    }

    public function index(){
        $data= $this->productServices->allProducts();
        if(count($data) == 0){
            return $this->sendError(__('messages.Error_index_Message'));
        }
        return $this->apiResponse($data,__('messages.index_Message'));
    }

    public function store(productRequest $request){
        $fields=$request->validated();
        if($fields){
            if($request->hasFile('image')){
                $file=$request->file('image');
                $name=time().'.'.$file->getClientOriginalName();
                $file->move(public_path('products'),$name);
                $fields['image']=$name;
            }
            $colors=productColors::all();
            $sizes=productSizes::all();
            $data=$this->productServices->createProduct($fields, $colors, $sizes);
            return $this->apiResponse($data,__("messages.store_Message"));
        }
        return $this->sendError(__("messages.Error_store_Message"));

    }

    public function show(){
        $data=$this->productServices->showProduct(request('id'));
        if(!$data){
            return $this->sendError(__("messages.Error_show_Message"));
        }
        return $this->apiResponse($data,__("messages.show_Message"));
    }

    public function update(productRequest $request, $id){
        $fields=$request->validated();
        if($fields){
            if($request->hasFile('image')){
                $file=$request->file('image');
                $name=time().'.'.$file->getClientOriginalName();
                $file->move(public_path('products'),$name);
                $fields['image']=$name;
            }
            $data=$this->productServices->updateProduct($id, $fields);
            return $this->apiResponse(new ProductsResoucres($data),__("messages.update_Message"));
        }
        return $this->sendError(__("messages.Error_update_Message"));
    }

    public function updateStock(stockRequest $request){
        $fields=$request->validated();
        $updated=$this->productServices->updateProductStock(request('id'), $fields);
        if(!$updated){
            return $this->sendError(__("messages.Error_stock_Message"));
        }
        return $this->apiResponse($updated,__("messages.stock_Message"));
    }

    public function destroy($id){
        $data=$this->productServices->deleteProduct($id);
        if(!$data){
            return $this->sendError(__("messages.Error_destroy_Message"));
        }
        return $this->apiResponse($data,__("messages.destroy_Message"));
    }

    // public function colorSizes($id){
    //     $data=$this->productServices->getColorSizes($id);
    //     if(!$data){
    //         return $this->sendError('Sizes Not Found');
    //     }
    //     return $this->apiResponse($data,'Sizes Fetched Successfully');
    // }

    // public function sizes(){
    //     $data=$this->productServices->getSizes(request('id'));
    //     if(!$data){
    //         return $this->sendError('Sizes Not Found');
    //     }
    //     return $this->apiResponse($data,'Sizes Fetched Successfully');
    // }

    // public function colors(){
    //     $data=$this->productServices->getColors(request('id'));
    //     if(!$data){
    //         return $this->sendError('Colors Not Found');
    //     }
    //     return $this->apiResponse($data,'Colors Fetched Successfully');
    // }


}
