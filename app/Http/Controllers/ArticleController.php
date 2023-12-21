<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleCreateRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{

//    register
    public function createArticle(ArticleCreateRequest $request):JsonResponse
    {
        $data = $request->validated();
        $user = Auth::user();

        $article = new Article($data);
        $article->save();

        return (new ArticleResource($article))->response()->setStatusCode(201);
    }

    public function getArticle(): JsonResponse
    {
        $articles = Article::all();
        $articleCount = $articles->count();

        return (ArticleResource::collection($articles))
            ->additional(['article_count' => $articleCount])
            ->response()
            ->setStatusCode(200);
    }
    public function getArticleById($id): JsonResponse
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        return (new ArticleResource($article))
            ->response()
            ->setStatusCode(200);
    }
}
