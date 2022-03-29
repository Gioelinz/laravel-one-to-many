<div class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($post->exists)
        <h1>Modifica Post</h1>
        <form action="{{ route('admin.posts.update', $post) }}" method="post">
            @method('PUT')
        @else
            <h1>Aggiungi un Post</h1>
            <form action="{{ route('admin.posts.store') }}" method="post">
    @endif

    @csrf
    <div class="row gy-5">
        <div class="col-8">
            <input type="text" class="form-control @error('title') is-invalid @enderror" placeholder="Titolo"
                name="title" id="title" value="{{ old('title', $post->title) }}">
            @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-4">
            <select class="custom-select @error('category_id') is-invalid @enderror" name="category_id">
                <option value="">Nessuna Categoria</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @if (old('category_id', $post->category_id) == $category->id) selected @endif>
                        {{ $category->label }}</option>
                @endforeach
            </select>
            @error('category_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-12 my-5">
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="5"
                placeholder="Inserisci testo..">{{ old('description', $post->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-12">
            <input type="text" class="form-control @error('image') is-invalid @enderror" placeholder="Url Immagine"
                name="image" id="image" value="{{ old('image', $post->image) }}">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="controls d-flex justify-content-end mt-2">
        <a href="{{ route('admin.posts.index') }}" class="btn btn-primary mr-2">Indietro</a>
        <button type="submit" class="btn btn-success">Conferma</button>
    </div>
    </form>
</div>
