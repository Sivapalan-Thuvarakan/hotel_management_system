<!-- Modal -->
<div class="modal fade" id="customerAddModal" tabindex="-1" role="dialog" aria-labelledby="customerAddModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="patientAddModalLabel">Add Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                            <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="fname">First Name</label>
                                          <input type="type" class="form-control " name="fname"  id="fname" placeholder="First Name"  value="{{ old('fname') }}">
                                          <span class="invalid-feedback" id="fname_validation" role="alert"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lname">Last Name</label>
                                            <input type="type" class="form-control " name="lname" id="lname" placeholder="Last Name"  value="{{ old('lname') }}">
                                            <span class="invalid-feedback" id="lname_validation" role="alert"> </span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="phone_no">Phone No</label>
                                          <input type="type" class="form-control " name="phone_no" id="phone_no" placeholder="Phone No"  value="{{ old('phone_no') }}">
                                          <span class="invalid-feedback" id="phone_no_validation" role="alert"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="national_id">NIC</label>
                                            <input type="type" class="form-control " name="national_id" id="national_id" placeholder="National ID"  value="{{ old('national_id') }}">
                                            <span class="invalid-feedback" id="national_id_validation" role="alert"> </span>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                          <label for="email">Email</label>
                                          <input type="email" class="form-control " name="email" id="email" placeholder="Email"  value="{{ old('email') }}">
                                          <span class="invalid-feedback" id="email_validation" role="alert"> </span>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="address">Address</label>
                                            <textarea class="form-control " name="address" id="address" placeholder="Address"  value="{{ old('address') }}"></textarea>
                                            <span class="invalid-feedback" id="address_validation" role="alert"> </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal" onclick="removeData()">Close</button>
                                        <button type="button" class="btn btn-success" onclick="addCustomer()"><i class="fas fa-save"></i> Save</button>
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
function addCustomer() {
    let data = {
        _token: "{{ csrf_token() }}",
        phone_no: $("#phone_no").val(),
        national_id: $("#national_id").val(),
        fname: $("#fname").val(),
        lname: $("#lname").val(),
        address: $("#address").val(),
        email: $("#email").val(),
    }
    let customerAddurl = "{{ route('customers.add') }}";
    $.ajax({
        url: customerAddurl,
        type: 'POST',
        data: data,
        success: function(res) {
            customerAddResponse(res)
        }
    });
}

function customerAddResponse(data) {
    if(data.is_success == true){
        if (data.data) {
            var dataForSelect2 = {
                id:data.data.id,
                text: data.data.first_name.concat(" ",data.data.last_name," | ",data.data.code," | ",data.data.national_id),
            }
            var newOption = new Option(dataForSelect2.text, dataForSelect2.id, false, true);
            $('.customer-search').append(newOption).trigger('change');
        }
    }

    if(data.is_success){
        removeData()
    } else {
        let errors = data.data;
        if(errors.phone_no){
            $("#phone_no").addClass("is-invalid");
        }
        if(errors.national_id){
            $("#national_id").addClass("is-invalid");
        }
        if(errors.email){
            $("#email").addClass("is-invalid");
        }
        if(errors.fname){
            $("#fname").addClass("is-invalid");
        }
        if(errors.lname){
            $("#lname").addClass("is-invalid");
        }
        if(errors.address){
            $("#address").addClass("is-invalid");
        }
        $("#phone_no_validation").html(`<strong>${errors.phone_no}</strong>`);
        $("#national_id_validation").html(`<strong>${errors.national_id}</strong>`);
        $("#fname_validation").html(`<strong>${errors.fname}</strong>`);
        $("#lname_validation").html(`<strong>${errors.lname}</strong>`);
        $("#address_validation").html(`<strong>${errors.address}</strong>`);
        $("#email_validation").html(`<strong>${errors.email}</strong>`);
    }
}

function removeData(){
    $("#customerAddModal").modal('hide');
    $("#phone_no").val("");
    $("#national_id").val("");
    $("#fname").val("");
    $("#lname").val("");
    $("#address").val("");
    $("#email").val("");
}
</script>
@endpush
