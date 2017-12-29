<?php
namespace App\Http\Controllers;

use App\Produto;
use App\Categoria;
use Illuminate\Http\Request;
use App\Transformers\produtoTrasformer;

/* API
$produtos = Produto::allForTable('pt');   //Retornar todos os produtos formatados para a DataTable
$categoria = \App\Categoria::where('Categoria_pt', 'Suplemento')->firstOrFail();   //Encontra a categoria, precisa de firstOrFail() para nao retornar como array, mesmo so com um elemento
$columns = Produto::columns();            //Retorna as colunas dos produtos
$columns = \App\Categoria::columns();     //Retorna as colunas das categorias
$produtos = $categoria->produtos;         //Retorna todos os produtos sem formatação
$produtos = $categoria->produtosForTable('pt');     //Retorna todos os produtos de uma categoria Formatados para a DataTable
$columns = $categoria->produtosColumns();        //Retorna as colunas utilizadas para esta categoria de produtos
 */

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Produto::all()->transformWith(new produtoTrasformer())->toArray();

    }

    public function categorias(Request $request)
    {

        $data = \App\Categoria::allForTable();

        if ($request->ajax())
            return $data;

        $columns = \App\Categoria::columns();
        $categorias = \App\Categoria::names(\App::getLocale());

        return view('layout.content', compact('data', 'columns', 'categorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'produto' => 'required|string',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'dci_composicao' => 'nullable|string',
            'forma' => 'nullable|string',
            'embalagem' => 'nullable|string',
            'med_id' => 'nullable|string',
            'pais_registo' => 'nullable|string',
            'imagem' => 'nullable|image'
        ]);

        Produto::create(request([
            'produto',
            'categoria_id',
            'dci_composicao',
            'forma',
            'embalagem',
            'med_id',
            'pais_registo',
            'imagem'
        ]));

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return fractal()
            ->item($produto)
            ->transformWith(new produtoTrasformer())
            ->toArray();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Produto $produto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produto $produto)
    {
        $this->validate($request, [
            'produto' => 'required|string',
            'categoria_id' => 'required|integer|exists:categorias,id',
            'dci_composicao' => 'nullable|string',
            'forma' => 'nullable|string',
            'embalagem' => 'nullable|string',
            'med_id' => 'nullable|string',
            'pais_registo' => 'nullable|string',
            'imagem' => 'nullable'
        ]);

        $produto->update(request([
            'produto',
            'categoria_id',
            'dci_composicao',
            'forma',
            'embalagem',
            'med_id',
            'pais_registo',
            'imagem'
        ]));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();

        return back();
    }


    public function destroyMul($produtos)
    {
        $produtos = explode(",", $produtos);

        Produto::find($produtos)->each(function ($product, $key) {
            $product->delete();
        });

        return back();
    }
}
