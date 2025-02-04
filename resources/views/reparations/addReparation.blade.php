@extends('layouts.master')
@section('content')


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DETAILS VEHICULE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Détails Vehicule</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
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

        <div class="row">
          <div class="col-md-6">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <h2 style="text-align: center">DETAILS PANNES</h2>
              <div class="card-body box-profile">
             
                <form  class="form-horizontal style-form" action="{{route('Reparations.update',$panne->id )}}" method="POST">
                    @csrf
                    @method('PUT')
                      <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                            <label class="control-label" >TYPE PANNE</label>
                            <input type="text" required value="{{$panne->typePanne}}" class="form-control" name="typePanne">
                            <input type="hidden" name="panne" value="PANNE">
                        
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
                              <option {{$panne->vehicule_id === $vehicule->id ? 'selected': ""}} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                                
                              @endforeach
                            </select>
                          <label class="control-label">CONDUCTEUR</label>
                            <select name="conducteur" class="form-control"  required id="">
                                @foreach ( $conducteurs as $conducteur )
                                <option {{$panne->conducteur_id === $conducteur->id ? 'selected': "" }} value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                                  
                                @endforeach
                            </select>
                        </div>
                        <label class="control-label">DETAILS PANNE</label>
                          <textarea class=" form-control summernote" name="detailpane" readonly id="#"> {!! $panne->DetailsPanne !!}</textarea>

        
                      </div>
        
                       <div class="#" style="text-align: center">
                     <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
                       </div>
              </form>

               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          
          </div>
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card card-primary card-outline">
                <h2 style="text-align: center">DETAILS REPARATIONS</h2>
                <div class="card-body box-profile">
            <form  class="form-horizontal style-form" action="{{route('Reparations.update', $panne->id)}}" method="POST">
                @csrf
                @method('PUT')
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                        <label class="control-label" >TYPE REPARATION</label>
                        <input type="text" required value="{{$panne->typeReparation}}" class="form-control" name="typeRepar">
                        <input type="hidden" name="panne" value="REPARE">
                    
                    <label class="control-label">COÛT DE LA REPARATION </label>
                      <input type="number"  value="{{$panne->CoutReparation}}" class="form-control" name="coutRepar">
                    
                      
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">DATE DE LA REPARATION</label>
                          <input type="date" required value="{{$panne->DateReparation}}" class="form-control" name="dateRepar">
                        
                      <label class="control-label">STATUS</label>
                      <select name="status" class="form-control"  required id="">
                       <option value="{{$panne->Status}}">{{$panne->Status}}</option>
                        <option value="EN COURS">EN COURS</option>
                        <option value="EN ATTENTE">EN ATTENTE</option>
                        <option value="REPARE">REPARE</option>
                        <option value="HORS SERVICE">HORS SERVICE</option>
                      </select>
                    
                    </div>
                  
                </div>
                    <label class="control-label">DETAILS REPARATION</label>
                    <textarea class=" form-control summernote" name="detailrepar" id="summernote">{{$panne->DetailsReparation}}</textarea>
    
    
    
                   <div class="#" style="text-align: center">
                 <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
                   </div>
          </form>
            <!-- /.card -->
          </div>
          </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->




    </section>
    <!-- /.content -->
  </div>

@endsection