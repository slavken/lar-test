<?php

namespace Modules\Blog\Http\Controllers\API;

use App\Models\Article;
use App\Transformers\ArticleTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Modules\Blog\Http\Requests\Article\StoreRequest;
use Modules\Blog\Http\Requests\Article\UpdateRequest;

class UserArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $paginator = Auth::user()
            ->articles()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return fractal()
            ->collection($paginator->getCollection(), new ArticleTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->respond();
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreRequest $request)
    {
        $article = new Article();
        $article->user_id = Auth::id();
        $article->title = $request->title;
        $article->body = $request->body;
        $article->save();

        return response()->json(['message' => 'success'], 201);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        $article = Auth::user()
            ->articles()
            ->findOrFail($id);

        return fractal()
            ->item($article, new ArticleTransformer)
            ->respond();
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->only('title', 'body');

        $article = Article::findOrFail($id);
        $article->update($data);

        return response()->json(['message' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();

        return response()->json(null, 204);
    }
}
