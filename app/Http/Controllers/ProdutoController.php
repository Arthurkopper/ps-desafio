<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreProdutoRequest;


class ProdutoController extends Controller
{
    private $produtos;
    private $categorias;

    public function __construct(Produto $produtos, Categoria $categorias){
        $this-> produtos = $produtos;
        $this-> categorias = $categorias;
    }

    public function index()
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        return view('produto.index', ['produtos' => $produtos, 'categoria' => $categorias]);
    }


    public function create()
    {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        return view('produto.crud',['produtos' => $produtos, 'categorias' => $categorias]); 
    }


    public function store(StoreProdutoRequest $request)
    {
        $datas = $request-> all(); 
        $datas['imagem'] = $request-> file('imagem') -> store('produtos', 'public');
        $this -> produtos -> create($datas);
        
        return redirect('/produto'); 
    }


    public function show($id)
    {
        $produto = $this->produtos->find($id);
        $categorias = $this->categorias->find($produto -> categoria_id);
        $produto -> categoria = $categorias -> categoria;
        return json_encode($produto);
    }


    public function edit($id)
    {
        $produto = $this->produtos->find($id); //Pego o ID da categoria que irei editar;
        $categorias = $this->categorias->all();
        return view('produto.crud',compact('produto', 'categorias')); 
    }


    public function update(Request $request, $id)
    {
        $datas = $request->all();
        $produto =  $this -> produtos -> find($id);

        if ($request -> hasFile('imagem')){
            Storage::delete('public/' . $produto->imagem);
            $datas['imagem'] = $request -> file('imagem') -> store('produtos', 'public');
        }
        $produto -> update($datas);
        
        return redirect('/produto'); 
    }

    public function destroy($id)
    {
        $produto =  $this -> produtos -> find($id);
        Storage::drive('public') -> delete($produto-> imagem);

        $produto -> delete();
        return redirect('/produto');
    }


    public function produtos(){
        $produtos = Produto::all();
        $categorias = Categoria::all();
        return view('produtos.site', ['produtos' => $produtos, 'categorias' => $categorias]);
    }

    public function formulario(Request $request){
        $categorias= Categoria::all();
        $produtos = null;
        $categoria = Categoria::find($request->categoria_id);
        if($categoria){
            $produtos = $categoria -> produto;
            return view('produtos.site', ['categoria_id' => $categoria->id , 'produtos' => $produtos, 'categorias'=> $categorias]);
        }
        else{
            $produtos= Produto::all();
        }
        
        return view('produtos.site', [ 'produtos' => $produtos, 'categorias'=> $categorias]);
    }
}
