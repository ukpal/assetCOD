@extends('Administrator.master')
<title>{{ $title }}</title>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Companies</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Companies</li>
                        {{-- <li class="breadcrumb-item active">Company = {{App\Models\Company::count();}}</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </section>
    

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h3 class="card-title"></h3> -->
                            <div class="row mx-0 justify-content-between ">
                                <div class="col-md-3 d-flex align-items-stretch">
                                    <a href="{{route('companies.new')}}" class="btn btn-primary p-2">&nbsp;&nbsp;<i class="fas fa-plus"></i> Register New Company</a>
                                    {{Session::get('companyStatus')}}
                                </div>
                                <div class="col-md-5 d-flex align-items-stretch ">
                                    @include('Administrator.notification')
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px">SL No.</th>
                                        <th style="width: 25%">Company Title</th>
                                        <th>Company Email</th>
                                        <th style="width: 80px"> Status</th>
                                        <th style="width: 80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $count =1; @endphp
                                    @foreach($companies as $company)
                                    <tr>
                                        <td>{{ $count++ }}</td>
                                        <td>{{$company->name}}</td>
                                        <td>{{$company->email}}</td>
                                        <td>
                                        <input data-id="{{$company->id}}" class="ttoggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $company->status ? 'checked' : '' }}>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#companyId{{$company->id}}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                        </td>

                                        <!-- <td>
                                            <a href="#" class="btn btn-info"><i class="fas fa-edit"></i></a>
                                        </td> -->
                                    </tr>
                                     <!-- Modal -->
                                     <div class="modal fade" id="companyId{{$company->id}}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Company Details</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-12">
                                                        <div class="card mb-3">
                                                          <div class="card-body">
                                                            {{-- <h3 class="card-title mb-4">Summary</h3> --}}
                                                            <div>
                                                              <!--<div class="d-flex justify-content-between" style="margin-top: 15;">-->
                                                              <!--  <b class="text-900 fw-semi-bold">Fax :</b>-->
                                                              <!--  <p class="text-info fw-semi-bold">{{$company->fax}}</p>-->
                                                              <!--</div>-->
                                                              <div class="d-flex justify-content-between">
                                                                <b class="text-900 fw-semi-bold">Subscription Name :</b>
                                                                <p class="text-info fw-semi-bold">{{$company->title}}</p>
                                                              </div>
                                                              <div class="d-flex justify-content-between">
                                                                <b class="text-900 fw-semi-bold">Subscription Description :</b>
                                                                <p class="text-info fw-semi-bold">{{$company->description}}</p>
                                                              </div>
                                                              <div class="d-flex justify-content-between">
                                                                <b class="text-900 fw-semi-bold">Subscription Started :</b>
                                                                <p class="text-info fw-semi-bold">{{$company->start_date}}</p>
                                                              </div>
                                                              <div class="d-flex justify-content-between">
                                                                <b class="text-900 fw-semi-bold">Subscription Expired :</b>
                                                                <p class="text-info fw-semi-bold">{{$company->end_date}}</p>
                                                              </div>
                                                              
                                                              {{-- <div class="d-flex justify-content-between">
                                                                <p class="text-900 fw-semi-bold">Tax :</p>
                                                                <p class="text-1100 fw-semi-bold">$126.20</p>
                                                              </div>
                                                              <div class="d-flex justify-content-between">
                                                                <p class="text-900 fw-semi-bold">Subtotal :</p>
                                                                <p class="text-1100 fw-semi-bold">$665</p>
                                                              </div>
                                                              <div class="d-flex justify-content-between">
                                                                <p class="text-900 fw-semi-bold">Shipping Cost :</p>
                                                                <p class="text-1100 fw-semi-bold">$30</p>
                                                              </div> --}}
                                                            </div>
                                                            {{-- <div class="d-flex justify-content-between border-top border-dashed pt-4">
                                                              <h4 class="mb-0">Total :</h4>
                                                              <h4 class="mb-0">$695.20</h4>
                                                            </div> --}}
                                                          </div>
                                                        </div>
                                                      </div>
                                                    {{-- <strong>Company Name :</strong>
                                                   <p>{{$company->name}}</p> --}}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                   
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('ajaxStatusCompany')
<script>
    $(function() {
        $('.ttoggle-class').change(function() {
            const path = "{{route('companies.update.status')}}";
            var status = $(this).prop('checked') == true ? 1 : 0;
            var company_id = $(this).data('id');
            // console.log(status);
            // console.log(company_id);
            // console.log(path);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: path,
                data: {
                    'status': status,
                    'company_id': company_id
                },
                success: function(data) {
                      console.log(data.success)
                    //   console.log(data)
                    // swal(data.success);
                    swal({
                        title: "Status Updated",
                        icon: "success",
                    });

                },
                error: function(data) {
                    swal(data.error);
                }
            });
        })
    })
</script>
@endsection
