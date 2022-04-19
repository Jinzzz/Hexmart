<?php
namespace App\Http\Controllers\customer;

use App\Http\Controllers\Controller;
use App\Models\admin\Mst_CustomerBanner;
use App\Models\admin\Mst_ItemCategory;
use App\Models\admin\Mst_OfferZone;
use App\Models\admin\Mst_ProductVariant;
use App\Models\admin\Mst_ItemSubCategory;
use App\Models\admin\Mst_ItemLevelTwoSubCategory;
use App\Models\admin\Mst_Product;
use App\Models\admin\Trn_Cart;
use App\Models\admin\Trn_WishList;
use App\Models\admin\Mst_Customer;
use App\Models\admin\Trn_CustomerAddress;
use App\Models\CustomerPhone;
use Auth;
use Illuminate\Session\Middleware\StartSession;

use Illuminate\Http\Request;

class CartController extends Controller
{
    protected function guard()
    {
        return Auth::guard('customer');
    }
    /*
    Description : Add to cart details
    Date        : 29/3/2022
    
    */

    public function addcart(Request $request)
    {
        $id = $request->product_id;
        $product_check = Mst_ProductVariant::where('product_variant_id', $id)->first();
        if (Auth::guard('customer')->check())
        {
        $customerid=Auth::guard('customer')->user()->customer_id;

        if (Trn_Cart::where('customer_id', $customerid)->where('product_variant_id', $id)->exists())
        {
            return response()
                ->json(['status' => ucfirst($product_check->variant_name) . " " . "Already Added To Cart"]);
        }
        else
        {
                $cart = new Trn_Cart();
                $cart->customer_id=Auth::guard('customer')->user()->customer_id;
                $cart->product_variant_id = $id;
                $cart->quantity = 1;
                $cart->save();
                return response()
                    ->json(['status' => ucfirst($product_check->variant_name) . " " . "Added To Cart"]);
        }
        }
        else
        {
            return response()->json(['status' => "Login to Continue"]);
        }
        
    }


     /*
    Description : cart count details shows for the nav bar
    Date        : 29/3/2022
    
    */

    public function Dcart_count()
    {
        $customerid=Auth::guard('customer')->user()->customer_id;
        $count=Trn_Cart::where('customer_id', $customerid)->count();
        return response()->json(['count' => $count]);
    
    }

    /*
    Description : Add to Wish
    Date        : 29/3/2022
    
    */

    public function add_to_wishlist(Request $request)
    {
        $id = $request->product_id;
        $product_check = Mst_ProductVariant::where('product_variant_id', $id)->first();
            if(Auth::guard('customer')->check())
            {
            $wishlist = new Trn_WishList();
            $wishlist->product_variant_id = $id;
            $wishlist->customer_id = Auth::guard('customer')->user()->customer_id;
            $wishlist->save();
            return response()
                ->json(['status' => "Product saved in your wishlist"]);
            }
            else
            {
             return response()
                ->json(['status' => "After Login successfully product should be added to the wishlist"]);   
            }         
    }
   /*
    Description : Remove wish list
    Date        : 29/3/2022
    
    */

    public function remove_whishlist(Request $request)
    {
        $id = $request->product_id;
        if(Auth::guard('customer')->check())
        {
        $product_check = Trn_WishList::where('product_variant_id', $id)->delete();
        return response()->json(['status' => "Product removed from your wishlist"]);
        }
        else
        {
          return response()->json(['status' => "After Login successfully product should be removed to the wishlist"]);
        }

    }

    /*
    Description : Add to cart listing for logged in users
    Date        : 29/3/2022
    
    */

    public function show_Cart()
    {
        if (Auth::guard('customer')
            ->check())
        {
            $navCategoryDetails = Mst_ItemCategory::withCount('itemSubCategoryL1Data')->select('item_category_id', 'category_name_slug', 'category_name', 'category_icon', 'category_description')
                ->where('is_active', 1)
                ->limit(5)
                ->get();
            $cart = Trn_Cart::with('productVariantData')->where('customer_id', Auth::guard('customer')->user()
                ->customer_id)->orderBy('created_at','desc')
                ->get();
            $count = Trn_Cart::where('customer_id', Auth::guard('customer')->user()
                ->customer_id)
                ->count();  
            if($cart->isEmpty())
            {
              $total_price=0;
            }
            else
            {
              $details=[];
            foreach($cart as $key=>$val)
            {
                $details[]=$val->productVariantData->variant_price_offer;
                $total_price=array_sum($details);
            }
            }
    
            return view('customer.cart.list', compact('navCategoryDetails', 'cart','count','total_price'));
        }
        else
        {
            return redirect() ->route('customerlogin');
        }

    }


    /*
    Description : Buy Now product purchase details
    Date        : 29/3/2022
    
    */

    public function by_now(Request $request)
    {
        if (Auth::guard('customer')->check())
        {
            $id=Auth::guard('customer')->user()->customer_id;
            $cart_Details=Trn_Cart::select('cart_id')->where('customer_id',$id)->where('product_variant_id',$request->product_id)->exists();
            if($cart_Details=="true")
            {
              return response()->json(['status' => "Success"]);

            }
            else
            {
                $cart = new Trn_Cart();
                $cart->customer_id=$id;
                $cart->product_variant_id = $request->product_id;
                $cart->quantity = $request->quantity;
                $cart->save();
                return response()->json(['status' => "Success"]);
            }
           
        }
        else
        {
            return response()->json(['status' => "Login to Continue"]);

        }

    }

    /*
    Description : Buy Now product purchase list
    Date        : 29/3/2022
    
    */

    public function by_nowlist($id)
    {
        $cart = Mst_ProductVariant::where('product_variant_id', $id)
                ->first();
        $checkout_user = Mst_Customer::where('customer_id', Auth::guard('customer')->user()
                ->customer_id)
                ->first();        
        $count = Mst_ProductVariant::where('product_variant_id', $id)->count();  
        $qty_id=Trn_Cart::with('productVariantData')->where('customer_id', Auth::guard('customer')->user()->customer_id)->where('product_variant_id', $id)->get();
        $total_price=0;
        foreach($qty_id as $key=>$val)
        {
            $details[]=[
                $details['price']=$val->productVariantData->variant_price_offer,
                $details['quantity']=$val->quantity,
            ];
            $total_price+=$details['price']*$details['quantity'];

        }
        
        return view('customer.cart.bynow',compact('count','cart','total_price','checkout_user'));
    }
    /*
    Description : remove product from addtocart page
    Date        : 29/3/2022
    
    */
    public function remove_pcart($qty_id)
    {
       $delete=Trn_Cart::where('customer_id', Auth::guard('customer')->user()
                ->customer_id)->where('product_variant_id',$id)
                ->delete();
       return redirect()->back();


    }
     /*
    Description : Customer Checkout store address data
    Date        : 1/4/2022
    
    */
    public function Customer_checkout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_mobile'=>'required|min:10|numeric',
            'pin'=>'required|numeric',
            'state'=>'required',
            'city'=>'required',
            'place'=>'required',
            'road'=>'required',
        ]);
        $id=$request->id;
        $customer = Mst_Customer::find($id);
                $customer->customer_name = $request->name;
                $customer->customer_mobile = $request->customer_mobile;
                $customer->altcustomer_mobile=$request->altcustomer_mobile;
                $customer->pin = $request->pin;
                $customer->state = $request->state;
                $customer->city = $request->city;
                $customer->place = $request->place;
                $customer->road = $request->road;
                $customer->update();  
        $address=Trn_CustomerAddress::where('customer_id',$id)->where('is_default',1)->first();        
        $address = Trn_CustomerAddress::find($address->customer_address_id);
                $address->customer_id = $customer->customer_id;
                $address->name = $request->name;
                $address->alternative_phone=$request->altcustomer_mobile;
                $address->phone=$request->customer_mobile;
                $address->pincode = $request->pin;
                $address->state = $request->state;
                $address->city = $request->city;
                $address->house = $request->place;
                $address->street = $request->road;
                $address->is_default = 1;
                $address->update();             
        return \Redirect::route('Order_Summary', [$request->product_id]);

    }
    
     /*
    Description : Customer add to cart Checkout store address data
    Date        : /4/2022
    
    */
    public function Customer_addresscheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'customer_mobile'=>'required|min:10|numeric',
            'pin'=>'required|numeric',
            'state'=>'required',
            'city'=>'required',
            'place'=>'required',
            'road'=>'required',
        ]);
        $id=$request->id;
        $customer = Mst_Customer::find($id);
                $customer->customer_name = $request->name;
                $customer->customer_mobile = $request->customer_mobile;
                $customer->altcustomer_mobile=$request->altcustomer_mobile;
                $customer->pin = $request->pin;
                $customer->state = $request->state;
                $customer->city = $request->city;
                $customer->place = $request->place;
                $customer->road = $request->road;
                $customer->update();

        // $altphone_arry=array();
        // foreach($request->option as $key=>$option)
        // {
        //     $altphone_arry[$key]['customer_id']=$customer->customer_id;
        //     $altphone_arry[$key]['phone']=$option;

        // }
        //  CustomerPhone::insert($altphone_arry);        
        return \Redirect::route('CartOrder_Summary');

    }

    /*
    Description : Update cart quantity details
    Date        : 29/3/2022
    
    */

    public function update_cart_quantity(Request $request)
    {
        $id=$request->product_variant_id;
        $customerid=Auth::guard('customer')->user()->customer_id;
        $product_id=Mst_ProductVariant::select('stock_count')->where('product_variant_id',$id)->first();
        if($product_id->stock_count!==1)
        {
        $Trn_Cart = Trn_Cart::where('cart_id',$request->cart_id)->where('customer_id',$customerid)->first();
        $Trn_Cart->quantity=$request->quantity;
        $Trn_Cart->update(); 
        return response()->json(['status' => $Trn_Cart]);
        }

        else
        {
         return response()->json(['status' => "Availabile only one Product"]);

        }
      
    }

    /*
    Description : Order Summary details
    Date        : 4/4/2022
    
    */
    public function OrderSummary($id)
    {
        $loggedin=Auth::guard('customer')->user()->customer_id;
        $customer=Mst_Customer::where('customer_id',$loggedin)->first();
        $product=Mst_ProductVariant::where('product_variant_id',$id)->first();
        $count=Mst_ProductVariant::where('product_variant_id',$id)->count();
        $qty_id=Trn_Cart::with('productVariantData')->where('customer_id', Auth::guard('customer')->user()->customer_id)->where('product_variant_id', $id)->get();
        $total_price=0;
        foreach($qty_id as $key=>$val)
        {
            $details[]=[
                $details['price']=$val->productVariantData->variant_price_offer,
                $details['quantity']=$val->quantity,
            ];
            $total_price+=$details['price']*$details['quantity'];

        }
        return view('customer.checkout.order_summary',compact('product','customer','count','total_price'));
    }


    /*
    Description : Cart Order Summary details
    Date        : 4/4/2022
    
    */
    public function CartOrder_Summary()
    {
        $loggedin=Auth::guard('customer')->user()->customer_id;
        $customer=Mst_Customer::where('customer_id',$loggedin)->first();        
        $count = Trn_Cart::where('customer_id', $loggedin)->count(); 
        $cart = Trn_Cart::with('productVariantData')->where('customer_id', $loggedin)->get();
        $total_price=0;
        if($cart->isEmpty())
        {
          $total_price;
        }
        else
        {
         
        foreach($cart as $key=>$val)
        {
            $details[]=[
                $details['price']=$val->productVariantData->variant_price_offer,
                $details['quantity']=$val->quantity,
            ];
            $total_price+=$details['price']*$details['quantity'];

        }
        }
    
        return view('customer.checkout.cartordersummary',compact('customer','count','total_price','cart'));
    }


    /*
    Description : Place order details
    Date        : 4/4/2022
    
    */

    public function Placeorder_Cart()
    {
        $loggedin=Auth::guard('customer')->user()->customer_id;
        $checkout_user=Mst_Customer::where('customer_id',$loggedin)->first();        
        $count = Trn_Cart::where('customer_id', $loggedin)->count(); 
        $cart = Trn_Cart::with('productVariantData')->where('customer_id', $loggedin)->get();
        $total_price=0;
        if($cart->isEmpty())
        {
          $total_price;
        }
        else
        {
         
        foreach($cart as $key=>$val)
        {
            $details[]=[
                $details['price']=$val->productVariantData->variant_price_offer,
                $details['quantity']=$val->quantity,
            ];
            $total_price+=$details['price']*$details['quantity'];

        }
        }
    
        return view('customer.cart.cartcheckout',compact('checkout_user','count','total_price','cart'));
    }
}

