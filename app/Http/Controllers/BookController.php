<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Requests\BookCreateUpdateRequest;

class BookController extends Controller
{
    public function list(Request $request)
    {
        $author = $request->author ?? null;
        $published = $request->published ?? null;
        $title = $request->title ?? null;
        $genre = $request->genre ?? null;
        $isbn = $request->isbn ?? null;
        $publisher = $request->publisher ?? null;
        $search = $request->search ?? null;
        $books = Book::active();

        if($title){
            $books->where('title', $title);
        }
        if($author){
            $books->where('author', $author);
        }
        if($genre){
            $books->where('genre', $genre);
        }
        if($isbn){
            $books->where('isbn', $isbn);
        }
        if($published){
            $books->whereDate('published', $published);
        }
        if($publisher){
            $books->where('publisher', $publisher);
        }

        if($search){
            $books = $books->where(function ($query) use ($search){
                return $query->where('title', 'like', '%' . $search . '%')
                                ->orWhere('author', 'like', '%' . $search . '%')
                                ->orWhere('genre', 'like', '%' . $search . '%')
                                ->orWhere('isbn', 'like', '%' . $search . '%')
                                ->orWhere('publisher', 'like', '%' . $search . '%');
            });
        }

        $books = $books->orderBy('created_at', 'desc')->paginate(10);
        return response()->json($books, 200);
    }

    public function store(BookCreateUpdateRequest $request)
    {
        if(isset($request->id)){
            $book = Book::find($request->id);
        } else {
            $book = new Book;
        }
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre = $request->genre;
        $book->description = $request->description;
        $book->isbn = $request->isbn;
        $book->image = $request->image;
        $book->published = $request->published;
        $book->publisher = $request->publisher;
        if($book->save()){
            return response()->json(['status' => 'success', 'message' => 'Details Saved Successfully'], 200);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Something Went Wrong'], 500);
        }
    }

    public function singleBookDetail(Book $book)
    {
        return response()->json(['status' => 'success', 'message' => 'Details Deleted Successfully', 'data' => $book], 200);
    }

    public function delete(Book $book)
    {
        if($book->delete()){
            return response()->json(['status' => 'success', 'message' => 'Details Deleted Successfully'], 200);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Something Went Wrong'], 500);
        }
    }
}
