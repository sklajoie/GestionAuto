@extends('layouts.master')
@section('content')

@php
 function diffdate($a)
{
  $alasvv = date("Y-m-d", strtotime($a));
          $datejour = date("Y-m-d");
          $date1 = new DateTime($datejour);
          $date2 = new DateTime($alasvv);
          $alavist = $date1->diff($date2);
          $resultat = $alavist->format ('%a'); 

  return $resultat;
} 
@endphp

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>DETAILS LOCATION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Détails Location</li>
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
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
             {{-- <a href="{{route('rapports')}}">rapport</a> --}}
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>MATRICULATION</b> <a class="float-right">{{$locations->vehicule->Matriculation}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>MARQUE</b> <a class="float-right">{{$locations->vehicule->Marque}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>MODEL</b> <a class="float-right">{{$locations->vehicule->Model}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>CHASSIS</b> <a class="float-right">{{$locations->vehicule->Chassis}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>COULEUR</b> <a class="float-right">{{$locations->vehicule->Couleur}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>NOMBRE DE PLACE</b> <a class="float-right">{{$locations->vehicule->NombrePlace}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>DATE ACQUISITION</b> <a class="float-right">{{date('d-m-Y', strtotime($locations->vehicule->DateAcquisition))}}</a>
                  </li>
                </ul>

               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

          
          </div>
          <!-- /.col -->
          <div class="col-md-8">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">LOCATION</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">CONDUCTEURS</a></li>
                  <li class="nav-item"><a class="nav-link" href="#histryversmt" data-toggle="tab">VERSEMENTS</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                    <form  class="form-horizontal style-form" action="{{route('Locations.update',$locations->id)}}" enctype="multipart/form-data" method="POST">
                      @csrf
                    @method('PUT')
                        <div class="form-group row col-sm-12">
                          <div class="col-sm-6">
                            <label class="control-label">VEHICULE</label>
                            <select name="vehicule" class="form-control"  required id="">
                              @foreach ( $voitures as $vehicule )
                              <option {{$locations->vehicule_id === $vehicule->id ? 'selected' : ""}} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                                
                              @endforeach
                            </select>
                          <label class="control-label">NOM CLIENT</label>
                            <input type="text" value="{{$locations->Client}}" class="form-control" name="nomclient">
                         
                          <label class="control-label">CONTACT CLIENT</label>
                            <input type="text" value="{{$locations->Contact}}" class="form-control" name="telclient">
                          
                          <label class="control-label">ADDRESSE CLIENT</label>
                            <input type="text" value="{{$locations->Address}}" class="form-control" name="addressclient">
                       
                          <label class="control-label">PIECE JUSTIFICATIF (CNI/PERMIS...)</label>
                            <input type="file"  class="form-control" name="piece">
                          </div>
                          <div class="col-sm-6">
                          <label class="control-label">DATE DEBUT</label>
                            <input type="date" value="{{$locations->DateDebut}}" class="form-control" name="datedebut">
                         
                          <label class="control-label">DATE FIN</label>
                            <input type="date" value="{{$locations->DateFin}}" class="form-control" name="datefin">
                         
                          <label class="control-label">PRIX LOCATION</label>
                            <input type="number" value="{{$locations->Montant}}" class="form-control" name="prix">
                          
                          <label class="control-label">KILOMETRAGE DEBUT</label>
                            <input type="number" value="{{$locations->KmDebut}}" class="form-control" name="kmdebut">
                          
                          <label class="control-label">KILOMETRAGE FIN</label>
                            <input type="number" value="{{$locations->KmFin}}" class="form-control" name="kmfin">
                          
                          </div>
                          <label class="control-label">DETAILS</label>
                           <textarea name="details" id="" class="form-control">{{$locations->Details}}</textarea>
                          </div>
                         <div class="" style="text-align: center;">
                            <br>
                       <button type="submit" class=" btn btn-warning">MODIFIER</button>
                      
                         </div>
                </form>

                </div>
                  

                  
                  

                  <div class="tab-pane" id="settings">
                    <div class="table-responsive">
                      <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".asigneVehicule">ASSIGNATION <i class="fas fa-plus"></i></button>
  
                      <table id="example2" class="example2 table table-bordered table-striped">
                          <thead>
                          <tr>
                            <th>DATE </th>
                            <th>NOM & PRENOM(S)</th>
                            <th>CONTACT</th>
                            <th>ADDRESS</th>
                          </tr>
                          </thead>
                          <tbody>
                            @foreach ($chauffeurs as $key=>$chauffeur )

                          <td> {{date('d-m-Y', strtotime($chauffeur->Date))}}</td>
                          <td>{{$chauffeur->conducteur->NomPrenom}}</td>
                          <td>{{$chauffeur->conducteur->Contact}} </td>
                          <td> {{$chauffeur->conducteur->Address}}</td>
                        </tr>
                        @endforeach
                           
                          </tbody>
                      </table>
                    </div>
                  </div>
                  
                  <div class="tab-pane" id="histryversmt">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target=".versementLocat">VERSEMENT <i class="fas fa-plus"></i></button>
  
                    <div class=" table-responsive">
                      <table id="example1" class=" table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th></th>
                          <th>Date</th>
                          <th>Montant</th>
                          <th>Moyen</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($versements as $key=>$versement )
                        <tr>
                          <td>{{++$key}}</td>
                          <td>{{date('d-m-Y', strtotime($versement->Date))}}</td>
                          <td>{{$versement->Montant}}</td>
                          <td>{{$versement->MoyenPaiemet}}</td>
                 
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->


      <div class="modal fade asigneVehicule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">ASSIGNER UN CONDUCTEUR</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            <div class="modal-body">
            <form  class="form-horizontal style-form" action="{{route('Add-Conducteur-Location')}}" method="POST">
                @csrf
             
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                        <label class="control-label" >DATE</label>
                        <input type="date" required value="{{ Request::old('date') }}" class="form-control" name="date">
                    
                      
                          <input type="hidden" value="{{ $locations->id }}" class="form-control" name="location">
                       
                    </div>
                    <div class="col-sm-6">
                      {{-- <label class="control-label">STATUS</label>
                      <select name="status" class="form-control"  required id="">
                       
                        <option value="EN COURS">EN COURS</option>
                        <option value="EN ATTENTE">EN ATTENTE</option>
                        <option value="REPARE">REPARE</option>
                        <option value="HORS SERVICE">HORS SERVICE</option>
                      </select> --}}
                      
                    <label class="control-label">CONDUCTEUR</label>
                      <select name="conducteur" class="form-control"  required id="">
                        <option value="">CHOIX DU CONDUCTEUR</option>
                        @foreach ( $membres as $conducteur )
                        <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                          
                        @endforeach
                      </select>
                    </div>
                    </div>
                   
    
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

      <div class="modal fade versementLocat" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">VERSEMENT</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            <div class="modal-body">
            <form  class="form-horizontal style-form" action="{{route('Add-versement-Location')}}" method="POST">
                @csrf
             
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                        <label class="control-label" >MONTANT</label>
                        <input type="number" required value="{{ Request::old('montant') }}" class="form-control" name="montant">
                    
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label" >DATE</label>
                        <input type="date" required value="{{ Request::old('date') }}" class="form-control" name="date">
                    
                      
                          <input type="hidden" value="{{ $locations->id }}" class="form-control" name="location">
                       
                    </div>
                    <div class="col-sm-6">
                      <label class="control-label">MOYEN PAIEMENT</label>
                      <select name="moyen" class="form-control"  required id="">
                       
                        <option value="ESPECE">ESPECE</option>
                        <option value="MOBILE MONEY">MOBILE MONEY</option>
                        <option value="WAVE">WAVE</option>
                        <option value="VIREMENT">VIREMENT</option>
                        <option value="CHEQUE">CHEQUE</option>
                      </select>
                    </div>
               
                    </div>
                   
    
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

    </section>
    <!-- /.content -->
  </div>

@endsection