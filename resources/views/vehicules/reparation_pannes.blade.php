@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>GARAGES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">GARAGES</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            @if ($message = Session::get('success'))
                        <div class="alert alert-success  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
            @if ($message = Session::get('danger'))
                        <div class="alert alert-danger  alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">×</button>  
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header" style="text-align:center; !important">
                <h3 class="card-title " >LISTE DES PANNES & REPARATIONS
                  <button type="button" class="btn btn-primary float-right mb-2"  data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class=" table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N*</th>
                    <th>TYPE PANNE</th>
                    <th>COÛT PANNE</th>
                    <th>DATE PANNE</th>
                    <th>TYPE REPARATION</th>
                    <th>COÛT REPARATION</th>
                    <th>DATE REPARATION</th>
                    {{-- <th>DETAIL</th> --}}
                    <th>STATUS</th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                    @php $ttpanne=0; $ttrepar=0; @endphp
                    @foreach ($pannes as $key=>$panne )
                        @php $ttpanne += $panne->CoutPanne; $ttrepar += $panne->CoutReparation @endphp
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$panne->typePanne}}</td>
                        <td>{{$panne->CoutPanne}}</td>
                        <td> {{date('d-m-Y', strtotime($panne->DatePanne))}}</td>
                        <td>{{$panne->typeReparation}}</td>
                        <td>{{$panne->CoutReparation}}</td>
                        <td> {{date('d-m-Y', strtotime($panne->DateReparation))}}</td>
                        {{-- <td> {!!$panne->DetailsPanne !!}</td> --}}
                        <td> {{$panne->Status}}</td>
                        <td>
                            <a href="{{route('Reparations.show',$panne->id)}}" type="button" class="btn btn-success" > <i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                      <td>TOTAL</td>
                      <td></td>
                      <td>{{$ttpanne}}</td>
                      <td></td>
                      <td></td>
                      <td>{{$ttrepar}}</td>
                      <td></td>
                      <td></td>
                      <td></td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
  
  <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UNE PANNE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        <form  class="form-horizontal style-form" action="{{route('Reparations.store')}}" method="POST">
            @csrf
         
              <div class="form-group row col-sm-12">
                <div class="col-sm-6">
                    <label class="control-label" >TYPE PANNE</label>
                    <input type="text" required value="{{ Request::old('typePanne') }}" class="form-control" name="typePanne">
                
                
                <label class="control-label">COÛT DE LA PANNE </label>
                  <input type="number"  value="{{ Request::old('coutPanne') }}" class="form-control" name="coutPanne">
                
                <label class="control-label">DATE DE LA PANNE</label>
                  <input type="date" required value="{{ Request::old('datePanne') }}" class="form-control" name="datePanne">
                
     
                </div>
                <div class="col-sm-6">
                  <label class="control-label">STATUS</label>
                  <select name="status" class="form-control"  required id="">
                   
                    <option value="EN COURS">EN COURS</option>
                    <option value="EN ATTENTE">EN ATTENTE</option>
                    <option value="REPARE">REPARE</option>
                    <option value="HORS SERVICE">HORS SERVICE</option>
                  </select>
                  <input type="hidden" class="form-control"  placeholder="" value="{{$idvehicule}}" name="vehicule" >
                     
                <label class="control-label">CONDUCTEUR</label>
                  <select name="conducteur" class="form-control"  required id="">
                    @foreach ( $conducteurs as $conducteur )
                    @if($chauferVehicules !=null)
                    <option {{$chauferVehicules->conducteur_id === $conducteur->id ? "selected" : ""}} value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                    @else
                    <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                      @endif
                    @endforeach
                  </select>
                </div>
                </div>
                <label class="control-label">DETAILS PANNE</label>
                <textarea class=" form-control summernote" name="detailpane" id="summernote">{{ Request::old('detailpane') }}</textarea>


              </div>

               <div class="#" style="text-align: center">
             <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
              <div>
              <div>
      </form>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@endsection