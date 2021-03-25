<?php

namespace Modules\Blog\Http\Controllers\API;

use App\Models\Article;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $paginator = Article::orderBy('created_at', 'desc')
            ->paginate(10);

        return fractal()
            ->collection($paginator->getCollection(), new ArticleTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $article = Article::findOrFail($id);

        return fractal()
            ->item($article, new ArticleTransformer)
            ->respond();
    }
}
