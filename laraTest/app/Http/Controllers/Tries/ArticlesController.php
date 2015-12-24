<?php

namespace App\Http\Controllers\Tries;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use LaravelDoctrine\ORM\Facades\EntityManager;

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
        $filter   = Request::all();
        $articles = $this->repository->filterBy($filter, 5);

        return view('tries.article.list', compact('articles', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tries.article.create', ['article' => null]);
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
        $tags    = $article->getTags();
        return view('tries.article.show', compact('article', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Request::all();

        $article = $this->repository->createOrUpdate($input);
//        $article->addTag(new Tag('newTag'));

        EntityManager::persist($article);
        EntityManager::flush();

        if ($article->getId()) {
            return redirect(url("articles", [$article->getId()]));
        }
        return Redirect::back()->withInput();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = EntityManager::find('App\Models\Tries\Article', $id);
        if (!$article) {
            return view('tries.article.show', compact('article'));
        }
        return view('tries.article.create', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request|Request $request
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
        $article = EntityManager::find('App\Models\Tries\Article', $id);
        if (!$article) {
            return view('tries.article.show', compact('article'));
        }

        EntityManager::remove($article);
        EntityManager::flush();
        return redirect("articles");
    }
}
