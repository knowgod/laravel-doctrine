<?php

namespace App\Http\Controllers\Tries;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Request;

class ArticlesController extends Controller
{

    /**
     * @var \App\Models\Tries\ArticleRepository
     */
    protected $repository;

    /**
     * ArticlesController constructor.
     *
     */
    public function __construct()
    {
        $em = app('em');
        /** @var \Doctrine\ORM\EntityManager $em */
        $this->repository = $em->getRepository('App\Models\Tries\Article');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->repository->paginateAll(3);
        return view('tries.article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tries.article.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $article = EntityManager::find('App\Models\Tries\Article', $id);
        return view('tries.article.show', compact('article'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Request::all();

        $article = $this->repository->createOrUpdate($input);
//        $article->addTag(new Tag('newTag'));

        EntityManager::persist($article);
        EntityManager::flush();

        if ($article->getId()) {
            return redirect("articles/" . $article->getId());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
