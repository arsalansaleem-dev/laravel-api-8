<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BookInterface
{
    public function getAllBooks();

    public function getBookById($id);

    public function requestBook($request, $id);

    public function deleteBook($id);
}