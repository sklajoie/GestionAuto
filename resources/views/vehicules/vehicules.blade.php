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
 <div class="content-wrapper ">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>VEHICULES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
              <li class="breadcrumb-item active">Vehicule</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

     <!-- Main content -->
     <section class="content">
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
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            @if($vehicules)
            @foreach ($vehicules as $vehicule )
            
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                
                <div class="card-header text-muted border-bottom-0">
                  {{$vehicule->Type}}
                </div>
                <div class="card-body pt-0">
                  <div class="row">
                    <div class="col-8">
                      <h2 class="lead">Matricule: <b>{{$vehicule->Matriculation}}</b></h2>
                      <p class="text-muted text-sm">Marque: <b>{{$vehicule->Marque}} </b> </p>
                      <p class="text-muted text-sm">Model: <b>{{$vehicule->Model}} </b> </p>
                      <ul class="ml-4 mb-0 fa-ul text-muted">
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Chassis: {{$vehicule->Chassis}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Nombre Place: {{$vehicule->NombrePlace}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Date Acquisition:  {{$vehicule->DateAcquisition}}</li>
                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span>Couleur:  {{$vehicule->Couleur}}</li>
                      </ul>
                    </div>
                    <div class="col-4 text-center">
                      <img src="assets/dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="text-justify">

                    <a href="{{route('Vehicules.show',$vehicule->id)}}" class="btn btn-info btn-sm btn-app"><i class="fas fa-list"></i>Détails</a>
                    
                    <a href="{{route('Assurances.show',$vehicule->id)}}" class="btn btn-info btn-app btn-sm">
                      @foreach ( $vehicule->assurance as $assurance )
                       @if(diffdate($assurance->DateFin) <= 50) <span class="badge bg-danger">Fin dans {{diffdate($assurance->DateFin)}} jour(s)</span> 
                       @else <span class="badge bg-success">Fin dans {{diffdate($assurance->DateFin)}} jour(s)</span>  
                       @endif
                       @endforeach
                        <i class="fas fa-eye"></i> Assurance </a>

                        <a href="{{route('Visites.show',$vehicule->id)}}" class="btn btn-info btn-app btn-sm">

                          @foreach ( $vehicule->visite as $visite )
                     
                          @if(diffdate($visite->DateFin) <= 30) <span class="badge bg-danger">Fin dans {{diffdate($visite->DateFin)}} jour(s)</span> 
                          @else <span class="badge bg-success">Fin dans {{diffdate($visite->DateFin)}} jour(s)</span>  
                          @endif

                         @endforeach

                          <i class="fas fa-eye"></i>
                           Visite

                           </a>

                           <a href="{{route('Vidanges.show',$vehicule->id)}}" class="btn btn-info btn-sm btn-app">
                            @foreach ( $vehicule->vidanges as $vidange )
                             
                            @if(diffdate($vidange->DateFin) <= 30) <span class="badge bg-danger">Fin dans {{diffdate($vidange->DateFin)}} jour(s)</span> 
                            @else <span class="badge bg-success">Fin dans {{diffdate($vidange->DateFin)}} jour(s)</span>  
                            @endif
                                 @endforeach
                                 <i class="fas fa-eye"></i> Vidange 
                                </a>
                  
                  
                  </div>
                  
                </div>
                
              </div>
              
            </div>

            
         @endforeach
         @endif
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>

@endsection