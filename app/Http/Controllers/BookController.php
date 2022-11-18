<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\BookInterface;

class BookController extends Controller
{
    protected $bookInteface;

    public function __construct(BookInterface $bookInteface)
    {
        $this->bookInteface = $bookInteface;
    }

    public function index()
    {
        return $this->bookInteface->getAllBooks();
    }

    public function store(Request $request)
    {
        return $this->bookInteface->requestBook($request);
    }

    public function show($id)
    {
        return $this->bookInteface->getBookById($id);
    }

    public function update(Request $request, $id)
    {
        return $this->bookInteface->requestBook($request, $id);
    }
    
    public function delete($id)
    {
        return $this->bookInteface->deleteBook($id);
    }
}