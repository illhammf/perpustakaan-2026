<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\BookCopy;
use Illuminate\Http\Request;

class OpacController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category');
        $language = $request->get('language');

        $books = Book::with(['authors', 'publisher', 'category', 'bookCopies' => function ($q) {
            $q->where('status', 'available')->where('is_active', true);
        }])->where('is_active', true);

        if ($query) {
            $books->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('isbn', 'like', "%{$query}%")
                  ->orWhereHas('authors', function ($authorQuery) use ($query) {
                      $authorQuery->where('name', 'like', "%{$query}%");
                  })
                  ->orWhereHas('publisher', function ($publisherQuery) use ($query) {
                      $publisherQuery->where('name', 'like', "%{$query}%");
                  });
            });
        }

        if ($categoryId) {
            $books->where('category_id', $categoryId);
        }

        if ($language) {
            $books->where('language', $language);
        }

        $books = $books->paginate(12);

        $categories = Category::where('is_active', true)->get();
        $languages = Book::where('is_active', true)->select('language')->distinct()->pluck('language');

        return view('opac.index', compact('books', 'categories', 'languages', 'query', 'categoryId', 'language'));
    }

    public function show(Book $book)
    {
        $book->load(['authors', 'publisher', 'category', 'bookCopies' => function ($q) {
            $q->where('is_active', true);
        }, 'bookCopies.bookshelf']);

        $relatedBooks = Book::with(['authors'])
            ->where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->where('is_active', true)
            ->limit(5)
            ->get();

        return view('opac.show', compact('book', 'relatedBooks'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');

        $books = Book::with(['authors', 'publisher', 'bookCopies' => function ($q) {
            $q->where('status', 'available')->where('is_active', true);
        }])->where('is_active', true);

        if ($query) {
            $books->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('isbn', 'like', "%{$query}%")
                  ->orWhereHas('authors', function ($authorQuery) use ($query) {
                      $authorQuery->where('name', 'like', "%{$query}%");
                  });
            });
        }

        $books = $books->paginate(10);

        return response()->json($books);
    }
}
