@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VISITES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">VISITES</li>
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
                <h3 class="card-title " >LISTE DES VISITES
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N*</th>
                    <th>DATE VISITE</th>
                    <th>DATE FIN</th>
                    <th>CONDUCTEUR</th>
                    <th>ATTESTATION</th>
                    <th>STATUS</th>
                    <th>ACTION</th>
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
                        <td> {{$visite->Status}}</td>
                        <td>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target=".modifiassurance{{$visite->id}}"> <i class="fas fa-edit"></i></button>
                            <a href="{{route('Assurances.show',$visite->id)}}" class="btn btn-info"> <i class="fas fa-list"></i> </a>
                        </td>
                    </tr>
                    <div class="modal fade modifiassurance{{$visite->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">MODIFIER LE VISITE</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            <div class="modal-body">
                            <form  class="form-horizontal style-form" action="{{route('Visites.update',$visite->id )}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row col-md-12">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="matricule">Conducteur</label>
                                        <select class="form-control" name="conducteur" id="conducteur">
                                            <option value="">Choix du conducteur</option>
                                            @foreach ( $membres as $membre )
                                            <option {{$visite->conducteur_id=== $membre->id ? 'selected' : ''}} value="{{$membre->id}}">{{$membre->NomPrenom}} {{$membre->Contact}} ({{$membre->Reference}})</option>
                                            @endforeach
                                            </select>
                                        </div>
    
                                        <div class="form-group">
                                            <label for="matricule">Date de la visite</label>
                                            <input type="date" class="form-control" value="{{$visite->DateVisite}}"  placeholder="" name="date_vit" required>
                                          </div>
                                        <div class="form-group">
                                            <label for="matricule">Date fin visite</label>
                                            <input type="date" class="form-control" value="{{$visite->DateFin}}"  placeholder="" name="date_fin_vit" required>
                                          </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="matricule">Photo du certificat de visite</label>
                                        <input type="file" class="form-control"  placeholder="" name="foto_cert">
                                      </div>
                                    <div class="form-group">
                                        <label for="matricule">Plus de détails</label>
                                    <textarea name="details" id="" class="form-control" cols="100" rows="2">{{$visite->Details}}</textarea>
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
        	<form role="form" method="POST" action="{{route('Visites.store')}}" enctype="multipart/form-data">
	
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
                                        <label for="matricule">Conducteur</label>
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
                                        <label for="matricule">Date de la visite</label>
                                        <input type="date" class="form-control"  placeholder="" name="date_vit" required>
                                      </div>
                                    <div class="form-group">
                                        <label for="matricule">Date fin visite</label>
                                        <input type="date" class="form-control"  placeholder="" name="date_fin_vit" required>
                                      </div>
                            </div>
                            <div class="col-md-6">
                               <div class="form-group">
                                <label for="matricule">Photo du certificat de visite</label>
                                <input type="file" class="form-control"  placeholder="" name="foto_cert">
                              </div>
                            <div class="form-group">
                                <label for="matricule">Plus de détails</label>
                            <textarea name="details" id="" class="form-control" cols="100" rows="2"></textarea>
                        </div>
                        </div>
                        <input type="hidden" class="form-control"  placeholder="" value="{{$idvehicule}}" name="idvehecule" >
                     
                        
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