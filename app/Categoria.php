<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{

    protected $guarded = ['id'];

    /**
     * Todos os produtos de uma categoria.
     *
     * @return Retorna todos os produtos associados a esta categoria
     */
    public function produtos(){
        return $this->hasMany(Produto::class);
    }

    /**
     * Todas as categorias formatadas para a Datatable
     *
     * @param  pt ou en para escolher o campo correcto da base de dados
     * @return Todas as categorias formatadas
     */
    public static function allForTable(){
        $categorias = Categoria::all();
        return $categorias->map(function ($item){
              return [
                $item->categoria_pt,
                $item->categoria_en,
                $item->imagem,
                $item->ativa, 
                $item->id
            ];
        });
    }

    public static function names($locale = 'pt'){
        return Categoria::all()->map(function ($item) use ($locale){
              return (object)['id' => $item->id, 'nome' => $item['categoria_'.($locale == null ? 'pt' : $locale)]];
        });
    }


    /**
     * Todos os produtos de um categoria formatados para a Datatable e com os campos correctos para esta categoria.
     *
     * @param  pt ou en para escolher o campo correcto da base de dados
     * @return Retorna todos os produtos associados a esta categoria formatados e com os campos correctos para esta categoria.
     */
    public function produtosForTable($locale = 'pt'){
        $produtos = $this->produtos;

        if(in_array($this->id, array(1, 4, 5, 6)))
            return $produtos->map(function ($item) use ($locale){
                return [
                    $item->produto,
                    $item->categoria['categoria_'.($locale == null ? 'pt' : $locale)],
                    $item->dci_composicao,
                    $item->forma,
                    $item->embalagem,
                    $item->med_id,
                    $item->pais_registo,
                    $item->imagem,
                    $item->id
                ];
            });
        else
            return $produtos->map(function ($item) use ($locale){
                return [
                    $item->produto,
                    $item->categoria['categoria_'.($locale == null ? 'pt' : $locale)],
                    $item->dci_composicao,
                    $item->forma,
                    $item->embalagem,
                    $item->imagem,
                    $item->id
                ];
            });
    }

    /**
     * Colunas para os produtos desta categoria
     *
     * @return Retorna os titulos das colunas para os produtos desta categoria
     */
    public function produtosColumns(){
        $columns =  [['title' => __('Nome')],
            ['title' => __('Categoria')],];

        if(in_array($this->id, array(1, 4, 5, 6)))
            array_push($columns, 
                ['title' => 'DCI'], 
                ['title' =>  __('Forma Farmacêutica')], 
                ['title' =>  __('Embalagem')], 
                ['title' =>  __('Med Id')],
                ['title' =>  __('País')], 
                ['title' =>  __('Imagem')]);
        else
            array_push($columns, 
                ['title' => __('Composição')], 
                ['title' => __('Forma Farmacêutica')], 
                ['title' => __('Embalagem')], 
                ['title' => __('Imagem')]);

        return $columns;
    }

    /**
     * Colunas para categorias
     *
     * @return Retorna os titulos das colunas para as categorias
     */
    public static function columns(){

        return [['title' => __('Categoria') . ' PT'],
            ['title' => __('Categoria') . ' EN'], 
            ['title' => __('Imagem')],
            ['title' => __('Ativo')]];
    }
}
