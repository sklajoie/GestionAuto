@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VIDANGES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">VIDANGES</li>
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
                <h3 class="card-title " >LISTE DES VIDANGES
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
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
                    <th>ACTION</th>
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
                        <td> {{$vidange->Status}}</td>
                        <td>
                          <div  style="display:flex; flex-direction:row; ">
                            <button type="button" class="btn btn-success btn-xs m-1" data-toggle="modal" data-target=".modifiassurance{{$vidange->id}}"> <i class="fas fa-edit"></i> Modifier</button>
                           
                            <a href="javascript:;" class="btn btn-xs btn-danger sa-delete m-1" data-form-id="category-delete-{{$vidange->id}}">
                              <i class="fa fa-trash"></i> Supprimer
                          </a> 
      
                          <form id="category-delete-{{$vidange->id}}" action="{{route('Vidanges.destroy', $vidange->id)}}" method="POST"> 
                          @csrf 
                          @method('DELETE') 
      
                          </form>  
                          </div>
                        </td>
                    </tr>
                    <div class="modal fade modifiassurance{{$vidange->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">MODIFIER LE VISITE</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            <div class="modal-body">
                            <form  class="form-horizontal style-form" action="{{route('Vidanges.update',$vidange->id )}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="conducteur">Conducteur</label>
                                        <select class="form-control" name="conducteur" id="conducteur">
                                            <option value="">Choix du conducteur</option>
                                            @foreach ( $membres as $membre )
                                            <option {{$vidange->conducteur_id=== $membre->id ? 'selected' : ''}} value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>
                                            @endforeach
                                            </select>
                                        </div>
    
                                        <div class="form-group">
                                          <label for="date_vidange">Date de Vidange</label>
                                          <input type="date" class="form-control" value="{{$vidange->DateVidange}}"  placeholder="" name="date_vidange" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="date_fin">Date Fin</label>
                                          <input type="date" class="form-control" value="{{$vidange->DateFin}}"  placeholder="" name="date_fin" required >
                                        </div>
                                        <div class="form-group">
                                          <label for="kilo_vidange">Kilométrage jour de vidange </label>
                                          <input type="text" class="form-control" value="{{$vidange->KiloVidange}}"  placeholder="" name="kilo_vidange" required>
                                        </div>
                                      </div>
                                      <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="marque_huile">Marque de l'huile</label>
                                    <input type="text" class="form-control" value="{{$vidange->MarqueHuile}}"  placeholder="" name="marque_huile" >
                                  </div>
                                  <div class="form-group">
                                    <label for="kilo_huile">Kilométrage de l'huile</label>
                                    <input type="text" class="form-control" value="{{$vidange->KiloHuile}}"  placeholder="" name="kilo_huile" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="kilo_prochain">Kilométrage de la prochaine Vidange</label>
                                    <input type="text" class="form-control" value="{{$vidange->KiloProchainVidange}}" placeholder="" name="kilo_prochain" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="montant">Coût  Vidange</label>
                                    <input type="text" class="form-control" value="{{$vidange->Montant}}" placeholder="" name="montant" required>
                                  </div>
                                    <div class="form-group">
                                        <label for="details">Plus de détails</label>
                                    <textarea name="details" id="" class="form-control" cols="100" rows="2">{{$vidange->Details}}</textarea>
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
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UNE VISITE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        	<form role="form" method="POST" action="{{route('Vidanges.store')}}" enctype="multipart/form-data">
	
                {!! csrf_field() !!}
                    <section class="content">
                 
                     <div class="row">
                        <div class="col-md-12">
                         <!-- general form elements -->
                         <div class="box box-primary">
                           <div class="box-header" align="center">
                             <h3 class="box-title" ></h3>
                            
                           </div><!-- /.box-header -->
                           <!-- form start -->
            
                             <div class="row col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="conducteur">Conducteur</label>
                                    <select class="form-control" name="conducteur" id="conducteur">
                                        <option value="">Choix du conducteur</option>
                                        @foreach ( $membres as $membre )
                                        @if($chauferVehicules !=null)
                                        <option {{$chauferVehicules->conducteur_id === $membre->id ? "selected" : ""}} value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>
                                       @else
                                        <option value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>
                                       @endif
                                        @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                      <label class="control-label">Véhicule</label>
                                      <select name="idvehecule" class="form-control"  required id="">
                                        <option value="">CHOIX DU VEHICULE</option>
                                        @foreach ( $voitures as $vehicule )
                                        <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                                          
                                        @endforeach
                                      </select>
                                    </div>
                                    <div class="form-group">
                                      <label for="date_vidange">Date de Vidange</label>
                                      <input type="date" class="form-control"  placeholder="" name="date_vidange" required >
                                    </div>
                                    <div class="form-group">
                                      <label for="date_fin">Date Fin</label>
                                      <input type="date" class="form-control"  placeholder="" name="date_fin" required >
                                    </div>
                                    <div class="form-group">
                                      <label for="matricule">Kilométrage jour de vidange </label>
                                      <input type="text" class="form-control"  placeholder="" name="kilo_vidange" required>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                              <div class="form-group">
                                <label for="marque_huile">Marque de l'huile</label>
                                <input type="text" class="form-control"  placeholder="" name="marque_huile" >
                              </div>
                            <div class="form-group">
                              <label for="kilo_huile">Kilométrage de l'huile</label>
                              <input type="text" class="form-control"  placeholder="" name="kilo_huile" required>
                            </div>
                            <div class="form-group">
                              <label for="kilo_prochain">Kilométrage de la prochaine Vidange</label>
                              <input type="text" class="form-control"  placeholder="" name="kilo_prochain" required>
                            </div>
                            <div class="form-group">
                              <label for="montant">Coût  Vidange</label>
                              <input type="number" class="form-control"  placeholder="" name="montant" required>
                            </div>
                            <div class="form-group">
                                <label for="details">Plus de détails</label>
                            <textarea name="details" id="" class="form-control" cols="100" rows="2"></textarea>
                        </div>
                        </div>
                    </div>
                    <div class="form-group" style="text-align: center;">
                   <button type="submit"  class="btn btn-primary"  >Enregistrer</button>
                 </div>
                     </div>
                
                     
                </div>
                
                
               
           
                   </section><!-- /.content -->
                   </form>
      </div>
    </div>
  </div>
  </div>
@endsection