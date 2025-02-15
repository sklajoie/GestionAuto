@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>UtILISATEUR</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">UtILISATEUR</li>
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

                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th>N*</th>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Fonction</th>
                            <th style="text-align: center">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if ($users)
                        @foreach ($users as $key=>$user)
                            <tr>
                                <td>{{++$key}}</td>
                                <td>{{date('d-m-Y H:i', strtotime($user->created_at))}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->Contact}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->Fonction}}</td>
                                <td style="text-align: center">
                                 
                                  <div  style="display:flex; flex-direction:row; ">
                                    @if($user->Active =="1")
                                    <a href="{{route('deactive-user', $user->id)}}" onclick="return confirm(`Êtes-vous sûr de vouloir desactiver cet utilisateur ?`);" title="Déactiver Utilisateur" class="btn btn-xs btn-success m-1"> <i class="fa fa-toggle-on"></i> Active </a>
                                    @else
                                    <a href="{{route('active-user', $user->id)}}"  onclick="return confirm(`Êtes-vous sûr de vouloir activer cet utilisateur ?`);" title="activer Utilisateur" class="btn btn-xs btn-warning m-1"> <i class="fa fa-toggle-off"></i> Désactivé </a>
                                    @endif
                                   
                                    <button type="button" class="btn btn-xs btn-primary m-1" title="Modifier Utilisateur" data-toggle="modal" data-target="#editeModal{{$user->id}}">
                                    <i class="fa fa-edit"></i> Modifier
                                      </button>
                                     
                                
                                       <a href="javascript:;" class="btn btn-xs btn-danger  sa-delete m-1" title="Supprimer Utilisateur" data-form-id="category-delete-{{$user->id}}">
                                           <i class="fa fa-trash"></i> Supprimer
                                       </a>
                               
        
                                <form id="category-delete-{{$user->id}}" action="{{route('Users.destroy', $user->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
        
                                </form>
                                  </div>
                                </td>
                            </tr>
        
        
        
                            <div class="modal fade" id="editeModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modifier Utilisateur</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                          <form action="{{route('Users.update', $user->id)}}" method="POST">
                              @csrf
                              @method('PUT')
                                  <div class="form-group row col-sm-12">
                         
                          <div class="col-sm-6">
                          <label class=" control-label">UTILISATEUR</label>
                          <input type="text" class="form-control"  name="nom" value="{{$user->name}}" required>
                          </div>
                          <div class="col-sm-6">
                          <label class=" control-label">CONTACT</label>
                          <input type="text" class="form-control"  name="tel" value="{{$user->Contact}}" required>
                          </div>
                          <div class="col-sm-6">
                          <label class=" control-label">EMAIL</label>
                          <input type="text" class="form-control"  name="email" value="{{$user->email}}" >
                          </div>
                          <div class="col-sm-6">
                          <label class=" control-label">FONCTION</label>
                           <select class="form-control" required name="fonction">
                            <option  value="{{$user->Fonction}}">{{$user->Fonction}}</option>
                            <Option value="GESTIONNAIRE">GESTIONNAIRE </Option>
                            <Option value="RESPONSABLE">RESPONSABLE </Option>
                            </select>
                          </div>
                           
                          <div class="col-sm-6">
                          <label class=" control-label">MOT PASSE</label>
                            <input type="password" name="pass" id="pwd"  class="form-control toggle-password" placeholder="Password">
                            
                          </div>
                        </div>
                            <div class="card-footer" style="text-align:center">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
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
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UN UTILISATEUR</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        <div class="modal-body">
        	<form role="form" method="POST" action="{{route('Users.store')}}" enctype="multipart/form-data">
	
                {!! csrf_field() !!}
                <div class="form-group row col-sm-12">
                         
                    <div class="col-sm-6">
                    <label class=" control-label">UTILISATEUR</label>
                    <input type="text" class="form-control"  name="nom"  required>
                    </div>
                    <div class="col-sm-6">
                    <label class=" control-label">CONTACT</label>
                    <input type="text" class="form-control"  name="tel" required>
                    </div>
                    <div class="col-sm-6">
                    <label class=" control-label">EMAIL</label>
                    <input type="text" class="form-control"  name="email" >
                    </div>
                    <div class="col-sm-6">
                    <label class=" control-label">FONCTION</label>
                     <select class="form-control" required name="fonction">
                        <option value="">--- ---</option>
                      <Option value="GESTIONNAIRE">GESTIONNAIRE </Option>
                      <Option value="RESPONSABLE">RESPONSABLE </Option>
                      </select>
                    </div>
                     
                    <div class="col-sm-6">
                    <label class=" control-label">MOT PASSE</label>
                      <input type="password" name="pass" id="pwd"  class="form-control toggle-password" placeholder="Password">
                      
                    </div>
                   
                    
  
                  </div>
  
                                      <!-- /.card-body -->
      
                      <div class="card-footer" style="text-align:center">
                          <button type="submit" class="btn btn-primary">ENREGISTRER</button>
                      </div>
                      </form>
      </div>
    </div>
  </div>
  </div>
@endsection