<?php
namespace App\Services;

use App\Http\Controllers\v1\MailController;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BookService {

    public function __construct()
    {
        $this->book_model = new Book();
    }
    public function createBook($request) 
    {
        try {
            $book = $this->book_model->create([
                'book_name' => $request->book_name,
                'isbn' => $request->isbn,
                'pages' => $request->pages,
                'date_published' => $request->date_published,
                'publisher' => $request->publisher,
                'pdf' => $this->bookUpload($request),
            ]);
             
            if(! $book){
                return response()->json([
                    'response'  => false,
                    'status'    => 500,
                    'message'   => 'Book couldn\'t be created!'
                ]);
            }

            //store book author(s)
            $authors = json_decode($request->authors);
            $authors->validate([
                'authors' => 'required|array'
            ]);
            foreach ($authors as $author) {
                $author = $book->author()->create([
                    'firstname' => $author->firstname,
                    'lastname' => $author->lastname,
                    'qualification' => $author->qualification,
                ]);
            }
            
           if ($author) {
               return response()->json([
                   'response'  => true,
                   'status'    => 201,
                   'message'   => 'Book Successfully created'
               ]);
           }
            
            
            return response()->json([
                'response'  => false,
                'status'    => 500,
                'message'   => 'Author couldn\'t be created'
            ]);
        } catch (\Throwable $th) {
            $this->error($th);
        }
        
    }

    //get all books from books table
    public function listBooks()
    {
        try {
            $books = $this->book_model->with('author')->paginate(20);
            //check if book is empty
            if($books === null) {
                return response()->json([
                    'response'  => false,
                    'status'    => 404,
                    'message'   => 'No available book in your reading list'
                ]);
            }

            return response()->json([
                'response'  => true,
                'status'    => 200,
                'data'   => $books
            ]);

        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    public function deleteBookById($id)
    {
        try {
            $book = $this->book_model->find($id);
            if ($book === null) {
                return response()->json([
                    'response'  => false,
                    'status'    => 404,
                    'message'   => 'This book does not exist'
                ]);
            }
            //delete book
            $this->removeFileFromPath($book);
            $book->delete();
            return response()->json([
                'response'  => true,
                'status'    => 201,
                'message'   => 'Book deleted successfully'
            ]);
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }

    /**
     * @return void
     */
    public function removeFileFromPath($book) : void
    {
        $path = 'books/'.$book->pdf;
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }

    public function showBookById($id)
    {
        try {
            $book = $this->book_model->with('author')->find($id);
            if ($book === null) {
                return response()->json([
                    'response'  => false,
                    'status'    => 404,
                    'message'   => 'This book does not exist'
                ]);
            }
            
            return response()->json([
                'response'  => true,
                'status'    => 200,
                'data'   => $book
            ]);
            
        } catch (\Throwable $th) {
            $this->error($th); 
        }
    }

    /**
     * upload book in pdf format
     * @return string
     */
    public function bookUpload($request) : string
    {
        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $filename = $request->book_name.'_'.time().'.'.$pdf->extension();
            if($pdf->storeAs('books', $filename)){
                return $filename;
            }
            return null;
        }
    }



    public function storeUsers($request)
    {
        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        if (! $users) {
            return response()->json([
                'response'  => false,
                'status'    => 500,
                'message'   => 'User couldn\'t be created!'
            ]);
        }

        return response()->json([
            'response'  => true,
            'status'    => 201,
            'message'   => 'User Successfully created'
        ]);
    }

   

    public function sendInvite()
    {
        //get users
        $users = User::select(['email', 'name'])->get();
        $mailer = new MailController();
        foreach ($users as $user) {
            $mailer->sendEmail($user->email, $user->name);
        }
        return [
            'response' => true,
            'status'    => 200,
            'message' =>'Email sent'
        ];
    }

    
    //500 error definition
    public function error($th)
    {
        return response()->json([
            'response'  => false,
            'status'    => 500,
            'error'     => $th->getMessage()
        ]);
    }
}