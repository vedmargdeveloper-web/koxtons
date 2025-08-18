@extends(admin_app())

@section('content')
    <div class="form-container">
        <h4>Create Product MRP</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('product-mrps.store') }}" method="POST">
            @csrf
            <div class="row">

                <div class="form-group col-md-4">
                    <label for="model" class="form-label">Model</label>
                    <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="item_name" class="form-label">Item Name</label>
                    <input type="text" name="item_name" id="item_name" class="form-control"
                        value="{{ old('item_name') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="qty" class="form-label">Quantity</label>
                    <input type="number" name="qty" id="qty" class="form-control" value="{{ old('qty') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="qty_metric" class="form-label">Quantity Metric</label>
                    <input type="text" name="qty_metric" id="qty_metric" class="form-control"
                        value="{{ old('qty_metric') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="size" class="form-label">Size</label>
                    <input type="text" name="size" id="size" class="form-control" value="{{ old('size') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="code" class="form-label">Code</label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="mfg_date" class="form-label">Manufacturing Date</label>
                    <input type="date" name="mfg_date" id="mfg_date" class="form-control" value="{{ old('mfg_date') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="mrp" class="form-label">MRP</label>
                    <input type="text" name="mrp" id="mrp" class="form-control" value="{{ old('mrp') }}">
                </div>

                <div class="form-group col-md-4">
                    <label for="barcode" class="form-label">Barcode</label>
                    <input type="text" name="barcode" id="barcode" class="form-control" value="{{ old('barcode') }}">
                </div>


                <div class="form-group col-md-4">
                    <label for="paper_size" class="form-label">Paper Size</label>
                    <input type="text" name="paper_size" id="paper_size" class="form-control"
                        value="{{ old('paper_size') }}">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
