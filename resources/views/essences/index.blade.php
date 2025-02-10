@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>PLIEN D'ESSENCE</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Plien Esssence</li>
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
            <!-- /.card -->

            <div class="card">
              <div class="card-header" style="text-align:center; !important">
                <h3 class="card-title " >LISTE DES PLIENS D'ESSENCE</h3>
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
                    <th >PRIX/L</th>
                    <th >QTE</th>
                    <th >MONTANT</th>
                    {{-- <th >KILOMETRAGE</th> --}}
                    <th ></th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ( $essences as $key=>$essence )
                        
                    
                    <tr class="gradeX">
                      <td >{{ ++$key }}</td>
                      <td >{{ date('d-m-Y à H:i', strtotime($essence->Date ))}}</td>
                      <td >{{$essence->vehicule->Marque}} ({{$essence->vehicule->Matriculation}})</td>
                      <td>{{$essence->PrixLitre}}</td>
                      <td>{{$essence->QTELitre}}</td>
                      <td>{{$essence->Montant}}</td>
                      <td >
                           <div class="d-flex btn btn-default btn-xs" >
                         
                              <button type="button" class="btn btn-xs btn-primary" style="margin: 1px" data-toggle="modal" data-target="#edditModal{{$essence->id}}">
                              <i class="fa fa-edit"></i> Modifier
                                  </button>
                          {{-- <a href="{{route('projets.show', $essence->id)}}" style="margin: 1px" class="btn btn-sm btn-info "> <i class="fa fa-list"></i> </a>
                       --}}
                      
                     
                      </div>
  
                      </td>
                      
                    </tr>
  
  
  <div class="modal fade " id="edditModal{{$essence->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">MODIFIER</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form  class="form-horizontal style-form" action="{{route('Essences.update',$essence->id)}}" method="POST">
                @csrf
              @method('PUT')
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                      <label class="control-label">VEHICULE</label>
                      <select name="vehicule" class="form-control"  required id="">
                        @foreach ( $voitures as $vehicule )
                        <option {{ $essence->vehicule_id === $vehicule->id ? "selected" : ""}} value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                          
                        @endforeach
                      </select>
                     
                    <label class="control-label">PRIX/LITRE</label>
                      <input type="number" value="{{$essence->PrixLitre}}" class="form-control" name="prixlitre">
                   
                    <label class="control-label">MONTANT TOTAL</label>
                      <input type="number" value="{{$essence->Montant}}" class="form-control" name="montant">
               
                    <label class="control-label">QUANTITE LITRES</label>
                      <input type="number" value="{{$essence->QTELitre}}" class="form-control" name="qtelitre">
                    </div>
                    <div class="col-sm-6">
                      <label class="control-label">CONDUCTEUR</label>
                      <select name="conducteur" class="form-control"  required id="">
                        @foreach ( $membres as $conducteur )
                        <option {{$essence->conducteur_id === $conducteur->id ? "selected" : ""}} value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                          
                        @endforeach
                      </select>
                    <label class="control-label">KILOMETRAGE DEBUT</label>
                      <input type="number" value="{{$essence->KmgDebut}}" class="form-control" name="kmgdebut">
                  
                    <label class="control-label">KILOMETRAGE FIN</label>
                      <input type="number" value="{{$essence->KmgFin}}" class="form-control" name="kmgfin">
                  
                      <label class="control-label">DATE </label>
                        <input type="date" value="{{$essence->Date}}" class="form-control" name="date">
                      </div>
                    <div class="col-sm-6">
                    </div>
                    <label class="control-label">DESCRIPTION</label>
                      <textarea name="description" id="" class="form-control">{{$essence->Description}}</textarea>
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
               <form  class="form-horizontal style-form" action="{{route('Essences.store')}}" method="POST">
                    @csrf
                 
                      <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                          <label class="control-label">VEHICULE</label>
                          <select name="vehicule" class="form-control"  required id="">
                            <option value="">Choix Véhicule</option>
                            @foreach ( $voitures as $vehicule )
                            <option value="{{$vehicule->id}}">{{$vehicule->Matriculation}} {{$vehicule->Marque}} {{$vehicule->Model}}</option>
                              
                            @endforeach
                          </select>
                         
                       
                        <label class="control-label">PRIX/LITRE</label>
                          <input type="number"  class="form-control" name="prixlitre">
                        
                        <label class="control-label">MONTANT TOTAL</label>
                          <input type="number"  class="form-control" name="montant">
                        
                        <label class="control-label">QUANTITE LITRES</label>
                          <input type="number"  class="form-control" name="qtelitre">
                        </div>
                        <div class="col-sm-6">
                          <label class="control-label">CONDUCTEUR</label>
                          <select name="conducteur" class="form-control"  required id="">
                            <option value="">Choix Conducteur</option>
                            @foreach ( $membres as $conducteur )
                            <option value="{{$conducteur->id}}">{{$conducteur->NomPrenom}} ({{$conducteur->Contact}})</option>
                              
                            @endforeach
                          </select>
                        <label class="control-label">KILOMETRAGE DEBUT</label>
                          <input type="number" class="form-control" name="kmgdebut">
                        
                        <label class="control-label">KILOMETRAGE FIN</label>
                          <input type="number"  class="form-control" name="kmgfin">
                       
                          <label class="control-label">DATE </label>
                            <input type="date" class="form-control" name="date">
                        
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