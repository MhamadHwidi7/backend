@extends('layouts.master')
@section('css')
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto"> Drivers List :</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0"> </span>
						</div>
					</div>
					<div class="d-flex my-xl-auto right-content">
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-info btn-icon ml-2"><i class="mdi mdi-filter-variant"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-danger btn-icon ml-2"><i class="mdi mdi-star"></i></button>
						</div>
						<div class="pr-1 mb-3 mb-xl-0">
							<button type="button" class="btn btn-warning  btn-icon ml-2"><i class="mdi mdi-refresh"></i></button>
						</div>
						<div class="mb-3 mb-xl-0">
							<div class="btn-group dropdown">
								<button type="button" class="btn btn-primary">14 Aug 2019</button>
								<button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" id="dropdownMenuDate" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span class="sr-only">Toggle Dropdown</span>
								</button>
								<div class="dropdown-menu dropdown-menu-left" aria-labelledby="dropdownMenuDate" data-x-placement="bottom-end">
									<a class="dropdown-item" href="#">2015</a>
									<a class="dropdown-item" href="#">2016</a>
									<a class="dropdown-item" href="#">2017</a>
									<a class="dropdown-item" href="#">2018</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
@if (session()->has('Add'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('Add') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
  
@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('edit'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('edit') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">

					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">Drivers  </h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-striped mg-b-0 text-md-nowrap">
										<thead>
											<tr>
												<th>ID</th>
                                                <th>Name</th>
												<th>Phone</th>
                                                <th>Address</th>
												<th>Branch</th>
                                                <th>Salary</th>
												<th>Manager</th>
                                                <th>Employment_date</th>
												<th>Opreation</th>

											</tr>
										</thead>
										<tbody>
                                        @php
                                        $count = 1;
                                         @endphp
											 @foreach ($drivers as $driver)
                                                <tr>
                                                  <th scope="row">{{ $count++ }}</th>
                                                  <td>{{ $driver->name }}</td>
                                                  <td>{{ $driver->phone_number }}</td>
                                                  <td>{{ $driver->address }}</td>
                                                  <td>{{ $driver->branch->desk }}</td>
                                                  <td>{{ $driver->salary }}</td>
                                                  <td>{{ $driver->manager_name }}</td>
                                                  <td>{{ $driver->employment_date }}</td>
                                                 
                                                  <td>
                                    
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $driver->id }}" data-name="{{ $driver->name }}"
                                                data-phone_number="{{ $driver->phone_number }}"  data-address="{{ $driver->address }}"
                                                 data-salary="{{ $driver->salary }}"
                                                 data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>
                                       
                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $driver->id }}" data-name="{{ $driver->name }}"
                                                data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                    class="las la-trash"></i></a>
                                      
                                                   </td>
                                                </tr>
                                             @endforeach

										</tbody>
									</table>
                                   
								</div><!-- bd -->
                                
							</div><!-- bd -->
                           
						</div><!-- bd -->
					</div>
					<!--/div-->
     <!-- edit -->
     <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('editdriver') }}" method="post" autocomplete="off">
                       
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="recipient-name" class="col-form-label">name :</label>
                            <input class="form-control" name="name" id="name" type="string">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">phone:</label>
                            <input class="form-control" id="phone_number" name="phone_number" type="integer">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">salary:</label>
                            <input class="form-control" id="salary" name="salary" type="integer">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">Address:</label>
                            <input class="form-control" id="address" name="address" type="string">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                </div>
                </form>
            </div>
        </div>
    </div>

<!-- delete -->
<div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">delete </h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{ route('deletedriver') }}" method="post">
                  
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="name" id="name" type="string" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">cancel</button>
                        <button type="submit" class="btn btn-danger">delete</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
	<!-- Basic modal -->
    <div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title"> Add :</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                    <form action="{{ route('addbranch') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="exampleInputEmail1"> Name</label>
                            <input type="integer" class="form-control" id="name" name="name">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Phone</label>
                            <input type="string" class="form-control" id="phone" name="phone" >
                        </div>
						<div class="form-group">
                            <label for="exampleFormControlTextarea1">National_id</label>
                            <input type="string" class="form-control" id="national_id" name="national_id" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">mother_name</label>
                            <input type="string" class="form-control" id="mother_name" name="mother_name" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">gender</label>
                            <input type="string" class="form-control" id="gender" name="gender" >
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">National_id</label>
                            <input type="string" class="form-control" id="national_id" name="national_id" >
                        </div>

					</div>
					<div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add</button>
                    <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Cancel</button>
					</div>
                    </form>
				</div>

                
			</div>
		</div>
		<!-- End Basic modal -->
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>


<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var phone_number = button.data('phone_number')
        var address = button.data('address')
        var salary = button.data('salary')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #phone_number').val(phone_number);
        modal.find('.modal-body #address').val(address);
        modal.find('.modal-body #salary').val(salary);
    })

</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })

</script>
@endsection
