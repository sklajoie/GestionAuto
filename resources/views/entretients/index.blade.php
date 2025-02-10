@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ENTRETIENS VEHICULE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Entretiens Véhicule</li>
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
                <h3 class="card-title " >LISTE DES ENTRETION</h3>
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
                    <th>DATE </th>
                    <th>VEHICULE</th>
                    <th >MONTANT</th>
                    <th >TYPE</th>
                    {{-- <th >MONTANT</th> --}}
                    <th >KILOMETRAGE</th>
                    <th ></th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ( $entretiens as $key=>$entretien )
                        
                    
                    <tr class="gradeX">
                      <td >{{ ++$key }}</td>
                      <td >{{ date('d-m-Y à H:i', strtotime($entretien->Date ))}}</td>
                      <td >{{$entretien->vehicule->Marque}} ({{$entretien->vehicule->Matriculation}})</td>
                      <td>{{$entretien->Montant}}</td>
                      <td>{{$entretien->Type}}</td>
                      <td>{{$entretien->Kmg}}</td>
                      <td >
                           <div class="d-flex btn btn-default btn-xs" >
                         
                              <button type="button" class="btn btn-xs btn-primary" style="margin: 1px" data-toggle="modal" data-target="#edditModal{{$entretien->id}}">
                              <i class="fa fa-edit"></i> Modifier
                                  </button>
                          {{-- <a href="{{route('projets.show', $entretien->id)}}" style="margin: 1px" class="btn btn-sm btn-info "> <i class="fa fa-list"></i> </a>
                       --}}
                      
                     
                      </div>
  
                      </td>
                      
                    </tr>
  
  
  <div class="modal fade " id="edditModal{{$entretien->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">MODIFIER</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form  class="form-horizontal style-form" action="{{route('Entretiens.update',$entretien->id)}}" enctype="multipart/form-data" method="POST">
                @csrf
              @method('PUT')
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                      <label class="control-label">VEHICULE</label>
                      <select name="vehicule" class="form-control"  required id="">
                        @foreach ( $voitures as $vehicule )
                        <option {{$entretien->vehicule_id ===$vehicule->id ? 'selected' : "" }} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                          
                        @endforeach
                      </select>
                  
                      <label class="control-label">CONDUCTEUR</label>
                      <select name="conducteur" class="form-control"  required id="">
                        @foreach ( $membres as $conducteur )
                        <option {{$entretien->conducteur_id === $conducteur->id ? 'selected' : ""}} value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                          
                        @endforeach
                      </select>
                    
                    <label class="control-label">TYPE ENTRETIEN</label>
                      <input type="text" value="{{$entretien->Type}}" class="form-control" name="type">
                   
                    <label class="control-label">MONTANT</label>
                      <input type="number" value="{{$entretien->Montant}}" class="form-control" name="montant">
                    </div>
                    <div class="col-sm-6">
                    
                    <label class="control-label">DATE </label>
                      <input type="date" value="{{$entretien->Date}}" class="form-control" name="date">
                    
                    <label class="control-label">GARAGE</label>
                      <input type="text" value="{{$entretien->Garage}}" class="form-control" name="garage">
                  
                    <label class="control-label">KILOMETRAGE </label>
                      <input type="number" value="{{$entretien->Kmg}}" class="form-control" name="kmg">
                      <label class="control-label">RAPPEL DANS</label>
                      <select name="rappel" class="form-control"  required id="">
                    <option value="{{$entretien->Rappel}}">{{$entretien->Rappel}}/J</option>
                    <option value="15">1 SEMAINE</option>
                    <option value="30">1 MOIS</option>
                    <option value="60">2 MOIS</option>
                    <option value="90">3 MOIS</option>
                    <option value="360">1 AN</option>
                      </select>
                    </div>
                    <label class="control-label">DESCRIPTION</label>
                      <textarea name="description" id=""class="form-control" >{{$entretien->Description}}</textarea>
                  
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
               <form  class="form-horizontal style-form" enctype="multipart/form-data" action="{{route('Entretiens.store')}}" method="POST">
                    @csrf
                 
                      <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                          <label class="control-label">VEHICULE</label>
                          <select name="vehicule" class="form-control"  required id="">
                            <option value="">Choix du Véhicule</option>
                            @foreach ( $voitures as $vehicule )
                            <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                              
                            @endforeach
                          </select>
                        
                          <label class="control-label">CONDUCTEUR</label>
                          <select name="conducteur" class="form-control"  required id="">
                            <option value="">Choix Conducteur</option>
                            @foreach ( $membres as $conducteur )
                            <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                              
                            @endforeach
                          </select>
                      
                        <label class="control-label">TYPE ENTRETIEN</label>
                          <input type="text"  class="form-control" name="type">
                      
                        <label class="control-label">MONTANT</label>
                          <input type="number"  class="form-control" name="montant">
                        </div>
                        <div class="col-sm-6">
                      
                        <label class="control-label">DATE </label>
                          <input type="date"  class="form-control" name="date">
                       
                        <label class="control-label">GARAGE</label>
                          <input type="text"  class="form-control" name="garage">
                       
                        <label class="control-label">KILOMETRAGE </label>
                          <input type="number"  class="form-control" name="kmg">

                          <label class="control-label">RAPPEL DANS</label>
                          <select name="rappel" class="form-control"  required id="">
                        <option value="">Rappel</option>
                        <option value="15">1 SEMAINE</option>
                        <option value="30">1 MOIS</option>
                        <option value="60">2 MOIS</option>
                        <option value="90">3 MOIS</option>
                        <option value="360">1 AN</option>
                          </select>
                        </div>
                        <label class="control-label">DESCRIPTION</label>
                        <textarea name="description" id="" class="form-control"></textarea>
                      
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