@extends(admin_app())
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
@section('content')
    <div class="form-container">

       <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Product MRP List</h4>

        <div>
            <!-- Add New link -->
            <a href="{{ route('product-mrps.create') }}" class="btn btn-primary me-2">
                Add New
            </a>

            <!-- Import Excel link triggers modal -->
            <a href="#" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#importModal">
                Import
            </a>
        </div>
    </div>
       
        <br>

      @if (session('success'))
            <div class="alert alert-success" id="success-message">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S./No.</th>
                    <th>Model</th>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Qty Metric</th>
                    <th>Size</th>
                    <th>Code</th>
                    <th>MFG Date</th>
                    <th>MRP</th>
                    <th>Barcode</th>
                    <th>Paper Size</th>
                    <th>Create Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productMrps as $mrp)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $mrp->model }}</td>
                        <td>{{ $mrp->item_name }}</td>
                        <td>{{ $mrp->qty }}</td>
                        <td>{{ $mrp->qty_metric }}</td>
                        <td>{{ $mrp->size }}</td>
                        <td>{{ $mrp->code }}</td>
                        <td>{{ $mrp->mfg_date }}</td>
                        <td>{{ $mrp->mrp }}</td>
                        <td>{{ $mrp->barcode }}</td>
                        <td>{{ $mrp->paper_size }}</td>
                        <td>{{ $mrp->created_at->format('d, M Y H:i') }}</td>

                        <td>
                            <a href="{{ route('product-mrps.edit', $mrp->id) }}" class="">Edit</a>
                             <a href="{{ route('receipt.print', $mrp->id) }}" target="_blank" class="primary" style="color: rgb(15, 15, 93)">
                            Print 
                            </a>
                            <a href="{{ route('product-mrps.destroy', $mrp->id) }}"
                                onclick="event.preventDefault(); 
                                            if(confirm('Delete this record?')) {
                                                document.getElementById('delete-form-{{ $mrp->id }}').submit();
                                            }" 
                                class="text-danger" style="margin-left: 10px;" >
                                Delete
                                </a>

                                <form id="delete-form-{{ $mrp->id }}" action="{{ route('product-mrps.destroy', $mrp->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center">No records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
       {{ $productMrps->links() }}
    
    </div>

    <!-- Import Excel Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('product-mrps.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="importModalLabel">Import Product MRP</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="file" class="form-label">Excel File</label>
            <input type="file" name="file" id="file" class="form-control" required>
          </div>
        <a href="{{ route('download.sample') }}" class="btn btn-success">
                Download Sample File
            </a>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Import</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>
 <script>
        setTimeout(() => {
            let msg = document.getElementById('success-message');
            if (msg) {
                msg.style.transition = "opacity 0.5s ease"; 
                msg.style.opacity = "0";
                setTimeout(() => msg.remove(), 500); 
            }
        }, 2000); // 2 seconds
    </script>

@endsection
