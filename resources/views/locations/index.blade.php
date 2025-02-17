@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>GESTION LOCATIONS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Gestion Locations</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->
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
            <div class="card">
              <div class="card-header" style="text-align:center; !important">
                <h3 class="card-title " >LISTE DES LOCATIONS</h3>
                <button type="button" class="btn btn-sm btn-primary" style="margin-left : 10px" data-toggle="modal" data-target="#addModal">
                    <i class="fa fa-plus"></i> AJOUTER
                      </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th></th>
                    <th>DATE ENREGISTRE</th>
                    <th>VEHICULE</th>
                    <th >CLIENT</th>
                    <th >CONTACT</th>
                    <th >DATE DEBUT</th>
                    <th >DATE FIN</th>
                    <th >MONTANT</th>
                    <th >ACTIONS</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ( $locations as $key=>$location )
                        
                    
                    <tr class="gradeX">
                      <td >{{ ++$key }}</td>
                      <td >{{ date('d-m-Y à H:i', strtotime($location->created_at ))}}</td>
                      <td >{{$location->vehicule->Marque}} ({{$location->vehicule->Matriculation}})</td>
                      <td>{{$location->Client}}</td>
                      <td>{{$location->Contact}}</td>
                      <td>{{ date('d-m-Y', strtotime($location->DateDebut ))}}</td>
                      <td>{{ date('d-m-Y', strtotime($location->DateFin ))}}</td>
                      <td>{{$location->Montant}}</td>
                      <td >
                        <div  style="display:flex; flex-direction:row; ">
                         
                              <button type="button" class="btn btn-xs btn-warning m-1" style="margin: 1px" data-toggle="modal" data-target="#edditModal{{$location->id}}">
                              <i class="fa fa-edit"></i> 
                                  </button>
                                  <a href="{{route('Locations.show',$location->id)}}" class="btn btn-info btn-xs m-1"> <i  class="fa fa-list"></i> </a>
                                  <a href="javascript:;" class="btn btn-xs btn-danger sa-delete m-1" data-form-id="category-delete-{{$location->id}}">
                                    <i class="fa fa-trash"></i> 
                                </a> 
            
                                <form id="category-delete-{{$location->id}}" action="{{route('Locations.destroy', $location->id)}}" method="POST"> 
                                @csrf 
                                @method('DELETE') 
            
                                </form>
                      
                      </div>
  
                      </td>
                      
                    </tr>
  
  
  <div class="modal fade " id="edditModal{{$location->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">MODIFIER</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form  class="form-horizontal style-form" action="{{route('Locations.update',$location->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
              @method('PUT')
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                      <label class="control-label">VEHICULE</label>
                      <select name="vehicule" class="form-control"  required id="">
                        @foreach ( $voitures as $vehicule )
                        <option {{$location->vehicule_id === $vehicule->id ? 'selected' : ""}} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                          
                        @endforeach
                      </select>
                    <label class="control-label">NOM CLIENT</label>
                      <input type="text" value="{{$location->Client}}" class="form-control" name="nomclient">
                   
                    <label class="control-label">CONTACT CLIENT</label>
                      <input type="text" value="{{$location->Contact}}" class="form-control" name="telclient">
                    
                    <label class="control-label">ADDRESSE CLIENT</label>
                      <input type="text" value="{{$location->Address}}" class="form-control" name="addressclient">
                 
                    <label class="control-label">PIECE JUSTIFICATIF (CNI/PERMIS...)</label>
                      <input type="file"  class="form-control" name="piece">
                    </div>
                    <div class="col-sm-6">
                    <label class="control-label">DATE DEBUT</label>
                      <input type="date" value="{{$location->DateDebut}}" class="form-control" name="datedebut">
                   
                    <label class="control-label">DATE FIN</label>
                      <input type="date" value="{{$location->DateFin}}" class="form-control" name="datefin">
                   
                    <label class="control-label">PRIX LOCATION</label>
                      <input type="number" value="{{$location->Montant}}" class="form-control" name="prix">
                    
                    <label class="control-label">KILOMETRAGE DEBUT</label>
                      <input type="number" value="{{$location->KmDebut}}" class="form-control" name="kmdebut">
                    
                    <label class="control-label">KILOMETRAGE FIN</label>
                      <input type="number" value="{{$location->KmFin}}" class="form-control" name="kmfin">
                    
                    </div>
                    <label class="control-label">DETAILS</label>
                     <textarea name="details" id="" class="form-control">{{$location->Details}}</textarea>
                    </div>
  
  
                   <div class="" style="text-align: center;">
                      <br>
                 <button type="submit" class=" btn btn-warning">MODIFIER</button>
                
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

           <div class="modal fade " id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form  class="form-horizontal style-form" action="{{route('Locations.store')}}" enctype="multipart/form-data"  method="POST">
                    @csrf
                 
                      <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                          <label class="control-label">VEHICULE</label>
                          <select name="vehicule" class="form-control"  required id="">
                            <option value="">Choix du véhicule</option>
                            @foreach ( $voitures as $vehicule )
                            <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                              
                            @endforeach
                          </select>
                        
                        <label class="control-label">NOM CLIENT</label>
                          <input type="text" class="form-control" name="nomclient">
                        
                        <label class="control-label">CONTACT CLIENT</label>
                          <input type="text"  class="form-control" name="telclient">
                       
                        <label class="control-label">ADDRESSE CLIENT</label>
                          <input type="text"  class="form-control" name="addressclient">
                       
                        <label class="control-label">PIECE JUSTIFICATIF (CNI/PERMIS...)</label>
                          <input type="file"  class="form-control" name="piece">
                        </div>
                        <div class="col-sm-6">
                        <label class="control-label">DATE DEBUT</label>
                          <input type="date"  class="form-control" name="datedebut">
                       
                        <label class="control-label">DATE FIN</label>
                          <input type="date"  class="form-control" name="datefin">
                        
                        <label class="control-label">PRIX LOCATION</label>
                          <input type="number"  class="form-control" name="prix">
                      
                        <label class="control-label">KILOMETRAGE DEBUT</label>
                          <input type="number"  class="form-control" name="kmdebut">
                       
                        <label class="control-label">KILOMETRAGE FIN</label>
                          <input type="number" class="form-control" name="kmfin">
                     
                        </div>
                        <label class="control-label">DETAILS</label>
                         <textarea name="details" id="" class="form-control" ></textarea>
                        </div>
      
                       <div class="#" style="text-align: center">
                     <button type="submit" class=" btn btn-primary">ENREGISTRER</button>
                      <div>
              </form>
            </div>
            
          </div>
        </div>
      </div>


    </section>
    <!-- /.content -->
  </div>

@endsection