@extends('user/layout')
@section('page_title','User | Mangage')
@section('container')
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        {{-- <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DataTables</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">DataTables</li>
            </ol>
          </div>
        </div> --}}
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
          <div class="row">
          <div class="col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><b>MANAGE PERSONAL INFORMATION0</b></h3>
              </div>
              <!-- /.card-header -->
              <form action="{{ route('user.manage_personal_info_process') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="form-group">
                          <label for="phone">Mobile number*</label>
                          <input type="text" name="phone" class="form-control" id="phone"  placeholder="Mobile number" />
                          @error('phone')
                          <span class="text-danger" role="alert">
                              {{ $message }}
                          </span>
                      @enderror
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="form-group">
                          <label for="phone">Profile image*</label>

                          <input type="file" name="profile_image" class="form-control" 
                          accept=".jpg,.jpeg,.pdf,.doc,.docx"
                           >
                          @error('profile_image')
                          <span class="text-success" role="alert">
                              {{ $message }}
                          </span>
                      @enderror
                      </span>
                  </span>
                        </div>
                    </div>
                    <div class="col-xl-6">
                      <div class="form-group">
                      <label for="p_address">State*</label>
                      <select class="form-control"  id="state" onchange="city_filter_handler()">
                        <option value="">select state</option>

                        @foreach ($states as $list)
                        <option value="{{$list->id}}">{{$list->state}}</option>
                        @endforeach 
                      </select>
                      {{-- <input type="text" name="city" class="form-control" id="city" placeholder="City"> --}}
                      @error('city')
                      <span class="text-danger" role="alert">
                          {{ $message }}
                      </span>
                  @enderror
                      </div>
                  </div>
                  <div class="col-xl-6">
                    <div class="form-group">
                    <label for="p_address" >City*</label>
                    <select class="form-control" id="city_list">
                      <option value="">select city</option>
                    </select>
                    {{-- <input type="text" name="city" class="form-control" id="city" placeholder="City"> --}}
                    @error('city')
                    <span class="text-danger" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                    </div>
                </div>
                
                     
                   
                </div>
                   
                    <div class="col-xl-4">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" >SAVE</button>
                       
                        </div>
                        <input type="hidden" name="id" value="{{session('USER_ID')}}" />

              </div>
            </form>
              <!-- /.card-body -->
            </div>
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
