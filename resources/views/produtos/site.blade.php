@extends('produtos.index')

@section('cabecalho') <!-- Responsável pelo cabeçalho da página -->
<header class = "cabecalho-principal"> 
  
  <nav class="cabecalho"> 
    <a class="Adapti"> Produtos </a>
      
    <form action="/formulario" method="GET">
      <select onchange="this.form.submit()" class="cabecalho-fonte" name="categoria_id" id="categoria_id">
            <option  value="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Todas as categorias</option>
            @foreach($categorias as $categoria)
            <option  @isset($categoria_id) @if($categoria_id == $categoria->id) selected @endif  @endisset value="{{$categoria->id}}">{{$categoria->categoria}}</option>
            @endforeach
      </select>
    </form>
  
    <a href="https://adapti.info/#sobre-nos"> <button class="cabecalho-fonte">Entre em contato</button></a>
  </nav>
</header>
@endsection

@section('conteudo') <!-- Responsável pelo conteúdo da página, após o cabeçalho -->
<main class="conteudo">
@foreach($produtos as $produto)
  <section class="produtos" id = " produtos2" >
        <div class="descricao">
            <h1 class = "principal">{{$produto->nome}}</h1>
            <img class="imagens" src="/storage/{{$produto->imagem}}" alt="{{$produto->nome}}" >  
            <span class="sub-principal">Categoria: {{$produto->categoria()->pluck('categoria')->first()}}.</span>
            @if($produto->quantidade == 0)
              <span class="sub-principal">Esgotado.</span>
            @else
              <span class="sub-principal">Preço: {{$produto->preco}} Reais.</span>
            @endif
            <p class="sub-principal">Descrição: {{$produto->descricao}}</p>
            <span class="sub-principal">Quantidade disponivel: {{$produto->quantidade}}.</span>  
        </div>     
  </section>
@endforeach

</main>
@endsection

@section('footer') <!-- Responsável pelo footer da página -->
<footer class="footer">
 <h4 class="texto-footer">© 2022, Feito com <strong class="coracao">&hearts;</strong> por <a class="strong-footer" href="https://adapti.info/">Adapti - Soluções Web.</a></h4>
 <div class="div-footer">
      <a href="https://www.facebook.com/AdaptiEmpresaJr/" class="fa fa-facebook" >  </a>
      <a href="https://www.instagram.com/adaptiempresajr/" class="fa fa-instagram"></a>
      <a href="https://www.linkedin.com/company/adaptiempresajr/" class="fa fa-linkedin"> </a>
  </div>
</footer>
@endsection

