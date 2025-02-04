@extends('layouts.master')
@section('content')

 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>RESSOURECES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Ressource</li>
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

            <div class="card">
              <div class="card-header" style="text-align:center; !important">
                <h3 class="card-title " >LISTE DES RESSOURCES</h3>
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
                    <th>TYPE</th>
                    <th >RUBRIQUE</th>
                    <th >ACTION</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ( $ressources as $key=>$ressour )
                        
                    
                    <tr class="gradeX">
                      <td >{{ ++$key }}</td>
                      <td >{{ date('d-m-Y à H:i', strtotime($ressour->created_at ))}}</td>
                      <td >{{$ressour->Autre}}</td>
                      <td>{{$ressour->Rubrique}}</td>
                      <td >
                           <div class="d-flex btn btn-default btn-xs" >
                         
                              <button type="button" class="btn btn-xs btn-primary" style="margin: 1px" data-toggle="modal" data-target="#edditModal{{$ressour->id}}">
                              <i class="fa fa-edit"></i> Modifier
                                  </button>
                          {{-- <a href="{{route('projets.show', $ressour->id)}}" style="margin: 1px" class="btn btn-sm btn-info "> <i class="fa fa-list"></i> </a>
                       --}}
                      
                     
                      </div>
  
                      </td>
                      
                    </tr>
  
  
  <div class="modal fade " id="edditModal{{$ressour->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">MODIFIER LA RESSOURCE</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <form  class="form-horizontal style-form" action="{{route('Ressources.update',$ressour->id)}}" method="POST">
                @csrf
              @method('PUT')
                  <div class="form-group row col-sm-12">
                    <div class="col-sm-6">
                    <label class=" control-label">TYPE</label>
                      <select name="type" required class="form-control" id="type">
                        <option value="{{$ressour->Autre}}">{{$ressour->Autre}}</option>
                        <option value="SORTIE DE CAISSE">SORTIE DE CAISSE</option>
                        <option value="ENTREE EN CAISSE">ENTREE EN CAISSE</option>
                      </select>
                    </div>
                 
                    <div class="col-sm-6">
                    <label class="control-label">RUBRIQUE</label>
                      <input type="text" value="{{$ressour->Rubrique}}" class="form-control" name="rubrique">
                    </div>
                    </div>
  
  
                   <div class="" style="text-align: center;">
                      <br>
                 <button type="submit" class=" btn btn-warning">ENREGISTRER</button>
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
              <h5 class="modal-title" id="exampleModalLabel">AJOUTER UNE RESSOURCE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
               <form  class="form-horizontal style-form" action="{{route('Ressources.store')}}" method="POST">
                    @csrf
                 
                      <div class="form-group row col-sm-12">
                        <div class="col-sm-6">
                        <label class=" control-label">Type</label>
                        <select name="type" required class="form-control" id="">
                          <option value="">Choix du type</option>
                          <option value="SORTIE DE CAISSE">SORTIE DE CAISSE</option>
                          <option value="ENTREE EN CAISSE">ENTRE EN CAISSE</option>
                        </select>
                        </div>
                        <div class="col-sm-6">
                        <label class="control-label">RUBRIQUE</label>
                          <input type="text" required class="form-control" name="rubrique">
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


    </section>
    <!-- /.content -->
  </div>

@endsection