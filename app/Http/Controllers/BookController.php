<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book; 
use App\Category; 
use App\Http\Resources\Book as BookResource;
use App\Http\Resources\Books as BookResourceCollection;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $criteria = Book::paginate(6);
        return new BookResourceCollection($criteria);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function top($count)
    {
        $criteria = Book::select('*')
            ->orderBy('views', 'DESC')
            ->limit($count)
            ->get();        
        return new BookResourceCollection($criteria);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search($keyword)
    {
        $criteria = Book::select('*')
            ->where('title', 'LIKE', "%".$keyword."%")
            ->orderBy('views', 'DESC')
            ->get();        
        return new BookResourceCollection($criteria);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookResource(Book::find($id));
    }

    public function slug($slug)
    {
        $criteria = Book::where('slug', $slug)->first();
        return new BookResource($criteria);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param  array  $carts
     * @return \Illuminate\Http\Response
     */
    public function cart(Request $request)
    {
        //$request->carts = '[{"id":3,"quantity":4}]';
        $carts = json_decode($request->carts, true);
        $book_carts = [];
        foreach($carts as $cart){
            $id = (int)$cart['id'];
            $quantity = (int)$cart['quantity'];
            $book = Book::find($id);
            if($book){
                $note = 'unsafe';
                if($book->stock >= $quantity){
                    $note = 'safe';
                }
                else {
                    $quantity = (int) $book->stock;
                    $note = 'out of stock'; 
                }
                $book_carts[] = [
                    'id' => $id,
                    'title' => $book->title,
                    'cover' => $book->cover,
                    'price' => $book->price,
                    'quantity' => $quantity,
                    'note' => $note
                ];
            }
        }
        return response()->json([
            'status' => 'success',
            'message' => 'carts',
            'data' => $book_carts,
        ], 200); 
        //foreach ($carts as $cart) {
            //var_dump(($request->carts));
        //}
        //$book_carts = [];
        //Book::find
    }
}
