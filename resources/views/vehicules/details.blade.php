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
          <div class="col-md-4">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
             {{-- <a href="{{route('rapports')}}">rapport</a> --}}
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>MATRICULATION</b> <a class="float-right">{{$vehicules->Matriculation}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>MARQUE</b> <a class="float-right">{{$vehicules->Marque}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>MODEL</b> <a class="float-right">{{$vehicules->Model}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>CHASSIS</b> <a class="float-right">{{$vehicules->Chassis}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>COULEUR</b> <a class="float-right">{{$vehicules->Couleur}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>NOMBRE DE PLACE</b> <a class="float-right">{{$vehicules->NombrePlace}}</a>
                  </li>
                  <li class="list-group-item">
                    <b>DATE ACQUISITION</b> <a class="float-right">{{date('d-m-Y', strtotime($vehicules->DateAcquisition))}}</a>
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
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">CONDUCTEURS</a></li>
                  {{-- <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">VERSEMENTS</a></li> --}}
                  <li class="nav-item"><a class="nav-link" href="#histryversmt" data-toggle="tab">VERSEMENTS</a></li>
                  <li class="nav-item"><a class="nav-link" href="#assurances" data-toggle="tab">ASSURANCES</a></li>
                  <li class="nav-item"><a class="nav-link" href="#visites" data-toggle="tab">VISITES</a></li>
                  <li class="nav-item"><a class="nav-link" href="#vidanges" data-toggle="tab">VIDANGES</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">GARAGE</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">
                   <div class="table-responsive">
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".asigneVehicule">ASSIGNATION <i class="fas fa-plus"></i></button>

                    <table id="example2" class="example2 table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>N*</th>
                          <th>DATE ASSIGNATION</th>
                          {{-- <th>REFERENCE</th> --}}
                          <th>STATUS</th>
                          <th>NOM & PRENOM(S)</th>
                          <th>CONTACT</th>
                          <th>ADDRESS</th>
                          <th>RECETTE/JOUR</th>
                          <th>DATE FIN ASIGNE</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if($chauferVehicules)
                          @foreach ($chauferVehicules as $key=>$chauffeurv )
                              @php if($chauffeurv->Status == "ASSIGNE") { $idchauffeurv = $chauffeurv->conducteur_id ;}  @endphp
                          <tr>
                              <td>{{++$key}}</td>
                              <td>{{date('d-m-Y', strtotime($chauffeurv->dateAsignation))}}</td>
                              <td> 
                                <button class="btn-xs {{$chauffeurv->Status==="ASSIGNE" ? 'btn btn-success': 'btn btn-danger'}}">{{$chauffeurv->Status}}</button>
                              </td>
                              {{-- <td>{{$chauffeurv->conducteur->Reference}}</td> --}}
                              <td>{{$chauffeurv->conducteur->NomPrenom}}</td>
                              <td>{{$chauffeurv->conducteur->Contact}} </td>
                              <td> {{$chauffeurv->conducteur->Address}}</td>
                              <td> {{$chauffeurv->recetteJournalier}}</td>
                              <td> {{$chauffeurv->dateFinAsigne ? date('d-m-Y', strtotime($chauffeurv->dateFinAsigne)) : ''}}</td>
                              
                          </tr>
                          @endforeach
                          @endif
                        </tbody>
                    </table>
                  </div>

                    
  <div class="modal fade asigneVehicule" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">ASSIGNER UN VEHICULE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        <form  class="form-horizontal style-form" action="{{route('VehiculeConducteur.store')}}" method="POST">
            @csrf
         
              <div class="form-group row col-sm-12">
                <div class="col-sm-6">
                    <label class="control-label" >DATE ASSIGNATION</label>
                    <input type="date" required value="{{ Request::old('dateAsignation') }}" class="form-control" name="dateAsignation">
                
                    <label class="control-label">DATE FIN ASSIGNATION</label>
                      <input type="date" value="{{ Request::old('dateFinAsigne') }}" class="form-control" name="dateFinAsigne">
                    
                
                <label class="control-label">RECETTE JOURNALIERE </label>
                  <input type="number"  value="{{ Request::old('recetteJournalier') }}" class="form-control" name="recetteJournalier">
                
     
                </div>
                <div class="col-sm-6">
                  {{-- <label class="control-label">STATUS</label>
                  <select name="status" class="form-control"  required id="">
                   
                    <option value="EN COURS">EN COURS</option>
                    <option value="EN ATTENTE">EN ATTENTE</option>
                    <option value="REPARE">REPARE</option>
                    <option value="HORS SERVICE">HORS SERVICE</option>
                  </select> --}}
                <label class="control-label">VEHICULE</label>
                  <select name="vehicule" class="form-control"  required id="">
                    <option value="">CHOIX DU VEHICULE</option>
                    @foreach ( $vehiculesl as $vehicule )
                    <option {{$vehicules->id === $vehicule->id ? 'selected': ""}} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                      
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


                </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="timeline">
                    <!-- The timeline -->   
                    <a href="{{route('Panne-Vehicule',$vehicules->id)}}" class="btn btn-info"> <i class="fas fa-eye"></i>Garage </a>
                      <!-- timeline time label -->
                      <div class="table-responsive">
                      <table id="example2" class="table table-bordered table-striped example2">
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

                   

                  </div>
                  <!-- /.tab-pane -->

                  
                  <div class="tab-pane" id="histryversmt">
                    <div class=" table-responsive">
                      <table id="example1" class=" table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th></th>
                          <th>Date</th>
                          <th>Code Paiement</th>
                          <th>Montant</th>
                          <th>Rubrique</th>
                          <th>Moyen</th>
                          <th>Bénéficièr</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($versements as $key=>$versement )
                        <tr>
                          <td>{{++$key}}</td>
                          <td>{{$versement->date}}</td>
                          <td>{{$versement->codePaiement}}</td>
                          <td>{{$versement->Montant}}</td>
                          <td>{{$versement->Rubrique}}</td>
                          <td>{{$versement->MoyenPaiemet}}</td>
                          <td>
                            @if($versement->Type =="autre")
                            {{$versement->Beneficier}} 
                            @endif
                            @if($versement->Type == "employe")
                            {{$versement->conducteur->NomPrenom}} ({{$versement->conducteur->Contact}})
                            @endif
      
                          </td>
                        </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane" id="settings">

                  </div>
                  <div class="tab-pane" id="assurances">
                    <div class="table-responsive">
                      <table id="example1" class="table table-bordered table-striped example2">
                        <thead>
                        <tr>
                          <th>N*</th>
                          <th>ASSURANCE</th>
                          <th>COMPAGNIE</th>
                          <th>DATE DEBUT</th>
                          <th>DATE FIN</th>
                          <th>STATUS</th>
                          <th>ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($assurances as $key=>$assurance )
                              
                          <tr>
                              <td>{{++$key}}</td>
                              <td>{{$assurance->NomAssurance}}</td>
                              <td>{{$assurance->CompagnieAssurance}} </td>
                              <td> {{date('d-m-Y', strtotime($assurance->DateDebut))}}</td>
                              <td> {{date('d-m-Y', strtotime($assurance->DateFin))}}</td>
                              <td> 
                                @if($assurance->Status == "EN COURS") <span class="btn btn-success btn-xs"> Fin Dans {{diffdate($assurance->DateFin)}}  Jour(s) </span>
                                @else
                                 <span class="btn btn-danger">{{$assurance->Status}}</span> 
                                 @endif
                              </td>
                              <td>
                                  <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".modifiassurance{{$assurance->id}}"> <i class="fas fa-edit"></i></button>
                                
                              </td>
                          </tr>
                          <div class="modal fade modifiassurance{{$assurance->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">MODIFIER LE ASSUARNCE</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                        </button>
                                      </div>
                                  <div class="modal-body">
                                  <form  class="form-horizontal style-form" action="{{route('Assurances.update',$assurance->id )}}" method="POST">
                                      @csrf
                                      @method('PUT')
                                      <div class="row col-md-12">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                  <label for="matricule">Conducteur</label>
                                              <select class="form-control" name="conducteur" id="conducteur">
                                                  <option value="">Choix du conducteur</option>
                                                  @foreach ( $membres as $membre )
                                                  <option {{$assurance->conducteur_id=== $membre->id ? 'selected' : ''}} value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>
                                                  @endforeach
                                                  </select>
                                              </div>
          
                                         <div class="form-group">
                                           <label for="matricule">Numero Assurance</label>
                                           <input type="text" class="form-control" value="{{$assurance->NomAssurance}}" placeholder="" name="num_assur" >
                                         </div>
                                                <div class="form-group">
                                           <label for="matricule">Compagnie Assurance</label>
                                           <input type="text" class="form-control" value="{{$assurance->CompagnieAssurance}}"  placeholder="" name="comp_assur" >
                                         </div>
                                      </div>
                                      <div class="col-md-6">
                                          <div class="form-group">
                                             <label for="matricule">Date debut Assurance</label>
                                             <input type="date" class="form-control" value="{{$assurance->DateDebut}}"  placeholder="" name="date_debut" required>
                                           </div>
                                         <div class="form-group">
                                           <label for="matricule">Date fin Assurance</label>
                                           <input type="date" class="form-control"  placeholder="" value="{{$assurance->DateFin}}" name="date_fin" required >
                                         </div>
                                         <div class="form-group">
                                             <label for="matricule">Plus de détails</label>
                                         <textarea name="details" id="" class="form-control" cols="50" rows="2">{{$assurance->Details}}</textarea>
                                     </div>
                                         {{-- <div class="form-group">
                                           <label for="matricule">Photo de la police d'assurance</label>
                                           <input type="file" class="form-control"  placeholder="" name="photo_assur" >
                                         </div> --}}
                                      </div>
                                  </div>
                                  {{-- <input type="hidden" class="form-control"  placeholder="" name="idvehecule" > --}}
                               
                                   <div class="form-group" style="text-align: center;">
                                  <button type="submit"  class="btn btn-danger"  >Modifier</button>
                                </div>
                                             </form>
                                </div>
                              </div>
                            </div>
                            </div>
                          @endforeach
                        </tbody>
                        
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane" id="visites">
                    <div class="table-responsive">
                      <table id="example1" class="table example2  table-bordered table-striped table-responsive">
                        <thead>
                        <tr>
                          <th>N*</th>
                          <th>DATE VISITE</th>
                          <th>DATE FIN</th>
                          <th>CONDUCTEUR</th>
                          <th>ATTESTATION</th>
                          <th>STATUS</th>
                        </tr>
                        </thead>
                        <tbody>
                          @foreach ($visites as $key=>$visite )
                              
                          <tr>
                              <td>{{++$key}}</td>
                              <td> {{date('d-m-Y', strtotime($visite->DateVisite))}}</td>
                              <td> {{date('d-m-Y', strtotime($visite->DateFin))}}</td>
                              <td>{{$visite->conducteur->NomPrenom}}</td>
                              {{-- <td>{{$visite->vehicule->Matriculation}} </td> --}}
                              <td>{{$visite->Attestation}} </td>
                              <td>
                                @if($visite->Status == "EN COURS") <span class="btn btn-success btn-xs"> Fin Dans {{diffdate($visite->DateFin)}}  Jour(s) </span>
                                @else
                                 <span class="btn btn-danger">{{$visite->Status}}</span> 
                                 @endif
                                 
                                </td>
                          </tr>

                          @endforeach
                        </tbody>
                        
                      </table>
                    </div>
                  </div>

                  <div class="tab-pane" id="vidanges">
                    <div class="table-responsive">
                    <table id="example2" class="table table-bordered table-striped example2">
                      <thead>
                      <tr>
                        <th>N*</th>
                        <th>DATE VIDANGE</th>
                        <th>DATE FIN</th>
                        <th>KILOMETRAGE</th>
                        <th>Marue HUILE</th>
                        <th>KILOM.. HUILE</th>
                        <th>PROCHAIN KILOM..</th>
                        <th>CONDUCTEUR</th>
                        <th>STATUS</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($vidanges as $key=>$vidange )
                            
                        <tr>
                            <td>{{++$key}}</td>
                            <td> {{date('d-m-Y', strtotime($vidange->DateVidange))}}</td>
                            <td> {{date('d-m-Y', strtotime($vidange->DateFin))}}</td>
                            <td>{{$vidange->KiloVidange}} </td>
                            <td>{{$vidange->MarqueHuile}} </td>
                            <td>{{$vidange->KiloHuile}} </td>
                            <td>{{$vidange->KiloProchainVidange}} </td>
                            <td>{{$vidange->conducteur->NomPrenom}}</td>
                            <td> 
                              @if($vidange->Status == "EN COURS") <span class="btn btn-success btn-xs"> Fin Dans {{diffdate($vidange->DateFin)}}  Jour(s) </span>
                              @else
                               <span class="btn btn-danger">{{$vidange->Status}}</span> 
                               @endif
                            </td>
                           
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



    </section>
    <!-- /.content -->
  </div>

@endsection