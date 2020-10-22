<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\ReplyCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Image;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(config('setting.paginate.product'));
        $categories = Category::where('parent_id', null)->get();
        $children = Category::where('parent_id', '<>', null)->get();

        return view('users.pages.product', compact('products', 'categories', 'children'));
    }

    public function show($id)
    {
        try {
            $product = Product::with(['images','productDetails','comments'])->findOrFail($id);
            $images = $product->images;
            $productDetails = $product->productDetails;
            $comments = $product->comments->where('parent_id', '=', null);

            return view('users.pages.product_detail', compact('product', 'images', 'productDetails', 'comments'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function quantity($id)
    {
        try {
            $productDetails = ProductDetail::findOrFail($id);
            $data = [
                'quantity' => $productDetails->quantity,
                'size' => $productDetails->size,
            ];

            return json_encode($data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function comment(CommentRequest $request, $id)
    {
        Comment::create([
            'product_id' => $id,
            'user_id' => Auth::user()->id,
            'message' => $request->comment,
            'rate' => $request->rating,
            'status' => config('setting.comment.accept'),
        ]);
        $avg = Comment::where([['product_id', '=', $id], ['parent_id', '=', null]])->avg('rate');
        Product::find($id)->update([
           'rate' => round($avg),
        ]);

        return redirect()->back();
    }

    public function replyComment(ReplyCommentRequest $request, $commentId, $productId)
    {
        Comment::create([
            'product_id' => $productId,
            'user_id' => Auth::user()->id,
            'parent_id' => $commentId,
            'message' => $request->reply,
            'rate' => config('setting.rate'),
            'status' => config('setting.comment.accept')
        ]);

        return redirect()->back();
    }

    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);
        if (Auth::user()->can('delete', $comment)) {
            $comment->delete();

            return redirect()->back();
        }

        return abort(config('setting.errors404'));
    }

    public function getProductByCategory($id)
    {
        $products = Product::where('category_id', $id)->paginate(config('setting.paginate.product'));
        $categories = Category::where('parent_id', null)->get();
        $children = Category::where('parent_id', '<>', null)->get();

        return view('users.pages.product', compact('products', 'categories', 'children'));
    }
}
