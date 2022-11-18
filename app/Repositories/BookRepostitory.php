<?php
namespace app\Repositories;

use App\Interfaces\BookInterface;
use App\Traits\Response;
use App\Book;
use DB;
use Illuminate\Support\Facades\Redis;


class BookRepository implements BookInterface
{
    use Response;
    private $book;


    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function getAllBooks()
    {
        try {
            $books = null;

            $cacheBook = Redis::get('books');

            if(isset($cacheBook)){
                $books = json_decode($cacheBook, FALSE);
            }else{
                $books = Book::all();
                Redis::set('books', $books);
            }

            return $this->success("All Books", $books);

        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function getBookById($id)
    {
        try {
            $cacheBook = Redis::get('books_' . $id);

            $book = null;
            if(isset($cacheBook)){
                $book = json_decode($cacheBook, FALSE);

            }else{
                $book = Book::find($id);
                Redis::set('books_' . $id, $book);
            }

            if(!$book) return $this->error("No book with ID $id", 404);

            return $this->success("Book Detail", $book);
        } catch(\Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }   

    public function requestBook($request, $id = null)
    {
        DB::beginTransaction();
        try {
            $book = $id ? Book::find($id) : new Book;

            // Check the book 
            if($id && !$book) return $this->error("No book with ID $id", 404);

            $book->title = $request->title;
            $book->description = $request->description;
            
            $book->save();

            DB::commit();

            if ($id) {
                Redis::del('books_' . $id);
                Redis::del('books');
            }
            
            Redis::set('books_' . $id, $book);
            Redis::set('books', Book::all());

            return $this->success(
                $id ? "Book updated"
                    : "Book created",
                $book, $id ? 200 : 201);

        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteBook($id)
    {
        DB::beginTransaction();
        try {
            $book = Book::find($id);

            if(!$book) return $this->error("No book with ID $id", 404);

            // Delete the book
            $book->delete();

            DB::commit();

            Redis::del('books_' . $id);

            return $this->success("Book deleted", $book);
        } catch(\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}