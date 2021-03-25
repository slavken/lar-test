<?php

namespace Modules\Blog\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return Article::orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return Article::findOrFail($id);
    }
}
