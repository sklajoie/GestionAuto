@extends('layouts.master')
@section('content')

@php
 function diffdatedsh($a)
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

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">TABLEAU DE BORD</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('Accueil')}}">ACCUEIL</a></li>
            <li class="breadcrumb-item active">Tableau de Bord</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-car"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">VEHICULES</span>
              <span class="info-box-number">
                {{$vehicule}}
                {{-- <small>%</small> --}}
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">MOTO</span>
              <span class="info-box-number">{{$motos}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Sales</span>
              <span class="info-box-number">760</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">CONDUCTEURS</span>
              <span class="info-box-number">{{$conducteur}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="card-body">
          <!-- STACKED BAR CHART -->
          <div class="card card-info">
            <div class="card-header">
              {{-- <h3 class="card-title">Stacked Bar Chart</h3> --}}

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="chart">
                <canvas id="myChart" style="min-height: 300px; height: 250px; max-height: 250px; max-width: 90%; background-color:white"></canvas>
              </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
          <!-- MAP & BOX PANE -->

        
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">VEHICULE EN FIN D'ASSURANCE</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>TYPE</th>
                    <th>MATRICULE</th>
                    <th>MARQUE</th>
                    <th>MODEL</th>
                    <th>ASSURANCE</th>
                    <th>DATE FIN</th>
                    <th>JOUR(s) RESTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($assurances as $assurance )
                  <tr>
                    <td>{{ $assurance->vehicule->Type}}</td>
                    <td><a href="#">{{ $assurance->vehicule->Matriculation}}</a></td>
                    <td>{{ $assurance->vehicule->Marque}}</td>
                    <td>{{ $assurance->vehicule->Model}}</td>
                    <td>{{ $assurance->NomAssurance}}</td>
                    <td ><span >{{ date('d-m-Y', strtotime($assurance->DateFin))}} </span> </td>
                    <td><span class="badge badge-danger">Fin dans  {{diffdatedsh($assurance->DateFin)}}  Jour(s)</span></td>
                  </tr>
                  @endforeach
                
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">VEHICULE EN FIN DE VISITE</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>TYPE</th>
                    <th>MATRICULE</th>
                    <th>MARQUE</th>
                    <th>MODEL</th>
                    <th>DATE FIN</th>
                    <th>JOUR(s) RESTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($visites as $visite )
                  <tr>
                    <td>{{ $visite->vehicule->Type}}</td>
                    <td><a href="#">{{ $visite->vehicule->Matriculation}}</a></td>
                    <td>{{ $visite->vehicule->Marque}}</td>
                    <td>{{ $visite->vehicule->Model}}</td>
                    <td ><span >{{ date('d-m-Y', strtotime($visite->DateFin))}} </span> </td>
                    <td><span class="badge badge-danger">Fin dans  {{diffdatedsh($visite->DateFin)}}  Jour(s)</span></td>
                  </tr>
                  @endforeach
                
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
          <!-- TABLE: LATEST ORDERS -->
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">VEHICULE EN FIN DE VIDANGE</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table m-0">
                  <thead>
                  <tr>
                    <th>TYPE</th>
                    <th>MATRICULE</th>
                    <th>MARQUE</th>
                    <th>MODEL</th>
                    <th>KILOMETRAGE</th>
                    <th>DATE FIN</th>
                    <th>JOUR(s) RESTANT</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ( $vidanges as $vidanges )
                  <tr>
                    <td>{{ $vidanges->vehicule->Type}}</td>
                    <td><a href="#">{{ $vidanges->vehicule->Matriculation}}</a></td>
                    <td>{{ $vidanges->vehicule->Marque}}</td>
                    <td>{{ $vidanges->vehicule->Model}}</td>
                    <td>{{ $vidanges->KiloProchainVidange}}</td>
                    <td ><span >{{ date('d-m-Y', strtotime($vidanges->DateFin))}} </span> </td>
                    <td><span class="badge badge-danger">Fin dans  {{diffdatedsh($vidanges->DateFin)}}  Jour(s)</span></td>
                  </tr>
                  @endforeach
                
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
            
            <!-- /.card-footer -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->

        <div class="col-md-4">
          <!-- Info Boxes Style 2 -->
          <div class="info-box mb-3 bg-warning">
            <span class="info-box-icon"><i class="fas fa-tag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Inventory</span>
              <span class="info-box-number">5,200</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-success">
            <span class="info-box-icon"><i class="far fa-heart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Mentions</span>
              <span class="info-box-number">92,050</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-danger">
            <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Downloads</span>
              <span class="info-box-number">114,381</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
          <div class="info-box mb-3 bg-info">
            <span class="info-box-icon"><i class="far fa-comment"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Direct Messages</span>
              <span class="info-box-number">163,921</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div><!--/. container-fluid -->
  </section>
  <!-- /.content -->
</div>


    @endsection