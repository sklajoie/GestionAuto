@extends('layouts.master')
@section('content')

@php
if($vehicules){
 function diffdateveh($a)
{
  $alasvv = date("Y-m-d", strtotime($a));
          $datejour = date("Y-m-d");
          $date1 = new DateTime($datejour);
          $date2 = new DateTime($alasvv);
          $alavist = $date1->diff($date2);
          $resultat = $alavist->format ('%a'); 
          return $resultat;
        } 
      }
@endphp
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VEHICULES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Vehicule</li>
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
                <h3 class="card-title " >LISTE DES VEHICULES
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>
                  {{-- <a href="{{route('test-mail')}}">test mail</a> --}}
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N*</th>
                    <th>MATRICULE</th>
                    <th>MARQUE</th>
                    <th>MODEL</th>
                    <th>STATUS</th>
                    {{-- <th>DATE ACQUISITION</th> --}}
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                  </thead>
                  <tbody>
                    @if($vehicules)
                    @foreach ($vehicules as $key=>$vehicule )
                        
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$vehicule->Matriculation}}</td>
                        <td>{{$vehicule->Marque}} </td>
                        <td>{{$vehicule->Model}}</td>
                        <td> {{$vehicule->Status}}</td>
                        {{-- <td> {{date('d-m-Y', strtotime($vehicule->DateAcquisition))}}</td> --}}
                        <td>
                            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target=".modifivehicule{{$vehicule->id}}"> <i class="fas fa-edit"></i> Modifier</button>
                        </td>
                        <td>
                            <a href="{{route('Vehicules.show',$vehicule->id)}}" class="btn btn-info btn-xs"><i class="fas fa-list"></i>Détails</a>
                        </td>
                        <td>
                            <a href="{{route('Assurances.show',$vehicule->id)}}" class="btn btn-info btn-app ">
                              @foreach ( $vehicule->assurance as $assurance )
                               @if(diffdateveh($assurance->DateFin) <= 50) <span class="badge bg-danger">Fin dans {{diffdateveh($assurance->DateFin)}} jour(s)</span> 
                               @else <span class="badge bg-success">Fin dans {{diffdateveh($assurance->DateFin)}} jour(s)</span>  
                               @endif
                               @endforeach
                                <i class="fas fa-eye"></i> Assurance </a>
                        </td>
                        <td>
                          <a href="{{route('Visites.show',$vehicule->id)}}" class="btn btn-info btn-app">

                            @foreach ( $vehicule->visite as $visite )
                       
                            @if(diffdateveh($visite->DateFin) <= 30) <span class="badge bg-danger">Fin dans {{diffdateveh($visite->DateFin)}} jour(s)</span> 
                            @else <span class="badge bg-success">Fin dans {{diffdateveh($visite->DateFin)}} jour(s)</span>  
                            @endif

                           @endforeach

                            <i class="fas fa-eye"></i> Visite

                             </a>
                      </td>
                      <td> 
                        <a href="{{route('Vidanges.show',$vehicule->id)}}" class="btn btn-info btn-app">
                      @foreach ( $vehicule->vidanges as $vidange )
                       
                      @if(diffdateveh($vidange->DateFin) <= 30) <span class="badge bg-danger">Fin dans {{diffdateveh($vidange->DateFin)}} jour(s)</span> 
                      @else <span class="badge bg-success">Fin dans {{diffdateveh($vidange->DateFin)}} jour(s)</span>  
                      @endif
                           @endforeach
                           <i class="fas fa-eye"></i> Vidange 
                          </a>
                        </td>
                       
                       
                        <td>
                            <a href="{{route('Versements.show',$vehicule->id)}}" class="btn btn-info btn-xs"> <i class="fas fa-eye">Versement</i> </a>
                        </td>
                    </tr>
                    <div class="modal fade modifivehicule{{$vehicule->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">MODIFIER LE VEHICULE</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            <div class="modal-body">
                            <form  class="form-horizontal style-form" action="{{route('Vehicules.update',$vehicule->id )}}" method="POST">
                                @csrf
                                @method('PUT')
                                  <div class="form-group row col-sm-12">
                                    <div class="col-sm-6">
                                        <label class="control-label" >MATRICULE</label>
                                        <input type="text" required value="{{$vehicule->Matriculation}}" class="form-control" name="matricule">
                                    
                                    
                                    <label class="control-label">MARQUE</label>
                                      <input type="text" required value="{{$vehicule->Marque}}" class="form-control" name="marque">
                                    
                                    <label class="control-label">MODEL</label>
                                      <input type="text" required value="{{$vehicule->Model}}" class="form-control" name="model">
                                    <label class="control-label">NUMERO CHASSIS</label>
                                      <input type="text" value="{{$vehicule->Chassis}}" class="form-control" name="numChassi">
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="control-label">COULEUR</label>
                                      <input type="text" value="{{$vehicule->Couleur}}" class="form-control" name="couleur">
                                  
                                    <label class="control-label">NOMBRE DE PLACE</label>
                                      <input type="number" value="{{$vehicule->NombrePlace}}" class="form-control" name="Nplace">
                                    
                                    <label class="control-label">DATE ACQUISITION</label>
                                      <input type="date" required  value="{{$vehicule->DateAcquisition}}" class="form-control" name="dateacq">
                                      <label class="control-label">STATUS</label>
                                        <select name="status" class="form-control"  required id="">
                                          <option value="{{$vehicule->Status}}">{{$vehicule->Status}}</option>
                                          <option value="NEUF">NEUF</option>
                                          <option value="ANCIEN">ANCIEN</option>
                                          <option value="EN REPARATION">EN REPARATION</option>
                                          <option value="EN PANNE">EN PANNE</option>
                                          <option value="DECLASSE">DECLASSE</option>
                                        </select>
                                    </div>
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
                    @endif
                  </tbody>
                  
                </table>
              </div>
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
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UN VEHICULE A LA FLOTE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        <form  class="form-horizontal style-form" action="{{route('Vehicules.store')}}" method="POST">
            @csrf
         
              <div class="form-group row col-sm-12">
                <div class="col-sm-6">
                  <label class="control-label">TYPE</label>
                  <select name="type" class="form-control"  required id="">
                    <option value="">Choix Type</option>
                    <option value="VOITURE">VOITURE</option>
                    <option value="MOTO">MOTO</option>
                  </select>
                    <label class="control-label" >MATRICULE</label>
                    <input type="text" required value="{{ Request::old('matricule') }}" class="form-control" name="matricule">
                
                
                <label class="control-label">MARQUE</label>
                  <input type="text" required value="{{ Request::old('marque') }}" class="form-control" name="marque">
                
                <label class="control-label">MODEL</label>
                  <input type="text" required value="{{ Request::old('model') }}" class="form-control" name="model">
                <label class="control-label">NUMERO CHASSIS</label>
                  <input type="text" value="{{ Request::old('numChassi') }}" class="form-control" name="numChassi">
                </div>
                <div class="col-sm-6">
                <label class="control-label">COULEUR</label>
                  <input type="text" value="{{ Request::old('couleur') }}" class="form-control" name="couleur">
              
                <label class="control-label">NOMBRE DE PLACE</label>
                  <input type="number" value="{{ Request::old('Nplace') }}" class="form-control" name="Nplace">
                
                <label class="control-label">DATE ACQUISITION</label>
                  <input type="date" required  value="{{ Request::old('dateacq') }}" class="form-control" name="dateacq">
                  <label class="control-label">STATUS</label>
                    <select name="status" class="form-control"  required id="">
                      <option value="">Choix status</option>
                      <option value="NEUF">NEUF</option>
                      <option value="ANCIEN">ANCIEN</option>
                      <option value="EN REPARATION">EN REPARATION</option>
                      <option value="EN PANNE">EN PANNE</option>
                      <option value="DECLASSE">DECLASSE</option>
                    </select>
                </div>
                </div>


               <div class="#" style="text-align: center">
             <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
               </div>
      </form>
      </div>
    </div>
  </div>
  </div>
@endsection