<!-- Modal -->
<div class="modal fade" id="productAddModal" tabindex="-1" role="dialog" aria-labelledby="productAddModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientAddModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                            <div class="card-body">
                                    <div class="form-row">
                                        <input type="hidden" class="form-control" name="stock_id" id="stock_id" value="{{ $stock->id}}">

                                        <div class="form-group col-md-6">
                                            <label for="product_name">Product Name</label>
                                            <input type="text" class="form-control" name="product_name" id="product_name" value="{{ old('product_name',$stock->product_name) }}" readonly>
                                            <span class="invalid-feedback" id="productname_validation" role="alert"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="purchase_price">Purchase Price</label>
                                            <input type="number" class="form-control" name="purchase_price" id="purchase_price" value="{{ old('purchase_price',$stock->purchase_price) }}" readonly>                    
                                            <span class="invalid-feedback" id="purchase_price_validation" role="alert"> </span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="selling_price">Selling Price</label>
                                            <input type="number" class="form-control" name="selling_price" id="selling_price" placeholder="selling price"  value="{{ old('selling_price') }}">
                                          <span class="invalid-feedback" id="selling_price_validation" role="alert"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="discount">Discount</label>
                                            <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount"  value="{{ old('discount') }}">
                                            <span class="invalid-feedback" id="discount_validation" role="alert"> </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" onclick="removeData()">Close</button>
                                        <button type="button" class="btn btn-success" onclick="addProduct()"><i class="fas fa-save"></i> Save</button>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function addProduct() {
    let data = {
        _token: "{{ csrf_token() }}",
        stock_id: $("#stock_id").val(),
        product_name: $("#product_name").val(),
        purchase_price: $("#purchase_price").val(),
        selling_price: $("#selling_price").val(),
        discount: $("#discount").val()
    };
    let productAddurl = "{{route('products.store')}}";
    $.ajax({
        url: productAddurl,
        type: 'POST',
        data: data,
        success: function(res){
            processResponse(res);
        }
    });
}

function processResponse(data){
    if(data.is_success){
        removeData();
    } else {
        let errors = data.data;
        if(errors.selling_price){
            $("#selling_price").addClass("is-invalid");
        }
        if(errors.discount){
            $("#discount").addClass("is-invalid");
        }
        $("#selling_price_validation").html(`<strong>${errors.selling_price}</strong>`);
        $("#discount_validation").html(`<strong>${errors.discount}</strong>`);
    }
}

function removeData(){
    $("#productAddModal").modal('hide');
    $("#selling_price").val("");
    $("#discount").val("");
}
</script>
@endpush
