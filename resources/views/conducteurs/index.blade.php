@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>EMPLOYES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Employé</li>
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
                <h3 class="card-title " >LISTE DES EMPLOYES
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">AJOUTER <i class="fas fa-plus"></i></button>

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>N*</th>
                    <th>REFERENCE</th>
                    <th>NOM & PRENOM(S)</th>
                    <th>CONTACT</th>
                    <th>EMAIL</th>
                    <th>ADDRESS</th>
                    <th>STATUS</th>
                    <th>DATE ENREGISTRE</th>
                    <th>ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($chauffeurs as $key=>$chauffeur )
                        
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{$chauffeur->Reference}}</td>
                        <td>{{$chauffeur->NomPrenom}}</td>
                        <td>{{$chauffeur->Contact}} </td>
                        <td>{{$chauffeur->Email}}</td>
                        <td> {{$chauffeur->Address}}</td>
                        <td> {{$chauffeur->Status}}</td>
                        <td> {{date('d-m-Y', strtotime($chauffeur->created_at))}}</td>
                        <td>
                          <div  style="display:flex; flex-direction:row; ">
                            <button type="button" class="btn btn-success btn-xs m-1" data-toggle="modal" data-target=".modificonducteur">MODIFIER <i class="fas fa-edit"></i></button>

                            <a href="javascript:;" class="btn btn-xs btn-danger sa-delete m-1" data-form-id="category-delete-{{$chauffeur->id}}">
                              <i class="fa fa-trash"></i> Supprimer
                          </a> 
      
                          <form id="category-delete-{{$chauffeur->id}}" action="{{route('Conducteurs.destroy', $chauffeur->id)}}" method="POST"> 
                          @csrf 
                          @method('DELETE') 
      
                          </form>
                          </div>
                        </td>
                    </tr>
                    <div class="modal fade modificonducteur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                              <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">MODIFIER L'EMPLOYE</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            <div class="modal-body">
                            <form  class="form-horizontal style-form" enctype="multipart/form-data" action="{{route('Conducteurs.update',$chauffeur->id )}}" method="POST">
                                @csrf
                                @method('PUT')
                                  <div class="form-group row col-sm-12">
                                    <div class="col-sm-6">
                                        <label class="control-label" >NOM & PRENOM(S)</label>
                                        <input type="text" required value="{{$chauffeur->NomPrenom}}" class="form-control" name="nomPrenom">
                                    
                                    
                                    <label class="control-label">CONTACT</label>
                                      <input type="text" required value="{{$chauffeur->Contact}}" class="form-control" name="contact">
                                    
                                    <label class="control-label">EMAIL</label>
                                      <input type="text"  value="{{$chauffeur->Email}}" class="form-control" name="email">
                                    </div>
                                    <div class="col-sm-6">
                                    <label class="control-label">ADDRESS</label>
                                      <input type="text" value="{{$chauffeur->Address}}" class="form-control" name="address">
                                    <label class="control-label">PERMIS|CNI|PASSPORT|AUTRE DOCUMENT</label>
                                      <input type="file"  class="form-control" name="permis">
                                    
                                      <label class="control-label">STATUS</label>
                                        <select name="status" class="form-control"  required id="">
                                          <option value="{{$chauffeur->Status}}">{{$chauffeur->Status}}</option>
                                          <option value="NOUVEAU CONDUCTEUR">NOUVEAU CONDUCTEUR</option>
                                          <option value="ANCIEN CONDUCTEUR">ANCIEN CONDUCTEUR</option>
                                          <option value="INTERMEDIAIRE">INTERMEDIAIRE</option>
                                          <option value="AUTRE">AUTRE</option>
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
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UN EMPLOYE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        <form  class="form-horizontal style-form" action="{{route('Conducteurs.store')}}" enctype="multipart/form-data" method="POST">
            @csrf
         
              <div class="form-group row col-sm-12">
                <div class="col-sm-6">
                    <label class="control-label" >NOM & PRENOM</label>
                    <input type="text" required value="{{ Request::old('nomPrenom') }}" class="form-control" name="nomPrenom">
                
                
                <label class="control-label">CONTACT</label>
                  <input type="text" required value="{{ Request::old('contact') }}" class="form-control" name="contact">
                
                <label class="control-label">EMAIL</label>
                  <input type="text" required value="{{ Request::old('email') }}" class="form-control" name="email">
                </div>

                <div class="col-sm-6">
                  <label class="control-label">ADDRESS</label>
                    <input type="text" value="{{ Request::old('address') }}" class="form-control" name="address">
                <label class="control-label">PERMIS|CNI|PASSPORT|AUTRE DOCUMENT</label>
                  <input type="file"  class="form-control" name="permis">
              
                  <label class="control-label">STATUS</label>
                    <select name="status" class="form-control"  required id="">
                      <option value="">Choix status</option>
                      <option value="NOUVEAU CONDUCTEUR">NOUVEAU CONDUCTEUR</option>
                        <option value="ANCIEN CONDUCTEUR">ANCIEN CONDUCTEUR</option>
                        <option value="INTERMEDIAIRE">INTERMEDIAIRE</option>
                        <option value="AUTRE">AUTRE</option>
                      </select>
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