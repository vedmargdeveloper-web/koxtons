@extends(admin_app())

@section('content')
    <div class="form-container">
        <h2>Edit Product MRP</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('product-mrps.update', $productMrp->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" name="model" id="model" class="form-control"
                        value="{{ old('model', $productMrp->model ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" name="item_name" id="item_name" class="form-control"
                        value="{{ old('item_name', $productMrp->item_name ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="qty" class="form-label">Quantity</label>
                    <input type="number" name="qty" id="qty" class="form-control"
                        value="{{ old('qty', $productMrp->qty ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="qty_metric" class="form-label">Quantity Metric</label>
                    <input type="text" name="qty_metric" id="qty_metric" class="form-control"
                        value="{{ old('qty_metric', $productMrp->qty_metric ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" name="size" id="size" class="form-control"
                        value="{{ old('size', $productMrp->size ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control"
                        value="{{ old('code', $productMrp->code ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="mfg_date" class="form-label">Manufacturing Date</label>
                    <input type="date" name="mfg_date" id="mfg_date" class="form-control"
                        value="{{ old('mfg_date', $productMrp->mfg_date ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="mrp" class="form-label">MRP</label>
                    <input type="text" name="mrp" id="mrp" class="form-control"
                        value="{{ old('mrp', $productMrp->mrp ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="barcode" class="form-label">Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="form-control"
                        value="{{ old('barcode', $productMrp->barcode ?? '') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="paper_size" class="form-label">Paper Size</label>
                    <input type="text" name="paper_size" id="paper_size" class="form-control"
                        value="{{ old('paper_size', $productMrp->paper_size ?? '') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('product-mrps.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
