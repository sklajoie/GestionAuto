@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PANNES | REPARATION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Pannes | Réparations</li>
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
                <h3 class="card-title " >LISTE DES PANNES
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N*</th>
                    <th>TYPE</th>
                    <th>COÛT</th>
                    {{-- <th>DETAIL</th> --}}
                    <th>STATUS</th>
                    <th>DATE PANNE</th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($pannes as $key=>$panne )
                        
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$panne->typePanne}}</td>
                        <td>{{$panne->CoutPanne}}</td>
                        {{-- <td> {!!$panne->DetailsPanne !!}</td> --}}
                        <td> {{$panne->Status}}</td>
                        <td> {{date('d-m-Y', strtotime($panne->DatePanne))}}</td>
                        <td>
                          <div  style="display:flex; flex-direction:row; ">
                          <a href="{{route('Reparations.show',$panne->id)}}" class="btn btn-success btn-xs m-1"> <i class="fa fa-list"></i> </a>
                            <button type="button" class="btn btn-warning btn-xs m-1" data-toggle="modal" data-target=".modifipanne{{$panne->id}}"> <i class="fas fa-edit"></i></button>
                        
                            <a href="javascript:;" class="btn btn-xs btn-danger sa-delete m-1" data-form-id="category-delete-{{$panne->id}}">
                              <i class="fa fa-trash"></i>
                          </a> 
      
                          <form id="category-delete-{{$panne->id}}" action="{{route('Reparations.destroy', $panne->id)}}" method="POST"> 
                          @csrf 
                          @method('DELETE') 
      
                          </form>
                          </div>
                          </td>
                    </tr>
                    <div class="modal fade modifipanne{{$panne->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">MODIFIER LA PANNE</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            <div class="modal-body">
                            <form  class="form-horizontal style-form" action="{{route('Reparations.update',$panne->id )}}" method="POST">
                                @csrf
                                @method('PUT')
                                  <div class="form-group row col-sm-12">
                                    <div class="col-sm-6">
                                        <label class="control-label" >TYPE PANNE</label>
                                        <input type="text" required value="{{$panne->typePanne}}" class="form-control" name="typePanne">
                                    
                                    
                                    <label class="control-label">COÛT DE LA PANNE</label>
                                      <input type="number" required value="{{$panne->CoutPanne}}" class="form-control" name="coutPanne">
                                    
                                    <label class="control-label">DATE PANNE</label>
                                      <input type="date" required value="{{$panne->DatePanne}}" class="form-control" name="datePanne">
                                    </div>
                                    <div class="col-sm-6">
                                      <label class="control-label">STATUS</label>
                                        <select name="status" class="form-control"  required id="">
                                          <option value="{{$panne->Status}}">{{$panne->Status}}</option>
                                          <option value="EN COURS">EN COURS</option>
                                          <option value="EN ATTENTE">EN ATTENTE</option>
                                          <option value="REPARE">REPARE</option>
                                          <option value="HORS SERVICE">HORS SERVICE</option>
                                        </select>
                                      <label class="control-label">VEHICULE</label>
                                        <select name="vehicule" class="form-control"  required id="">
                                          @foreach ( $vehicules as $vehicule )
                                          <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                                            
                                          @endforeach
                                        </select>
                                      <label class="control-label">CONDUCTEUR</label>
                                        <select name="conducteur" class="form-control"  required id="">
                                          @foreach ( $conducteurs as $conducteur )
                                          <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                                            
                                          @endforeach
                                        </select>
                                    </div>
                                    <label class="control-label">DETAILS PANNE</label>
                                      <textarea class=" form-control summernote" name="detailpane" readonly id="#"> {!! $panne->DetailsPanne !!}</textarea>

                    
                                  </div>
                    
                                   <div class="#" style="text-align: center">
                                 <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
                                  <div>
                          </form>
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
                <label class="control-label">VEHICULE</label>
                  <select name="vehicule" class="form-control"  required id="">
                    <option value="">CHOIX DU VEHICULE</option>
                    @foreach ( $vehicules as $vehicule )
                    <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                      
                    @endforeach
                  </select>
                <label class="control-label">CONDUCTEUR</label>
                  <select name="conducteur" class="form-control"  required id="">
                    <option value="">CHOIX DU CONDUCTEUR</option>
                    @foreach ( $conducteurs as $conducteur )
                    <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                      
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