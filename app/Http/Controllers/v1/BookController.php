<?php

namespace App\Http\Controllers\v1;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;

class BookController extends Controller
{
    public function __construct()
    {
        $this->book_service = new BookService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = $this->book_service->listBooks();
       return $response;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBookRequest $request) 
    {
       $response = $this->book_service->createBook($request);
       return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = $this->book_service->showBookById($id);
        return $response;
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = $this->book_service->deleteBookById($id);
        return $response;
    }

    public function storeUser(Request $request) 
    {
       $response = $this->book_service->storeUsers($request);
       return $response;
    }

    public function sendInvite(Request $request) 
    {
       $response = $this->book_service->sendInvite($request);
       return $response;
    }
}