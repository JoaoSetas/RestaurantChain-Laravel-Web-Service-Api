<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{

    protected $guarded = ['id'];

    /**
     * Categoria de um produto
     *
     * @return Retorna como objecto a tabela da categoria deste produto
     */
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }


    /**
     * Classificação de um produto
     *
     * @return Retorna como objecto a tabela da classificação deste produto
     */
    public function classificacao(){
        return $this->belongsTo(Classificacao::class);
    }


    /**
     * Colunas para produtos
     *
     * @return Retorna os titulos das colunas para os produtos em geral
     */
    public static function columns()
    {
        return [['title' => __('Nome')],
                ['title' => __('Categoria')], 
                ['title' => __('DCI/Composição')], 
                ['title' => __('Forma')], 
                ['title' => __('Embalagem')], 
                ['title' => __('Med Id')],
                ['title' => __('País')], 
                ['title' => __('Imagem')]
                ];
    }

    /**
     * Todos os produtos formatados para a Datatable
     *
     * @param  locale ou en para escolher o campo correcto da base de dados
     * @return Retorna todos os produtos formatados
     */
    public static function allForTable($locale = 'pt'){
        $produtos = Produto::all();
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
    }
}
