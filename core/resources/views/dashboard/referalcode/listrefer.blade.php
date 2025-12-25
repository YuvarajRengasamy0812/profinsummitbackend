@extends('dashboard.layouts.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="main-content app-content">
    <div class="container-fluid">

        <div class="page-header">
            <h1 class="page-title">Coupon Code</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#couponModal">
                Add New
            </button>
        </div>

        @php $serial = 1; @endphp

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">Coupon List</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Coupon Name</th>
                                        <th>Percentage</th>
                                     
                                        <th>Coupon Code</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($coupons as $coupon)
                                    <tr>
                                        <td>{{ $serial++ }}</td>
                                        <td>{{ $coupon->coupon_name }}</td>
                                        <td>{{ $coupon->percentage }}%</td>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ $coupon->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $coupon->updated_at->format('Y-m-d') }}</td>

                                        <td>
                                            <button class="btn btn-sm btn-primary edit-btn"
                                                data-id="{{ $coupon->coupon_id }}">
                                                <i class="fe fe-edit"></i>
                                            </button>
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $coupon->coupon_id }}">
                                                <i class="fe fe-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- SweetAlert for Session Messages (Create) --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

{{-- ---------------- CREATE COUPON MODAL ---------------- --}}
<div class="modal fade" id="couponModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ url('/admin/add_coupon') }}" method="POST">
                @csrf

                <div class="modal-header">
                    <h5>Create Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="mb-3">
                        <label>Coupon Name</label>
                        <input type="text" class="form-control" name="coupon_name" required>
                    </div>

                    <div class="mb-3">
                        <label>Percentage (%)</label>
                        <input type="number" class="form-control" name="percentage" min="1" max="100" required>
                    </div>

                    <div class="mb-3">
                        <label>Coupon Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="coupon_code" id="coupon_code_input" required>
                            <button type="button" class="btn btn-secondary" id="generate_code_btn">Generate</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Create</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- SweetAlert for Session Messages (Create) --}}
@if(session('completed'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('completed') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
</script>
@endif

{{-- ---------------- EDIT COUPON MODAL ---------------- --}}
<div class="modal fade" id="editCouponModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="editCouponForm">
                @csrf

                <div class="modal-header">
                    <h5>Edit Coupon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_coupon_id" name="coupon_id">

                    <div class="mb-3">
                        <label>Coupon Name</label>
                        <input type="text" class="form-control" id="edit_coupon_name" name="coupon_name" required>
                    </div>

                    <div class="mb-3">
                        <label>Percentage (%)</label>
                        <input type="number" class="form-control" id="edit_percentage" name="percentage" required>
                    </div>

                    <div class="mb-3">
                        <label>Coupon Code</label>
                        <input type="text" class="form-control" id="edit_coupon_code" name="coupon_code" required>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Update</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- Include jQuery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {

    // Generate random coupon code
    $('#generate_code_btn').click(function() {
        let code = '';
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let length = 8;
        for (let i = 0; i < length; i++) {
            code += characters.charAt(Math.floor(Math.random() * characters.length));
        }
        $('#coupon_code_input').val(code);
    });

    // ---------- EDIT BUTTON ----------
    $('.edit-btn').click(function() {
        let id = $(this).data('id');
        $.get('/admin/get_coupon/' + id, function(res) {
            $('#edit_coupon_id').val(res.coupon_id);
            $('#edit_coupon_name').val(res.coupon_name);
            $('#edit_percentage').val(res.percentage);
            $('#edit_coupon_code').val(res.coupon_code);
            $('#edit_status').val(res.status);
            $('#editCouponModal').modal('show');
        });
    });

    // ---------- UPDATE COUPON ----------
    $('#editCouponForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_coupon_id').val();
        $.post('/admin/update_coupon/' + id, $(this).serialize(), function(res) {
            Swal.fire({
                icon: 'success',
                title: 'Updated!',
                text: 'Coupon updated successfully!',
                confirmButtonText: 'OK'
            }).then(() => location.reload());
        }).fail(function() {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update coupon.',
                confirmButtonText: 'OK'
            });
        });
    });

    // ---------- DELETE COUPON ----------
    $('.delete-btn').click(function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if(result.isConfirmed){
                $.get('/admin/delete_coupon/' + id, function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Coupon deleted successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => location.reload());
                }).fail(function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Failed to delete coupon.',
                        confirmButtonText: 'OK'
                    });
                });
            }
        });
    });


});
</script>
@endsection
