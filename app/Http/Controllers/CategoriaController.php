<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;

class CategoriaController extends Controller
{
    private $categorias;
    public function __construct(Categoria $categorias){
        $this->categorias = $categorias; //Salvo o valor da coluna categorias na variavel privada 'categorias';
    }

    public function index()
    {
        $categorias = Categoria::all();
        return view('categoria.index',['categorias' => $categorias]);  //Responsável por mostrar a view do index com todos os conteúdos da coluna;
    }


    public function create()
    {
        $categorias = Categoria::all();
        return view('categoria.crud',['categorias' => $categorias]); //Responsável por mostrar a view do edit com o conteúdo da coluna a ser criado;
    }


    public function store(StoreCategoriaRequest $request) //Passo o request da categoria, onde irá analisar se tem pelo menos 3 caracters;
    {
        $categorias = new Categoria; 
        $categorias->categoria = $request->categoria;//Adiciono novo elemento na coluna 'categoria' pertecente á migration categorias;

        $categorias->save(); //Salvo esse valor no banco de dados;
        return redirect('/categoria'); //Redireciono para a parte da categoria já com a categoria adicionada;
    }

    public function edit($id)
    {
        $categoria = $this->categorias->find($id); //Pego o ID da categoria que irei editar;
        return view('categoria.crud',compact('categoria')); //Abre o crud para edição dessa categoria;
    }

    public function update(Request $request, $id)
    {
        $categoria = $this->categorias->find($id); //Pego o ID que irei editar;
        $categoria->categoria = $request->input('categoria'); // Com base no ID dessa categoria, é realizado um input para edição do valor da coluna 'categoria';
        $categoria->save(); // E então é salvo esse valor no banco de dados;
        return redirect('categoria'); //Redireciono para a parte de categorias;
    }

    public function destroy($id)
    {
        Categoria::findOrFail($id)->delete(); //Para deletar uma categoria completa, pega-se o ID dela, e no conjunto que esse ID estiver pertecendo é excluido totalmente;
        return redirect('/categoria');//Redireciono para a parte de categorias;
    }
}
